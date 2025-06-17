<?php
// Set headers for CORS and JSON content type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database Configuration
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "buildingpermit"; // Your database name (as provided in prompt)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Helper function to sanitize string input
function sanitize($conn, $data, $key, $default = '') {
    return $conn->real_escape_string($data[$key] ?? $default);
}

// Helper function to convert boolean-like values for DB (0 or 1)
function toBoolean($value) {
    return (int)($value ?? false);
}

// Helper function for bind_param to pass values by reference
function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) // PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

// Handle GET request to retrieve data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the latest record from the 'structural_permits' table
    $sql = "SELECT * FROM structural_permits ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Construct the response data to match the frontend's nested structure
        $responseData = [
            'lastName' => $row['last_name'] ?? '',
            'firstName' => $row['first_name'] ?? '',
            'mi' => $row['middle_initial'] ?? '',
            'tin' => $row['tin'] ?? '',
            'address' => [
                'no' => $row['owner_address_no'] ?? '',
                'street' => $row['owner_address_street'] ?? '',
                'barangay' => $row['owner_address_barangay'] ?? '',
                'city' => $row['owner_address_city'] ?? ''
            ],
            'zip' => $row['zip_code'] ?? '',
            'phone' => $row['phone_number'] ?? '',
            'email' => $row['email_address'] ?? '',
            'location' => [
                'lotNo' => $row['location_lot_no'] ?? '',
                'blkNo' => $row['location_blk_no'] ?? '',
                'tctNo' => $row['location_tct_no'] ?? '',
                'taxDecNo' => $row['location_tax_dec_no'] ?? '',
                'street' => $row['location_street'] ?? '',
                'barangay' => $row['location_barangay'] ?? '',
                'city' => $row['location_city'] ?? ''
            ],
            'scope' => $row['scope_of_work'] ?? '',
            'scopeOtherDetails' => $row['scope_other_details'] ?? '',
            'natureOfCivilStructuralWorks' => [
                'staking' => (bool)($row['nature_staking'] ?? false),
                'excavation' => (bool)($row['nature_excavation'] ?? false),
                'soilStabilization' => (bool)($row['nature_soil_stabilization'] ?? false),
                'pilingWorks' => (bool)($row['nature_piling_works'] ?? false),
                'foundation' => (bool)($row['nature_foundation'] ?? false),
                'erectionLifting' => (bool)($row['nature_erection_lifting'] ?? false),
                'concreteFraming' => (bool)($row['nature_concrete_framing'] ?? false),
                'structuralSteelFraming' => (bool)($row['nature_structural_steel_framing'] ?? false),
                'slabs' => (bool)($row['nature_slabs'] ?? false),
                'walls' => (bool)($row['nature_walls'] ?? false),
                'prestressWorks' => (bool)($row['nature_prestress_works'] ?? false),
                'materialTesting' => (bool)($row['nature_material_testing'] ?? false),
                'steelTowers' => (bool)($row['nature_steel_towers'] ?? false),
                'tanks' => (bool)($row['nature_tanks'] ?? false),
                'others' => (bool)($row['nature_others'] ?? false),
                'othersDetails' => $row['nature_others_details'] ?? '',
            ],
            // siteOccupancy and fireCodeConformance are in the data model for consistency
            'siteOccupancy' => [
                'buildingFootPrint' => $row['site_building_foot_print'] ?? '',
                'imperviousSurfaceArea' => $row['site_impervious_surface_area'] ?? '',
                'unpavedSurfaceArea' => $row['site_unpaved_surface_area'] ?? '',
                'others' => $row['site_others'] ?? '',
            ],
            'fireCodeConformance' => [
                'numWidthExitDoors' => (bool)($row['fire_num_width_exit_doors'] ?? false),
                'widthCorridors' => (bool)($row['fire_width_corridors'] ?? false),
                'distanceFireExits' => (bool)($row['fire_distance_fire_exits'] ?? false),
                'accessPublicStreets' => (bool)($row['fire_access_public_streets'] ?? false),
                'fireWalls' => (bool)($row['fire_walls'] ?? false),
                'fireFightingSafety' => (bool)($row['fire_fighting_safety'] ?? false),
                'smokeDetectors' => (bool)($row['fire_smoke_detectors'] ?? false),
                'emergencyLights' => (bool)($row['fire_emergency_lights'] ?? false),
                'others' => (bool)($row['fire_others'] ?? false),
            ],
            'designProfessional' => [
                'architectName' => $row['design_prof_architect_name'] ?? '',
                'date' => $row['design_prof_date'] ?? '',
                'address' => $row['design_prof_address'] ?? '',
                'iapoaNo' => $row['design_prof_iapoa_no'] ?? '',
                'iapoaValidity' => $row['design_prof_iapoa_validity'] ?? '',
                'prcNo' => $row['design_prof_prc_no'] ?? '',
                'prcValidity' => $row['design_prof_prc_validity'] ?? '',
                'ptrNo' => $row['design_prof_ptr_no'] ?? '',
                'ptrDateIssued' => $row['design_prof_ptr_date_issued'] ?? '',
                'issuedAt' => $row['design_prof_issued_at'] ?? '',
                'tin' => $row['design_prof_tin'] ?? '',
            ],
            'supervisorArchitectural' => [
                'architectName' => $row['supervisor_architectural_name'] ?? '',
                'date' => $row['supervisor_architectural_date'] ?? '',
                'address' => $row['supervisor_architectural_address'] ?? '',
                'iapoaNo' => $row['supervisor_architectural_iapoa_no'] ?? '',
                'iapoaValidity' => $row['supervisor_architectural_iapoa_validity'] ?? '',
                'prcNo' => $row['supervisor_architectural_prc_no'] ?? '',
                'prcValidity' => $row['supervisor_architectural_prc_validity'] ?? '',
                'ptrNo' => $row['supervisor_architectural_ptr_no'] ?? '',
                'ptrDateIssued' => $row['supervisor_architectural_ptr_date_issued'] ?? '',
                'issuedAt' => $row['supervisor_architectural_issued_at'] ?? '',
                'tin' => $row['supervisor_architectural_tin'] ?? '',
            ],
            'buildingOwner' => [
                'signatureName' => $row['building_owner_signature_name'] ?? '',
                'date' => $row['building_owner_date'] ?? '',
                'address' => $row['building_owner_address'] ?? '',
                'ctcNo' => $row['building_owner_ctc_no'] ?? '',
                'dateIssued' => $row['building_owner_date_issued'] ?? '',
                'placeIssued' => $row['building_owner_place_issued'] ?? '',
            ],
            'lotOwner' => [
                'signatureName' => $row['lot_owner_signature_name'] ?? '',
                'date' => $row['lot_owner_date'] ?? '',
                'address' => $row['lot_owner_address'] ?? '',
                'ctcNo' => $row['lot_owner_ctc_no'] ?? '',
                'dateIssued' => $row['lot_owner_date_issued'] ?? '',
                'placeIssued' => $row['lot_owner_place_issued'] ?? '',
            ],
            'civilStructuralDocuments' => [
                'designsComputations' => (bool)($row['doc_designs_computations'] ?? false),
                'billOfMaterials' => (bool)($row['doc_bill_of_materials'] ?? false),
                'costEstimates' => (bool)($row['doc_cost_estimates'] ?? false),
                'others' => (bool)($row['doc_others'] ?? false),
                'othersDetails' => $row['doc_others_details'] ?? '',
            ],
            // Note: Box 8 (Progress Flow Table) elements are static in your Vue template
            // and do not have corresponding v-models, so they are not included in the data mapping.
            // If you intend for them to be saved/loaded, they need to be interactive fields in the frontend.
        ];
        echo json_encode(["success" => true, "data" => $responseData]);
    } else {
        echo json_encode(["success" => false, "message" => "No data found."]);
    }
}
// Handle POST request to save data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Invalid JSON input."]);
        exit();
    }

    // Prepare data for insertion
    $fields = [];
    $values = [];
    $types = ""; // String for bind_param types

    // Owner/Applicant Information
    $fields[] = "`last_name`"; $values[] = sanitize($conn, $data, 'lastName'); $types .= "s";
    $fields[] = "`first_name`"; $values[] = sanitize($conn, $data, 'firstName'); $types .= "s";
    $fields[] = "`middle_initial`"; $values[] = sanitize($conn, $data, 'mi'); $types .= "s";
    $fields[] = "`tin`"; $values[] = sanitize($conn, $data, 'tin'); $types .= "s";
    $fields[] = "`owner_address_no`"; $values[] = sanitize($conn, $data['address'] ?? [], 'no'); $types .= "s";
    $fields[] = "`owner_address_street`"; $values[] = sanitize($conn, $data['address'] ?? [], 'street'); $types .= "s";
    $fields[] = "`owner_address_barangay`"; $values[] = sanitize($conn, $data['address'] ?? [], 'barangay'); $types .= "s";
    $fields[] = "`owner_address_city`"; $values[] = sanitize($conn, $data['address'] ?? [], 'city'); $types .= "s";
    $fields[] = "`zip_code`"; $values[] = sanitize($conn, $data, 'zip'); $types .= "s";
    $fields[] = "`phone_number`"; $values[] = sanitize($conn, $data, 'phone'); $types .= "s";
    $fields[] = "`email_address`"; $values[] = sanitize($conn, $data, 'email'); $types .= "s";

    // Location of Installation
    $fields[] = "`location_lot_no`"; $values[] = sanitize($conn, $data['location'] ?? [], 'lotNo'); $types .= "s";
    $fields[] = "`location_blk_no`"; $values[] = sanitize($conn, $data['location'] ?? [], 'blkNo'); $types .= "s";
    $fields[] = "`location_tct_no`"; $values[] = sanitize($conn, $data['location'] ?? [], 'tctNo'); $types .= "s";
    $fields[] = "`location_tax_dec_no`"; $values[] = sanitize($conn, $data['location'] ?? [], 'taxDecNo'); $types .= "s";
    $fields[] = "`location_street`"; $values[] = sanitize($conn, $data['location'] ?? [], 'street'); $types .= "s";
    $fields[] = "`location_barangay`"; $values[] = sanitize($conn, $data['location'] ?? [], 'barangay'); $types .= "s";
    $fields[] = "`location_city`"; $values[] = sanitize($conn, $data['location'] ?? [], 'city'); $types .= "s";

    // Scope of Work
    $fields[] = "`scope_of_work`"; $values[] = sanitize($conn, $data, 'scope'); $types .= "s";
    $fields[] = "`scope_other_details`"; $values[] = sanitize($conn, $data, 'scopeOtherDetails'); $types .= "s";

    // Nature of Civil/Structural Works
    $fields[] = "`nature_staking`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['staking']); $types .= "i";
    $fields[] = "`nature_excavation`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['excavation']); $types .= "i";
    $fields[] = "`nature_soil_stabilization`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['soilStabilization']); $types .= "i";
    $fields[] = "`nature_piling_works`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['pilingWorks']); $types .= "i";
    $fields[] = "`nature_foundation`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['foundation']); $types .= "i";
    $fields[] = "`nature_erection_lifting`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['erectionLifting']); $types .= "i";
    $fields[] = "`nature_concrete_framing`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['concreteFraming']); $types .= "i";
    $fields[] = "`nature_structural_steel_framing`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['structuralSteelFraming']); $types .= "i";
    $fields[] = "`nature_slabs`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['slabs']); $types .= "i";
    $fields[] = "`nature_walls`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['walls']); $types .= "i";
    $fields[] = "`nature_prestress_works`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['prestressWorks']); $types .= "i";
    $fields[] = "`nature_material_testing`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['materialTesting']); $types .= "i";
    $fields[] = "`nature_steel_towers`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['steelTowers']); $types .= "i";
    $fields[] = "`nature_tanks`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['tanks']); $types .= "i";
    $fields[] = "`nature_others`"; $values[] = toBoolean($data['natureOfCivilStructuralWorks']['others']); $types .= "i";
    $fields[] = "`nature_others_details`"; $values[] = sanitize($conn, $data['natureOfCivilStructuralWorks'] ?? [], 'othersDetails'); $types .= "s";

    // Site Occupancy
    $fields[] = "`site_building_foot_print`"; $values[] = sanitize($conn, $data['siteOccupancy'] ?? [], 'buildingFootPrint'); $types .= "s";
    $fields[] = "`site_impervious_surface_area`"; $values[] = sanitize($conn, $data['siteOccupancy'] ?? [], 'imperviousSurfaceArea'); $types .= "s";
    $fields[] = "`site_unpaved_surface_area`"; $values[] = sanitize($conn, $data['siteOccupancy'] ?? [], 'unpavedSurfaceArea'); $types .= "s";
    $fields[] = "`site_others`"; $values[] = sanitize($conn, $data['siteOccupancy'] ?? [], 'others'); $types .= "s";

    // Fire Code Conformance
    $fields[] = "`fire_num_width_exit_doors`"; $values[] = toBoolean($data['fireCodeConformance']['numWidthExitDoors']); $types .= "i";
    $fields[] = "`fire_width_corridors`"; $values[] = toBoolean($data['fireCodeConformance']['widthCorridors']); $types .= "i";
    $fields[] = "`fire_distance_fire_exits`"; $values[] = toBoolean($data['fireCodeConformance']['distanceFireExits']); $types .= "i";
    $fields[] = "`fire_access_public_streets`"; $values[] = toBoolean($data['fireCodeConformance']['accessPublicStreets']); $types .= "i";
    $fields[] = "`fire_walls`"; $values[] = toBoolean($data['fireCodeConformance']['fireWalls']); $types .= "i";
    $fields[] = "`fire_fighting_safety`"; $values[] = toBoolean($data['fireCodeConformance']['fireFightingSafety']); $types .= "i";
    $fields[] = "`fire_smoke_detectors`"; $values[] = toBoolean($data['fireCodeConformance']['smokeDetectors']); $types .= "i";
    $fields[] = "`fire_emergency_lights`"; $values[] = toBoolean($data['fireCodeConformance']['emergencyLights']); $types .= "i";
    $fields[] = "`fire_others`"; $values[] = toBoolean($data['fireCodeConformance']['others']); $types .= "i";

    // Box 3: Design Professional
    $fields[] = "`design_prof_architect_name`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'architectName'); $types .= "s";
    $fields[] = "`design_prof_date`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'date'); $types .= "s";
    $fields[] = "`design_prof_address`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'address'); $types .= "s";
    $fields[] = "`design_prof_iapoa_no`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'iapoaNo'); $types .= "s";
    $fields[] = "`design_prof_iapoa_validity`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'iapoaValidity'); $types .= "s";
    $fields[] = "`design_prof_prc_no`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'prcNo'); $types .= "s";
    $fields[] = "`design_prof_prc_validity`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'prcValidity'); $types .= "s";
    $fields[] = "`design_prof_ptr_no`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'ptrNo'); $types .= "s";
    $fields[] = "`design_prof_ptr_date_issued`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'ptrDateIssued'); $types .= "s";
    $fields[] = "`design_prof_issued_at`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'issuedAt'); $types .= "s";
    $fields[] = "`design_prof_tin`"; $values[] = sanitize($conn, $data['designProfessional'] ?? [], 'tin'); $types .= "s";

    // Box 4: Supervisor / In-Charge of Architectural Works
    $fields[] = "`supervisor_architectural_name`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'architectName'); $types .= "s";
    $fields[] = "`supervisor_architectural_date`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'date'); $types .= "s";
    $fields[] = "`supervisor_architectural_address`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'address'); $types .= "s";
    $fields[] = "`supervisor_architectural_iapoa_no`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'iapoaNo'); $types .= "s";
    $fields[] = "`supervisor_architectural_iapoa_validity`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'iapoaValidity'); $types .= "s";
    $fields[] = "`supervisor_architectural_prc_no`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'prcNo'); $types .= "s";
    $fields[] = "`supervisor_architectural_prc_validity`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'prcValidity'); $types .= "s";
    $fields[] = "`supervisor_architectural_ptr_no`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'ptrNo'); $types .= "s";
    $fields[] = "`supervisor_architectural_ptr_date_issued`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'ptrDateIssued'); $types .= "s";
    $fields[] = "`supervisor_architectural_issued_at`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'issuedAt'); $types .= "s";
    $fields[] = "`supervisor_architectural_tin`"; $values[] = sanitize($conn, $data['supervisorArchitectural'] ?? [], 'tin'); $types .= "s";

    // Box 5: Building Owner
    $fields[] = "`building_owner_signature_name`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'signatureName'); $types .= "s";
    $fields[] = "`building_owner_date`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'date'); $types .= "s";
    $fields[] = "`building_owner_address`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'address'); $types .= "s";
    $fields[] = "`building_owner_ctc_no`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'ctcNo'); $types .= "s";
    $fields[] = "`building_owner_date_issued`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'dateIssued'); $types .= "s";
    $fields[] = "`building_owner_place_issued`"; $values[] = sanitize($conn, $data['buildingOwner'] ?? [], 'placeIssued'); $types .= "s";

    // Box 6: Lot Owner
    $fields[] = "`lot_owner_signature_name`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'signatureName'); $types .= "s";
    $fields[] = "`lot_owner_date`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'date'); $types .= "s";
    $fields[] = "`lot_owner_address`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'address'); $types .= "s";
    $fields[] = "`lot_owner_ctc_no`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'ctcNo'); $types .= "s";
    $fields[] = "`lot_owner_date_issued`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'dateIssued'); $types .= "s";
    $fields[] = "`lot_owner_place_issued`"; $values[] = sanitize($conn, $data['lotOwner'] ?? [], 'placeIssued'); $types .= "s";

    // Box 7: Civil/Structural Documents
    $fields[] = "`doc_designs_computations`"; $values[] = toBoolean($data['civilStructuralDocuments']['designsComputations']); $types .= "i";
    $fields[] = "`doc_bill_of_materials`"; $values[] = toBoolean($data['civilStructuralDocuments']['billOfMaterials']); $types .= "i";
    $fields[] = "`doc_cost_estimates`"; $values[] = toBoolean($data['civilStructuralDocuments']['costEstimates']); $types .= "i";
    $fields[] = "`doc_others`"; $values[] = toBoolean($data['civilStructuralDocuments']['others']); $types .= "i";
    $fields[] = "`doc_others_details`"; $values[] = sanitize($conn, $data['civilStructuralDocuments'] ?? [], 'othersDetails'); $types .= "s";

    // Construct the INSERT statement
    $sql = "INSERT INTO `structural_permits` (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_fill(0, count($fields), '?')) . ")";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }

    // Bind parameters dynamically
    // The first argument to call_user_func_array is a reference to the statement's bind_param method,
    // and the second argument is an array of parameters. The first element of this array
    // must be the type string, followed by the values themselves.
    array_unshift($values, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($values));

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error . ". SQL: " . $sql]); // Include SQL for debugging
    }

    $stmt->close();

} else {
    // This block handles unsupported methods
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
}

$conn->close();

?>
```