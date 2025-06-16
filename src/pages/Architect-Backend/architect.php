<?php
// Set CORS headers to allow requests from your Vue.js frontend
header("Access-Control-Allow-Origin: http://localhost:3000"); // Adjust this if your Vue app runs on a different port
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight OPTIONS request for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection details
$servername = "127.0.0.1"; // Your localhost server
$username = "root"; // Your database username
$password = ""; // Your database password (empty for XAMPP root)
$dbname = "buildingpermit"; // The database name you created (consistent with unifiedbackend.php)
$table = "buildingpermit"; // The table name you created (same as unified_table for these forms)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("architect.php: Connection failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// --- Handle GET request for pre-filling data ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $unified_app_number = '';
    $where_clause = '';

    // Check if a specific unified_application_number is provided in query params
    if (isset($_GET['unified_application_number']) && !empty($_GET['unified_application_number'])) {
        $unified_app_number = $conn->real_escape_string($_GET['unified_application_number']);
        $where_clause = "WHERE application_number = '$unified_app_number'";
        error_log("architect.php (GET): Fetching by specific application number: " . $unified_app_number);
    } else {
        // If no specific number, try to fetch the most recent entry
        // Requires a 'created_at' TIMESTAMP column in your 'buildingpermit' table
        $where_clause = "ORDER BY created_at DESC LIMIT 1";
        error_log("architect.php (GET): No application number provided, fetching the latest entry.");
    }

    // Fetch data from the buildingpermit table
    $sql_fetch_unified = "SELECT
                            application_number, access_password, application_type, application_status,
                            owner_first_name, owner_middle_name, owner_last_name, owner_tin,
                            owner_is_enterprise_owned, owner_form_ownership, owner_address_no,
                            owner_address_street, owner_address_barangay, owner_address_municipal,
                            owner_address_zip_code, owner_contact_number, owner_email,
                            const_lot_no, const_blk_no, const_tct_no, const_tax_dec_no,
                            const_street, const_barangay, const_municipal,
                            scope_of_work, other_scope_of_work, occupancy_group,
                            occupancy_type, other_occupancy_type, occupancy_classified, number_of_units,
                            number_of_storey, total_floor_area, lot_area, cost_building,
                            cost_electrical, cost_mechanical, cost_electronics, cost_plumbing,
                            cost_equipment, proposed_date, expected_date,
                            architectural_facilities,
                            site_occupancy_building_foot_print, site_occupancy_impervious_surface_area,
                            site_occupancy_unpaved_surface_area, site_occupancy_others,
                            fire_code_num_width_exit_doors, fire_code_width_corridors,
                            fire_code_distance_fire_exits, fire_code_access_public_streets,
                            fire_code_fire_walls, fire_code_fire_fighting_safety,
                            fire_code_smoke_detectors, fire_code_emergency_lights, fire_code_others,
                            building_owner_signature_name, building_owner_date, building_owner_address,
                            building_owner_ctc_no, building_owner_date_issued, building_owner_place_issued,
                            architectural_documents, architectural_documents_others_details
                          FROM $table
                          $where_clause";

    error_log("architect.php (GET): Executing query: " . $sql_fetch_unified);

    $result_unified = $conn->query($sql_fetch_unified);

    if ($result_unified && $result_unified->num_rows > 0) {
        $unified_data = $result_unified->fetch_assoc();

        $architectural_facilities_decoded = json_decode($unified_data['architectural_facilities'] ?? '{}', true);
        $architectural_documents_decoded = json_decode($unified_data['architectural_documents'] ?? '{}', true);

        if (is_array($architectural_facilities_decoded) && empty($architectural_facilities_decoded)) {
            $architectural_facilities_decoded = (object)[];
        }
        if (is_array($architectural_documents_decoded) && empty($architectural_documents_decoded)) {
            $architectural_documents_decoded = (object)[];
        }

        $response_data = [
            'unifiedApplicationNumber' => $unified_data['application_number'] ?? '',
            'ownerApplicantInfo' => [
                'lastName' => $unified_data['owner_last_name'] ?? '',
                'firstName' => $unified_data['owner_first_name'] ?? '',
                'mi' => $unified_data['owner_middle_name'] ?? '',
                'tin' => $unified_data['owner_tin'] ?? '',
                'address' => [
                    'no' => $unified_data['owner_address_no'] ?? '',
                    'street' => $unified_data['owner_address_street'] ?? '',
                    'barangay' => $unified_data['owner_address_barangay'] ?? '',
                    'city' => $unified_data['owner_address_municipal'] ?? '',
                ],
                'zip' => $unified_data['owner_address_zip_code'] ?? '',
                'phone' => $unified_data['owner_contact_number'] ?? '',
                'email' => $unified_data['owner_email'] ?? '',
            ],
            'locationOfInstallation' => [
                'lotNo' => $unified_data['const_lot_no'] ?? '',
                'blkNo' => $unified_data['const_blk_no'] ?? '',
                'tctNo' => $unified_data['const_tct_no'] ?? '',
                'taxDecNo' => $unified_data['const_tax_dec_no'] ?? '',
                'street' => $unified_data['const_street'] ?? '',
                'barangay' => $unified_data['const_barangay'] ?? '',
                'city' => $unified_data['const_municipal'] ?? '',
            ],
            'scopeOfWork' => [
                'scope' => '', // Mapped below from the database string
                'scopeOtherDetails' => $unified_data['other_scope_of_work'] ?? '',
            ],
            'architecturalFacilities' => $architectural_facilities_decoded,
            'siteOccupancy' => [
                'buildingFootPrint' => (float)($unified_data['site_occupancy_building_foot_print'] ?? 0.00),
                'imperviousSurfaceArea' => (float)($unified_data['site_occupancy_impervious_surface_area'] ?? 0.00),
                'unpavedSurfaceArea' => (float)($unified_data['site_occupancy_unpaved_surface_area'] ?? 0.00),
                'others' => $unified_data['site_occupancy_others'] ?? '',
            ],
            'fireCodeConformance' => [
                'numWidthExitDoors' => (bool)($unified_data['fire_code_num_width_exit_doors'] ?? 0),
                'widthCorridors' => (bool)($unified_data['fire_code_width_corridors'] ?? 0),
                'distanceFireExits' => (bool)($unified_data['fire_code_distance_fire_exits'] ?? 0),
                'accessPublicStreets' => (bool)($unified_data['fire_code_access_public_streets'] ?? 0),
                'fireWalls' => (bool)($unified_data['fire_code_fire_walls'] ?? 0),
                'fireFightingSafety' => (bool)($unified_data['fire_code_fire_fighting_safety'] ?? 0),
                'smokeDetectors' => (bool)($unified_data['fire_code_smoke_detectors'] ?? 0),
                'emergencyLights' => (bool)($unified_data['fire_code_emergency_lights'] ?? 0),
                'others' => (bool)($unified_data['fire_code_others'] ?? 0),
            ],
            'buildingOwner' => [
                'signatureName' => $unified_data['building_owner_signature_name'] ?? '',
                'date' => $unified_data['building_owner_date'] ?? '',
                'address' => $unified_data['building_owner_address'] ?? '',
                'ctcNo' => $unified_data['building_owner_ctc_no'] ?? '',
                'dateIssued' => $unified_data['building_owner_date_issued'] ?? '',
                'placeIssued' => $unified_data['building_owner_place_issued'] ?? '',
            ],
            'architecturalDocuments' => $architectural_documents_decoded,
            'architecturalDocumentsDetails' => $unified_data['architectural_documents_others_details'] ?? '',
        ];

        $db_scope_value = $unified_data['scope_of_work'] ?? '';
        switch ($db_scope_value) {
            case 'newInstallation':
            case 'NEW CONSTRUCTION':
                $response_data['scopeOfWork']['scope'] = 'newInstallation';
                break;
            case 'additionExtension':
            case 'ADDITION':
            case 'EXTENSION':
                $response_data['scopeOfWork']['scope'] = 'additionExtension';
                break;
            case 'repairRenovation':
            case 'REPAIR':
            case 'RENOVATION':
                $response_data['scopeOfWork']['scope'] = 'repairRenovation';
                break;
            case 'removalDemolition':
            case 'REMOVAL':
            case 'DEMOLITION':
                $response_data['scopeOfWork']['scope'] = 'removalDemolition';
                break;
            case 'othersScope':
            case 'Others':
                $response_data['scopeOfWork']['scope'] = 'othersScope';
                break;
            default:
                $response_data['scopeOfWork']['scope'] = '';
                break;
        }

        echo json_encode(["success" => true, "data" => $response_data]);
    } else {
        echo json_encode(["success" => false, "message" => "Unified application number not found or no data."]);
    }
    exit();
}

