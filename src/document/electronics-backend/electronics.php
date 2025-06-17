<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Allow cross-origin requests, adjust as needed for security in a production environment
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Database connection parameters
$servername = "127.0.0.1"; // Your database server
$username = "root";        // Your database username
$password = "";            // Your database password (empty for XAMPP root by default)
$dbname = "buildingpermit"; // Your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Handle GET request to retrieve data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the latest record from the 'electronics_permits' table
    $sql = "SELECT * FROM electronics_permits ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Send the fetched data as a JSON response
        echo json_encode(["success" => true, "data" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "No data found."]);
    }
}
// Handle POST request to save data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true); // Decode JSON to associative array

    // Check if JSON decoding was successful
    if ($data === null) {
        echo json_encode(["success" => false, "message" => "Invalid JSON input."]);
        $conn->close();
        exit();
    }

    // --- Data preparation and sanitization ---
    // Owner/Applicant Information
    $lastName = $conn->real_escape_string($data['lastName'] ?? '');
    $firstName = $conn->real_escape_string($data['firstName'] ?? '');
    $mi = $conn->real_escape_string($data['mi'] ?? '');
    $tin = $conn->real_escape_string($data['tin'] ?? '');
    
    // Address (nested)
    $address = $data['address'] ?? [];
    $address_no = $conn->real_escape_string($address['no'] ?? '');
    $address_street = $conn->real_escape_string($address['street'] ?? '');
    $address_barangay = $conn->real_escape_string($address['barangay'] ?? '');
    $address_city = $conn->real_escape_string($address['city'] ?? '');
    
    $zip = $conn->real_escape_string($data['zip'] ?? '');
    $phone = $conn->real_escape_string($data['phone'] ?? '');
    $email = $conn->real_escape_string($data['email'] ?? '');

    // Location of Installation (nested)
    $location = $data['location'] ?? [];
    $location_lotNo = $conn->real_escape_string($location['lotNo'] ?? '');
    $location_blkNo = $conn->real_escape_string($location['blkNo'] ?? '');
    $location_tctNo = $conn->real_escape_string($location['tctNo'] ?? '');
    $location_taxDecNo = $conn->real_escape_string($location['taxDecNo'] ?? '');
    $location_street = $conn->real_escape_string($location['street'] ?? '');
    $location_barangay = $conn->real_escape_string($location['barangay'] ?? '');
    $location_city = $conn->real_escape_string($location['city'] ?? '');

    // Scope of Work
    $scope = $conn->real_escape_string($data['scope'] ?? '');
    $scopeOtherDetails = $conn->real_escape_string($data['scopeOtherDetails'] ?? '');

    // Nature of Installation Works/Equipment System Checkboxes (nested, now with shortened names)
    $natureOfCivilStructuralWorks = $data['natureOfCivilStructuralWorks'] ?? []; 
    $nature_telecommunication_system = (int)($natureOfCivilStructuralWorks['staking'] ?? 0); // Corresponds to nature_telecom
    $nature_broadcasting_system = (int)($natureOfCivilStructuralWorks['excavation'] ?? 0); // Corresponds to nature_broadcast
    $nature_television_system = (int)($natureOfCivilStructuralWorks['soilStabilization'] ?? 0); // Corresponds to nature_tv
    $nature_information_technology_system = (int)($natureOfCivilStructuralWorks['pilingWorks'] ?? 0); // Corresponds to nature_it
    $nature_security_alarm_system_etc = (int)($natureOfCivilStructuralWorks['foundation'] ?? 0); // Corresponds to nature_security_alarm
    $nature_electronics_alarm_system = (int)($natureOfCivilStructuralWorks['erectionLifting'] ?? 0); // Corresponds to nature_electronics_alarm
    $nature_sound_communication_system = (int)($natureOfCivilStructuralWorks['concreteFraming'] ?? 0); // Corresponds to nature_sound_comm
    $nature_centralized_clock_system = (int)($natureOfCivilStructuralWorks['structuralSteelFraming'] ?? 0); // Corresponds to nature_central_clock
    $nature_sound_system = (int)($natureOfCivilStructuralWorks['slabs'] ?? 0); // Corresponds to nature_sound_system
    $nature_electronics_control_conveyor_system = (int)($natureOfCivilStructuralWorks['walls'] ?? 0); // Corresponds to nature_elec_control_conveyor
    $nature_electronics_computerized_process_controls_automation_system = (int)($natureOfCivilStructuralWorks['prestressWorks'] ?? 0); // Corresponds to nature_elec_comp_process_auto
    $nature_building_automation_management_control_system = (int)($natureOfCivilStructuralWorks['materialTesting'] ?? 0); // Corresponds to nature_building_auto_mgmt_ctrl
    $nature_building_wiring_utilizing_copper_cable_fiber_optic_cable_or_other_media = (int)($natureOfCivilStructuralWorks['steelTowers'] ?? 0); // Corresponds to nature_building_wiring_cable
    $nature_tanks = (int)($natureOfCivilStructuralWorks['tanks'] ?? 0);
    $nature_others = (int)($natureOfCivilStructuralWorks['others'] ?? 0);
    $nature_others_details = $conn->real_escape_string($natureOfCivilStructuralWorks['othersDetails'] ?? '');
    $prepared_by = $conn->real_escape_string($data['preparedBy'] ?? ''); // Added prepared_by

    // Site Occupancy (nested)
    $siteOccupancy = $data['siteOccupancy'] ?? [];
    $site_building_foot_print = $conn->real_escape_string($siteOccupancy['buildingFootPrint'] ?? '');
    $site_impervious_surface_area = $conn->real_escape_string($siteOccupancy['imperviousSurfaceArea'] ?? '');
    $site_unpaved_surface_area = $conn->real_escape_string($siteOccupancy['unpavedSurfaceArea'] ?? '');
    $site_others = $conn->real_escape_string($siteOccupancy['others'] ?? '');

    // Fire Code Conformance (nested)
    $fireCodeConformance = $data['fireCodeConformance'] ?? [];
    $fire_num_width_exit_doors = (int)($fireCodeConformance['numWidthExitDoors'] ?? 0);
    $fire_width_corridors = (int)($fireCodeConformance['widthCorridors'] ?? 0);
    $fire_distance_fire_exits = (int)($fireCodeConformance['distanceFireExits'] ?? 0);
    $fire_access_public_streets = (int)($fireCodeConformance['accessPublicStreets'] ?? 0);
    $fire_walls = (int)($fireCodeConformance['fireWalls'] ?? 0);
    $fire_fighting_safety = (int)($fireCodeConformance['fireFightingSafety'] ?? 0);
    $fire_smoke_detectors = (int)($fireCodeConformance['smokeDetectors'] ?? 0);
    $fire_emergency_lights = (int)($fireCodeConformance['emergencyLights'] ?? 0);
    $fire_others = (int)($fireCodeConformance['others'] ?? 0);

    // Box 3: Design Professional (nested)
    $designProfessional = $data['designProfessional'] ?? [];
    $design_prof_architect_name = $conn->real_escape_string($designProfessional['architectName'] ?? '');
    $design_prof_date = $conn->real_escape_string($designProfessional['date'] ?? '');
    $design_prof_address = $conn->real_escape_string($designProfessional['address'] ?? '');
    $design_prof_iapoa_no = $conn->real_escape_string($designProfessional['iapoaNo'] ?? '');
    $design_prof_iapoa_validity = $conn->real_escape_string($designProfessional['iapoaValidity'] ?? '');
    $design_prof_prc_no = $conn->real_escape_string($designProfessional['prcNo'] ?? '');
    $design_prof_prc_validity = $conn->real_escape_string($designProfessional['prcValidity'] ?? '');
    $design_prof_ptr_no = $conn->real_escape_string($designProfessional['ptrNo'] ?? '');
    $design_prof_ptr_date_issued = $conn->real_escape_string($designProfessional['ptrDateIssued'] ?? '');
    $design_prof_issued_at = $conn->real_escape_string($designProfessional['issuedAt'] ?? '');
    $design_prof_tin = $conn->real_escape_string($designProfessional['tin'] ?? '');

    // Box 4: Supervisor Architectural (nested)
    $supervisorArchitectural = $data['supervisorArchitectural'] ?? [];
    $supervisor_architectural_name = $conn->real_escape_string($supervisorArchitectural['architectName'] ?? '');
    $supervisor_architectural_date = $conn->real_escape_string($supervisorArchitectural['date'] ?? '');
    $supervisor_architectural_address = $conn->real_escape_string($supervisorArchitectural['address'] ?? '');
    $supervisor_architectural_iapoa_no = $conn->real_escape_string($supervisorArchitectural['iapoaNo'] ?? '');
    $supervisor_architectural_iapoa_validity = $conn->real_escape_string($supervisorArchitectural['iapoaValidity'] ?? '');
    $supervisor_architectural_prc_no = $conn->real_escape_string($supervisorArchitectural['prcNo'] ?? '');
    $supervisor_architectural_prc_validity = $conn->real_escape_string($supervisorArchitectural['prcValidity'] ?? '');
    $supervisor_architectural_ptr_no = $conn->real_escape_string($supervisorArchitectural['ptrNo'] ?? '');
    $supervisor_architectural_ptr_date_issued = $conn->real_escape_string($supervisorArchitectural['ptrDateIssued'] ?? '');
    $supervisor_architectural_issued_at = $conn->real_escape_string($supervisorArchitectural['issuedAt'] ?? '');
    $supervisor_architectural_tin = $conn->real_escape_string($supervisorArchitectural['tin'] ?? '');

    // Box 5: Building Owner (nested)
    $buildingOwner = $data['buildingOwner'] ?? [];
    $building_owner_signature_name = $conn->real_escape_string($buildingOwner['signatureName'] ?? '');
    $building_owner_date = $conn->real_escape_string($buildingOwner['date'] ?? '');
    $building_owner_address = $conn->real_escape_string($buildingOwner['address'] ?? '');
    $building_owner_ctc_no = $conn->real_escape_string($buildingOwner['ctcNo'] ?? '');
    $building_owner_date_issued = $conn->real_escape_string($buildingOwner['dateIssued'] ?? '');
    $building_owner_place_issued = $conn->real_escape_string($buildingOwner['placeIssued'] ?? '');

    // Box 6: Lot Owner (nested)
    $lotOwner = $data['lotOwner'] ?? [];
    $lot_owner_signature_name = $conn->real_escape_string($lotOwner['signatureName'] ?? '');
    $lot_owner_date = $conn->real_escape_string($lotOwner['date'] ?? '');
    $lot_owner_address = $conn->real_escape_string($lotOwner['address'] ?? '');
    $lot_owner_ctc_no = $conn->real_escape_string($lotOwner['ctcNo'] ?? '');
    $lot_owner_date_issued = $conn->real_escape_string($lotOwner['dateIssued'] ?? '');
    $lot_owner_place_issued = $conn->real_escape_string($lotOwner['placeIssued'] ?? '');

    // Box 7: Civil Structural Documents (for Electronics - nested)
    $civilStructuralDocuments = $data['civilStructuralDocuments'] ?? [];
    $doc_designs_computations = (int)($civilStructuralDocuments['designsComputations'] ?? 0);
    $doc_bill_of_materials = (int)($civilStructuralDocuments['billOfMaterials'] ?? 0);
    $doc_cost_estimates = (int)($civilStructuralDocuments['costEstimates'] ?? 0);
    $doc_others = (int)($civilStructuralDocuments['others'] ?? 0);
    $doc_others_details = $conn->real_escape_string($civilStructuralDocuments['othersDetails'] ?? '');


    // Construct the SQL query for insertion into the 'electronics_permits' table
    $sql = "INSERT INTO `electronics_permits` (
                `last_name`, `first_name`, `mi`, `tin`,
                `address_no`, `address_street`, `address_barangay`, `address_city`,
                `zip`, `phone`, `email`,
                `location_lot_no`, `location_blk_no`, `location_tct_no`,
                `location_tax_dec_no`, `location_street`, `location_barangay`, `location_city`,
                `scope`, `scope_other_details`,
                `nature_telecom`, `nature_broadcast`,
                `nature_tv`, `nature_it`,
                `nature_security_alarm`, `nature_electronics_alarm`,
                `nature_sound_comm`, `nature_central_clock`,
                `nature_sound_system`, `nature_elec_control_conveyor`,
                `nature_elec_comp_process_auto`,
                `nature_building_auto_mgmt_ctrl`,
                `nature_building_wiring_cable`,
                `nature_tanks`, `nature_others`, `nature_others_details`, `prepared_by`,
                `site_building_foot_print`, `site_impervious_surface_area`,
                `site_unpaved_surface_area`, `site_others`,
                `fire_num_width_exit_doors`, `fire_width_corridors`,
                `fire_distance_fire_exits`, `fire_access_public_streets`,
                `fire_walls`, `fire_fighting_safety`, `fire_smoke_detectors`,
                `fire_emergency_lights`, `fire_others`,
                `design_prof_architect_name`, `design_prof_date`, `design_prof_address`,
                `design_prof_iapoa_no`, `design_prof_iapoa_validity`, `design_prof_prc_no`,
                `design_prof_prc_validity`, `design_prof_ptr_no`, `design_prof_ptr_date_issued`,
                `design_prof_issued_at`, `design_prof_tin`,
                `supervisor_architectural_name`, `supervisor_architectural_date`,
                `supervisor_architectural_address`, `supervisor_architectural_iapoa_no`,
                `supervisor_architectural_iapoa_validity`, `supervisor_architectural_prc_no`,
                `supervisor_architectural_prc_validity`, `supervisor_architectural_ptr_no`,
                `supervisor_architectural_ptr_date_issued`, `supervisor_architectural_issued_at`,
                `supervisor_architectural_tin`,
                `building_owner_signature_name`, `building_owner_date`, `building_owner_address`,
                `building_owner_ctc_no`, `building_owner_date_issued`, `building_owner_place_issued`,
                `lot_owner_signature_name`, `lot_owner_date`, `lot_owner_address`,
                `lot_owner_ctc_no`, `lot_owner_date_issued`, `lot_owner_place_issued`,
                `doc_designs_comp`, `doc_bill_materials`, `doc_cost_estimates`,
                `doc_others`, `doc_others_details`
            ) VALUES (
                '$lastName', '$firstName', '$mi', '$tin',
                '$address_no', '$address_street', '$address_barangay', '$address_city',
                '$zip', '$phone', '$email',
                '$location_lotNo', '$location_blkNo', '$location_tctNo',
                '$location_taxDecNo', '$location_street', '$location_barangay', '$location_city',
                '$scope', '$scopeOtherDetails',
                $nature_telecommunication_system, $nature_broadcasting_system,
                $nature_television_system, $nature_information_technology_system,
                $nature_security_alarm_system_etc, $nature_electronics_alarm_system,
                $nature_sound_communication_system, $nature_centralized_clock_system,
                $nature_sound_system, $nature_electronics_control_conveyor_system,
                $nature_electronics_computerized_process_controls_automation_system,
                $nature_building_automation_management_control_system,
                $nature_building_wiring_utilizing_copper_cable_fiber_optic_cable_or_other_media,
                $nature_tanks, $nature_others, '$nature_others_details', '$prepared_by',
                '$site_building_foot_print', '$site_impervious_surface_area',
                '$site_unpaved_surface_area', '$site_others',
                $fire_num_width_exit_doors, $fire_width_corridors,
                $fire_distance_fire_exits, $fire_access_public_streets,
                $fire_walls, $fire_fighting_safety, $fire_smoke_detectors,
                $fire_emergency_lights, $fire_others,
                '$design_prof_architect_name', '$design_prof_date', '$design_prof_address',
                '$design_prof_iapoa_no', '$design_prof_iapoa_validity', '$design_prof_prc_no',
                '$design_prof_prc_validity', '$design_prof_ptr_no', '$design_prof_ptr_date_issued',
                '$design_prof_issued_at', '$design_prof_tin',
                '$supervisor_architectural_name', '$supervisor_architectural_date',
                '$supervisor_architectural_address', '$supervisor_architectural_iapoa_no',
                '$supervisor_architectural_iapoa_validity', '$supervisor_architectural_prc_no',
                '$supervisor_architectural_prc_validity', '$supervisor_architectural_ptr_no',
                '$supervisor_architectural_ptr_date_issued', '$supervisor_architectural_issued_at',
                '$supervisor_architectural_tin',
                '$building_owner_signature_name', '$building_owner_date', '$building_owner_address',
                '$building_owner_ctc_no', '$building_owner_date_issued', '$building_owner_place_issued',
                '$lot_owner_signature_name', '$lot_owner_date', '$lot_owner_address',
                '$lot_owner_ctc_no', '$lot_owner_date_issued', '$lot_owner_place_issued',
                $doc_designs_computations, $doc_bill_of_materials, $doc_cost_estimates,
                $doc_others, '$doc_others_details'
            )";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error . ". SQL: " . $sql]);
    }
} else {
    // This block handles OPTIONS requests for CORS pre-flight, or any other unsupported methods
    http_response_code(200); // Respond with OK for OPTIONS requests
}

$conn->close();
?>