// --- Handle POST request for saving data (updating existing record) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    // --- DEBUGGING LOGS FOR POST REQUEST ---
    error_log("architect.php (POST): Raw JSON data received: " . $json_data);
    error_log("architect.php (POST): Decoded data array: " . print_r($data, true));
    // --- END DEBUGGING LOGS ---

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("architect.php (POST): Invalid JSON data received. Error: " . json_last_error_msg());
        echo json_encode(["success" => false, "message" => "Invalid JSON data received."]);
        exit();
    }

    $unified_application_number = $conn->real_escape_string($data['unifiedApplicationNumber'] ?? '');
    if (empty($unified_application_number)) {
        error_log("architect.php (POST): Application number is required for update but was empty.");
        echo json_encode(["success" => false, "message" => "Application number is required for update."]);
        exit();
    }

    $owner_last_name = $conn->real_escape_string($data['ownerApplicantInfo']['lastName'] ?? '');
    $owner_first_name = $conn->real_escape_string($data['ownerApplicantInfo']['firstName'] ?? '');
    $owner_middle_initial = $conn->real_escape_string($data['ownerApplicantInfo']['mi'] ?? '');
    $owner_tin = $conn->real_escape_string($data['ownerApplicantInfo']['tin'] ?? '');
    $owner_address_no = $conn->real_escape_string($data['ownerApplicantInfo']['address']['no'] ?? '');
    $owner_address_street = $conn->real_escape_string($data['ownerApplicantInfo']['address']['street'] ?? '');
    $owner_address_barangay = $conn->real_escape_string($data['ownerApplicantInfo']['address']['barangay'] ?? '');
    $owner_address_city = $conn->real_escape_string($data['ownerApplicantInfo']['address']['city'] ?? '');
    $owner_zip_code = $conn->real_escape_string($data['ownerApplicantInfo']['zip'] ?? '');
    $owner_phone = $conn->real_escape_string($data['ownerApplicantInfo']['phone'] ?? '');
    $owner_email = $conn->real_escape_string($data['ownerApplicantInfo']['email'] ?? '');

    $location_lot_no = $conn->real_escape_string($data['locationOfInstallation']['lotNo'] ?? '');
    $location_blk_no = $conn->real_escape_string($data['locationOfInstallation']['blkNo'] ?? '');
    $location_tct_no = $conn->real_escape_string($data['locationOfInstallation']['tctNo'] ?? '');
    $location_tax_dec_no = $conn->real_escape_string($data['locationOfInstallation']['taxDecNo'] ?? '');
    $location_street = $conn->real_escape_string($data['locationOfInstallation']['street'] ?? '');
    $location_barangay = $conn->real_escape_string($data['locationOfInstallation']['barangay'] ?? '');
    $location_city = $conn->real_escape_string($data['locationOfInstallation']['city'] ?? '');

    $scope_of_work_architectural = $conn->real_escape_string($data['scopeOfWork']['scope'] ?? '');
    $scope_other_details_architectural = $conn->real_escape_string($data['scopeOfWork']['scopeOtherDetails'] ?? '');

    $architectural_facilities = json_encode($data['architecturalFacilities'] ?? (object)[]);
    if ($architectural_facilities === false) {
        error_log("architect.php (POST): JSON encoding error for architecturalFacilities. Falling back to empty object. Error: " . json_last_error_msg());
        $architectural_facilities = '{}';
    }

    $site_occupancy_building_foot_print = (float)($data['siteOccupancy']['buildingFootPrint'] ?? 0.00);
    $site_occupancy_impervious_surface_area = (float)($data['siteOccupancy']['imperviousSurfaceArea'] ?? 0.00);
    $site_occupancy_unpaved_surface_area = (float)($data['siteOccupancy']['unpavedSurfaceArea'] ?? 0.00);
    $site_occupancy_others = $conn->real_escape_string($data['siteOccupancy']['others'] ?? '');

    $fire_code_num_width_exit_doors = isset($data['fireCodeConformance']['numWidthExitDoors']) ? (int)$data['fireCodeConformance']['numWidthExitDoors'] : 0;
    $fire_code_width_corridors = isset($data['fireCodeConformance']['widthCorridors']) ? (int)$data['fireCodeConformance']['widthCorridors'] : 0;
    $fire_code_distance_fire_exits = isset($data['fireCodeConformance']['distanceFireExits']) ? (int)$data['fireCodeConformance']['distanceFireExits'] : 0;
    $fire_code_access_public_streets = isset($data['fireCodeConformance']['accessPublicStreets']) ? (int)$data['fireCodeConformance']['accessPublicStreets'] : 0;
    $fire_code_fire_walls = isset($data['fireCodeConformance']['fireWalls']) ? (int)$data['fireCodeConformance']['fireWalls'] : 0;
    $fire_code_fire_fighting_safety = isset($data['fireCodeConformance']['fireFightingSafety']) ? (int)$data['fireCodeConformance']['fireFightingSafety'] : 0;
    $fire_code_smoke_detectors = isset($data['fireCodeConformance']['smokeDetectors']) ? (int)$data['fireCodeConformance']['smokeDetectors'] : 0;
    $fire_code_emergency_lights = isset($data['fireCodeConformance']['emergencyLights']) ? (int)$data['fireCodeConformance']['emergencyLights'] : 0;
    $fire_code_others = isset($data['fireCodeConformance']['others']) ? (int)$data['fireCodeConformance']['others'] : 0;

    $building_owner_signature_name = $conn->real_escape_string($data['buildingOwner']['signatureName'] ?? '');
    $building_owner_date = $conn->real_escape_string($data['buildingOwner']['date'] ?? '');
    $building_owner_address = $conn->real_escape_string($data['buildingOwner']['address'] ?? '');
    $building_owner_ctc_no = $conn->real_escape_string($data['buildingOwner']['ctcNo'] ?? '');
    $building_owner_date_issued = $conn->real_escape_string($data['buildingOwner']['dateIssued'] ?? '');
    $building_owner_place_issued = $conn->real_escape_string($data['buildingOwner']['placeIssued'] ?? '');

    $architectural_documents = json_encode($data['architecturalDocuments'] ?? (object)[]);
    if ($architectural_documents === false) {
        error_log("architect.php (POST): JSON encoding error for architecturalDocuments. Falling back to empty object. Error: " . json_last_error_msg());
        $architectural_documents = '{}';
    }
    $architectural_documents_others_details = $conn->real_escape_string($data['architecturalDocumentsDetails'] ?? '');

    // SQL UPDATE statement
    // Note: The date fields use a ternary operator to save NULL if empty, which is good.
    $sql = "UPDATE $table SET
                owner_last_name = '$owner_last_name',
                owner_first_name = '$owner_first_name',
                owner_middle_name = '$owner_middle_initial',
                owner_tin = '$owner_tin',
                owner_address_no = '$owner_address_no',
                owner_address_street = '$owner_address_street',
                owner_address_barangay = '$owner_address_barangay',
                owner_address_municipal = '$owner_address_city',
                owner_address_zip_code = '$owner_zip_code',
                owner_contact_number = '$owner_phone',
                owner_email = '$owner_email',

                const_lot_no = '$location_lot_no',
                const_blk_no = '$location_blk_no',
                const_tct_no = '$location_tct_no',
                const_tax_dec_no = '$location_tax_dec_no',
                const_street = '$location_street',
                const_barangay = '$location_barangay',
                const_municipal = '$location_city',

                scope_of_work = '$scope_of_work_architectural',
                other_scope_of_work = '$scope_other_details_architectural',

                architectural_facilities = '$architectural_facilities',
                site_occupancy_building_foot_print = $site_occupancy_building_foot_print,
                site_occupancy_impervious_surface_area = $site_occupancy_impervious_surface_area,
                site_occupancy_unpaved_surface_area = $site_occupancy_unpaved_surface_area,
                site_occupancy_others = '$site_occupancy_others',
                fire_code_num_width_exit_doors = $fire_code_num_width_exit_doors,
                fire_code_width_corridors = $fire_code_width_corridors,
                fire_code_distance_fire_exits = $fire_code_distance_fire_exits,
                fire_code_access_public_streets = $fire_code_access_public_streets,
                fire_code_fire_walls = $fire_code_fire_walls,
                fire_code_fire_fighting_safety = $fire_code_fire_fighting_safety,
                fire_code_smoke_detectors = $fire_code_smoke_detectors,
                fire_code_emergency_lights = $fire_code_emergency_lights,
                fire_code_others = $fire_code_others,
                building_owner_signature_name = '$building_owner_signature_name',
                building_owner_date = " . ($building_owner_date ? "'$building_owner_date'" : "NULL") . ",
                building_owner_address = '$building_owner_address',
                building_owner_ctc_no = '$building_owner_ctc_no',
                building_owner_date_issued = " . ($building_owner_date_issued ? "'$building_owner_date_issued'" : "NULL") . ",
                building_owner_place_issued = '$building_owner_place_issued',
                architectural_documents = '$architectural_documents',
                architectural_documents_others_details = '$architectural_documents_others_details'
            WHERE application_number = '$unified_application_number'";

    error_log("architect.php (POST): Executing update query: " . $sql);
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Architectural record updated successfully"]);
    } else {
        error_log("architect.php (POST) Error: " . $sql . "\n" . $conn->error);
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method. Only GET and POST requests are allowed."]);
}

$conn->close();
?>
