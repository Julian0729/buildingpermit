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

// Helper function to sanitize input
function sanitize($conn, $data, $key, $default = '') {
    return $conn->real_escape_string($data[$key] ?? $default);
}

// Helper function to convert boolean-like values for DB
function toBoolean($value) {
    return (int)($value ?? false);
}

// Handle GET request to retrieve data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the latest record from the 'sanitary_plumbing_permits' table
    $sql = "SELECT * FROM sanitary_plumbing_permits ORDER BY id DESC LIMIT 1";
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
            'fixtures' => [], // Populate dynamically
            'totalFixtures' => $row['total_fixtures'] ?? 0,
            'systemType' => [
                'waterDistribution' => (bool)($row['system_type_water_distribution'] ?? false),
                'sanitarySewer' => (bool)($row['system_type_sanitary_sewer'] ?? false),
                'stormDrainage' => (bool)($row['system_type_storm_drainage'] ?? false)
            ],
            'waterSupply' => [
                'shallowWell' => (bool)($row['water_supply_shallow_well'] ?? false),
                'deepWellPumpSet' => (bool)($row['water_supply_deep_well_pump_set'] ?? false),
                'cityMunicipalWaterSystem' => (bool)($row['water_supply_city_municipal_water_system'] ?? false),
                'others' => (bool)($row['water_supply_others'] ?? false),
                'othersDetails' => $row['water_supply_others_details'] ?? ''
            ],
            'systemDisposal' => [
                'wasteWaterTreatmentPlant' => (bool)($row['system_disposal_waste_water_treatment_plant'] ?? false),
                'septicVaultImhoffTank' => (bool)($row['system_disposal_septic_vault_imhoff_tank'] ?? false),
                'sanitarySewerConnection' => (bool)($row['system_disposal_sanitary_sewer_connection'] ?? false),
                'subSurfaceSandFilter' => (bool)($row['system_disposal_sub_surface_sand_filter'] ?? false),
                'surfaceDrainage' => (bool)($row['system_disposal_surface_drainage'] ?? false),
                'streetCanal' => (bool)($row['system_disposal_street_canal'] ?? false),
                'waterCourse' => (bool)($row['system_disposal_water_course'] ?? false)
            ],
            'buildingDetails' => [
                'numStorey' => $row['building_num_storey'] ?? '',
                'totalArea' => $row['building_total_area'] ?? '',
                'proposedDateOfConstruction' => $row['building_proposed_date_of_construction'] ?? '',
                'totalCostOfInstallation' => $row['building_total_cost_of_installation'] ?? '',
                'expectedDateOfCompletion' => $row['building_expected_date_of_completion'] ?? '',
                'preparedBy' => $row['building_prepared_by'] ?? ''
            ],
            'buildingDocuments' => [
                'plansAndSpecs' => (bool)($row['doc_plans_and_specs'] ?? false),
                'billOfMaterials' => (bool)($row['doc_bill_of_materials'] ?? false),
                'costEstimates' => (bool)($row['doc_cost_estimates'] ?? false),
                'others' => (bool)($row['doc_others'] ?? false),
                'othersDetails' => $row['doc_others_details'] ?? ''
            ],
            'box4Entries' => [ // Populate dynamically
                ['label' => 'Application Fees', 'amountDue' => $row['box4_application_fees_amount'] ?? '', 'assessedBy' => $row['box4_application_fees_assessed_by'] ?? '', 'orNo' => $row['box4_application_fees_or_no'] ?? '', 'datePaid' => $row['box4_application_fees_date_paid'] ?? ''],
                ['label' => 'Permit Fees', 'amountDue' => $row['box4_permit_fees_amount'] ?? '', 'assessedBy' => $row['box4_permit_fees_assessed_by'] ?? '', 'orNo' => $row['box4_permit_fees_or_no'] ?? '', 'datePaid' => $row['box4_permit_fees_date_paid'] ?? ''],
                ['label' => 'Inspection Fees', 'amountDue' => $row['box4_inspection_fees_amount'] ?? '', 'assessedBy' => $row['box4_inspection_fees_assessed_by'] ?? '', 'orNo' => $row['box4_inspection_fees_or_no'] ?? '', 'datePaid' => $row['box4_inspection_fees_date_paid'] ?? ''],
                ['label' => 'Fines/Penalties', 'amountDue' => $row['box4_fines_penalties_amount'] ?? '', 'assessedBy' => $row['box4_fines_penalties_assessed_by'] ?? '', 'orNo' => $row['box4_fines_penalties_or_no'] ?? '', 'datePaid' => $row['box4_fines_penalties_date_paid'] ?? ''],
                ['label' => 'Other Charges', 'amountDue' => $row['box4_other_charges_amount'] ?? '', 'assessedBy' => $row['box4_other_charges_assessed_by'] ?? '', 'orNo' => $row['box4_other_charges_or_no'] ?? '', 'datePaid' => $row['box4_other_charges_date_paid'] ?? ''],
            ],
            'box5Entries' => [ // Populate dynamically
                ['label' => 'NOTED', 'inTime' => $row['box5_noted_in_time'] ?? '', 'inDate' => $row['box5_noted_in_date'] ?? '', 'outTime' => $row['box5_noted_out_time'] ?? '', 'outDate' => $row['box5_noted_out_date'] ?? '', 'actionRemarks' => $row['box5_noted_action_remarks'] ?? '', 'processedBy' => $row['box5_noted_processed_by'] ?? ''],
                ['label' => 'CHIEF-PROCESSING DIVISION/SECTION', 'inTime' => $row['box5_chief_in_time'] ?? '', 'inDate' => $row['box5_chief_in_date'] ?? '', 'outTime' => $row['box5_chief_out_time'] ?? '', 'outDate' => $row['box5_chief_out_date'] ?? '', 'actionRemarks' => $row['box5_chief_action_remarks'] ?? '', 'processedBy' => $row['box5_chief_processed_by'] ?? ''],
                ['label' => 'RECEIVING AND RECORDING', 'inTime' => $row['box5_receiving_in_time'] ?? '', 'inDate' => $row['box5_receiving_in_date'] ?? '', 'outTime' => $row['box5_receiving_out_time'] ?? '', 'outDate' => $row['box5_receiving_out_date'] ?? '', 'actionRemarks' => $row['box5_receiving_action_remarks'] ?? '', 'processedBy' => $row['box5_receiving_processed_by'] ?? ''],
                ['label' => 'GEODETIC (LINE AND GRADE)', 'inTime' => $row['box5_geodetic_in_time'] ?? '', 'inDate' => $row['box5_geodetic_in_date'] ?? '', 'outTime' => $row['box5_geodetic_out_time'] ?? '', 'outDate' => $row['box5_geodetic_out_date'] ?? '', 'actionRemarks' => $row['box5_geodetic_action_remarks'] ?? '', 'processedBy' => $row['box5_geodetic_processed_by'] ?? ''],
                ['label' => 'SANITARY', 'inTime' => $row['box5_sanitary_in_time'] ?? '', 'inDate' => $row['box5_sanitary_in_date'] ?? '', 'outTime' => $row['box5_sanitary_out_time'] ?? '', 'outDate' => $row['box5_sanitary_out_date'] ?? '', 'actionRemarks' => $row['box5_sanitary_action_remarks'] ?? '', 'processedBy' => $row['box5_sanitary_processed_by'] ?? ''],
            ],
            'box6' => [
                'engineerName' => $row['box6_engineer_name'] ?? '',
                'date' => $row['box6_date'] ?? '',
                'address' => $row['box6_address'] ?? '',
                'prcNo' => $row['box6_prc_no'] ?? '',
                'validity' => $row['box6_validity'] ?? '',
                'ptrNo' => $row['box6_ptr_no'] ?? '',
                'dateIssued' => $row['box6_date_issued'] ?? '',
                'issuedAt' => $row['box6_issued_at'] ?? '',
                'tin' => $row['box6_tin'] ?? ''
            ],
            'box7' => [
                'engineerName' => $row['box7_engineer_name'] ?? '',
                'date' => $row['box7_date'] ?? '',
                'address' => $row['box7_address'] ?? '',
                'prcNo' => $row['box7_prc_no'] ?? '',
                'validity' => $row['box7_validity'] ?? '',
                'ptrNo' => $row['box7_ptr_no'] ?? '',
                'dateIssued' => $row['box7_date_issued'] ?? '',
                'issuedAt' => $row['box7_issued_at'] ?? '',
                'tin' => $row['box7_tin'] ?? ''
            ],
            'box8' => [
                'signedName' => $row['box8_signed_name'] ?? '',
                'date' => $row['box8_date'] ?? '',
                'ctcNo' => $row['box8_ctc_no'] ?? '',
                'dateIssued' => $row['box8_date_issued'] ?? '',
                'placeIssued' => $row['box8_place_issued'] ?? ''
            ]
        ];

        // Dynamically populate fixtures
        $fixtureList = [
            'waterCloset', 'floorDrain', 'lavatories', 'kitchenSink', 'faucet',
            'showerHead', 'waterMeter', 'greaseTrap', 'bathTubs', 'slopSinks',
            'urinal', 'airconUnit', 'waterTankReservoir', 'bidet', 'laundryTrays',
            'dentalCuspidor', 'gasHeater', 'electricalHeater', 'waterBoiler',
            'drinkingFountain', 'barSink', 'sodaFountainSink', 'lavatorySink',
            'sterilizer', 'swimmingPool', 'othersFixture'
        ];
        foreach ($fixtureList as $fixtureName) {
            $responseData['fixtures'][$fixtureName] = [
                'qty' => $row['fixture_' . $fixtureName . '_qty'] ?? null,
                'selected' => (bool)($row['fixture_' . $fixtureName . '_selected'] ?? false)
            ];
        }
        $responseData['fixtures']['othersFixture']['details'] = $row['fixture_othersFixture_details'] ?? '';


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
    $params = []; // Array to hold references for bind_param
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

    // Fixture Schedule
    $fixtureList = [
        'waterCloset', 'floorDrain', 'lavatories', 'kitchenSink', 'faucet',
        'showerHead', 'waterMeter', 'greaseTrap', 'bathTubs', 'slopSinks',
        'urinal', 'airconUnit', 'waterTankReservoir', 'bidet', 'laundryTrays',
        'dentalCuspidor', 'gasHeater', 'electricalHeater', 'waterBoiler',
        'drinkingFountain', 'barSink', 'sodaFountainSink', 'lavatorySink',
        'sterilizer', 'swimmingPool', 'othersFixture'
    ];

    foreach ($fixtureList as $fixtureName) {
        $fields[] = "`fixture_" . $fixtureName . "_qty`";
        $qty = filter_var($data['fixtures'][$fixtureName]['qty'] ?? null, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $values[] = $qty;
        $types .= ($qty === null) ? "s" : "i"; // Use 's' if null, 'i' if integer (to handle null for INT type in prepared statements)

        $fields[] = "`fixture_" . $fixtureName . "_selected`";
        $values[] = toBoolean($data['fixtures'][$fixtureName]['selected'] ?? false);
        $types .= "i"; // Boolean (tinyint) for selected
    }
    // Handle othersFixture_details separately
    $fields[] = "`fixture_othersFixture_details`";
    $values[] = sanitize($conn, $data['fixtures']['othersFixture'] ?? [], 'details');
    $types .= "s";
    
    $fields[] = "`total_fixtures`";
    $totalFixtures = filter_var($data['totalFixtures'] ?? null, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    $values[] = $totalFixtures;
    $types .= ($totalFixtures === null) ? "s" : "i";


    // System Type
    $fields[] = "`system_type_water_distribution`"; $values[] = toBoolean($data['systemType']['waterDistribution']); $types .= "i";
    $fields[] = "`system_type_sanitary_sewer`"; $values[] = toBoolean($data['systemType']['sanitarySewer']); $types .= "i";
    $fields[] = "`system_type_storm_drainage`"; $values[] = toBoolean($data['systemType']['stormDrainage']); $types .= "i";

    // Water Supply
    $fields[] = "`water_supply_shallow_well`"; $values[] = toBoolean($data['waterSupply']['shallowWell']); $types .= "i";
    $fields[] = "`water_supply_deep_well_pump_set`"; $values[] = toBoolean($data['waterSupply']['deepWellPumpSet']); $types .= "i";
    $fields[] = "`water_supply_city_municipal_water_system`"; $values[] = toBoolean($data['waterSupply']['cityMunicipalWaterSystem']); $types .= "i";
    $fields[] = "`water_supply_others`"; $values[] = toBoolean($data['waterSupply']['others']); $types .= "i";
    $fields[] = "`water_supply_others_details`"; $values[] = sanitize($conn, $data['waterSupply'] ?? [], 'othersDetails'); $types .= "s";

    // System Disposal System
    $fields[] = "`system_disposal_waste_water_treatment_plant`"; $values[] = toBoolean($data['systemDisposal']['wasteWaterTreatmentPlant']); $types .= "i";
    $fields[] = "`system_disposal_septic_vault_imhoff_tank`"; $values[] = toBoolean($data['systemDisposal']['septicVaultImhoffTank']); $types .= "i";
    $fields[] = "`system_disposal_sanitary_sewer_connection`"; $values[] = toBoolean($data['systemDisposal']['sanitarySewerConnection']); $types .= "i";
    $fields[] = "`system_disposal_sub_surface_sand_filter`"; $values[] = toBoolean($data['systemDisposal']['subSurfaceSandFilter']); $types .= "i";
    $fields[] = "`system_disposal_surface_drainage`"; $values[] = toBoolean($data['systemDisposal']['surfaceDrainage']); $types .= "i";
    $fields[] = "`system_disposal_street_canal`"; $values[] = toBoolean($data['systemDisposal']['streetCanal']); $types .= "i";
    $fields[] = "`system_disposal_water_course`"; $values[] = toBoolean($data['systemDisposal']['waterCourse']); $types .= "i";

    // Building Details
    $fields[] = "`building_num_storey`"; $values[] = sanitize($conn, $data['buildingDetails'] ?? [], 'numStorey'); $types .= "s";
    $fields[] = "`building_total_area`";
    $totalArea = filter_var($data['buildingDetails']['totalArea'] ?? null, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $values[] = $totalArea;
    $types .= ($totalArea === null) ? "s" : "d";

    $fields[] = "`building_proposed_date_of_construction`"; $values[] = sanitize($conn, $data['buildingDetails'] ?? [], 'proposedDateOfConstruction'); $types .= "s";
    $fields[] = "`building_total_cost_of_installation`";
    $totalCost = filter_var($data['buildingDetails']['totalCostOfInstallation'] ?? null, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $values[] = $totalCost;
    $types .= ($totalCost === null) ? "s" : "d";

    $fields[] = "`building_expected_date_of_completion`"; $values[] = sanitize($conn, $data['buildingDetails'] ?? [], 'expectedDateOfCompletion'); $types .= "s";
    $fields[] = "`building_prepared_by`"; $values[] = sanitize($conn, $data['buildingDetails'] ?? [], 'preparedBy'); $types .= "s";

    // Building Documents
    $fields[] = "`doc_plans_and_specs`"; $values[] = toBoolean($data['buildingDocuments']['plansAndSpecs']); $types .= "i";
    $fields[] = "`doc_bill_of_materials`"; $values[] = toBoolean($data['buildingDocuments']['billOfMaterials']); $types .= "i";
    $fields[] = "`doc_cost_estimates`"; $values[] = toBoolean($data['buildingDocuments']['costEstimates']); $types .= "i";
    $fields[] = "`doc_others`"; $values[] = toBoolean($data['buildingDocuments']['others']); $types .= "i";
    $fields[] = "`doc_others_details`"; $values[] = sanitize($conn, $data['buildingDocuments'] ?? [], 'othersDetails'); $types .= "s";

    // Box 4 Fees - Flattened
    $box4Labels = ['Application Fees', 'Permit Fees', 'Inspection Fees', 'Fines/Penalties', 'Other Charges'];
    $box4DbKeys = ['application_fees', 'permit_fees', 'inspection_fees', 'fines_penalties', 'other_charges'];

    foreach ($box4Labels as $idx => $label) {
        $entry = $data['box4Entries'][$idx] ?? [];
        $dbKey = $box4DbKeys[$idx];

        $fields[] = "`box4_" . $dbKey . "_amount`";
        $amount = filter_var($entry['amountDue'] ?? null, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
        $values[] = $amount;
        $types .= ($amount === null) ? "s" : "d";

        $fields[] = "`box4_" . $dbKey . "_assessed_by`"; $values[] = sanitize($conn, $entry, 'assessedBy'); $types .= "s";
        $fields[] = "`box4_" . $dbKey . "_or_no`"; $values[] = sanitize($conn, $entry, 'orNo'); $types .= "s";
        $fields[] = "`box4_" . $dbKey . "_date_paid`"; $values[] = sanitize($conn, $entry, 'datePaid'); $types .= "s";
    }

    // Box 5 Progress Flow - Flattened
    $box5Labels = ['NOTED', 'CHIEF-PROCESSING DIVISION/SECTION', 'RECEIVING AND RECORDING', 'GEODETIC (LINE AND GRADE)', 'SANITARY'];
    $box5DbKeys = ['noted', 'chief', 'receiving', 'geodetic', 'sanitary'];

    foreach ($box5Labels as $idx => $label) {
        $entry = $data['box5Entries'][$idx] ?? [];
        $dbKey = $box5DbKeys[$idx];

        $fields[] = "`box5_" . $dbKey . "_in_time`"; $values[] = sanitize($conn, $entry, 'inTime'); $types .= "s";
        $fields[] = "`box5_" . $dbKey . "_in_date`"; $values[] = sanitize($conn, $entry, 'inDate'); $types .= "s";
        $fields[] = "`box5_" . $dbKey . "_out_time`"; $values[] = sanitize($conn, $entry, 'outTime'); $types .= "s";
        $fields[] = "`box5_" . $dbKey . "_out_date`"; $values[] = sanitize($conn, $entry, 'outDate'); $types .= "s";
        $fields[] = "`box5_" . $dbKey . "_action_remarks`"; $values[] = sanitize($conn, $entry, 'actionRemarks'); $types .= "s";
        $fields[] = "`box5_" . $dbKey . "_processed_by`"; $values[] = sanitize($conn, $entry, 'processedBy'); $types .= "s";
    }

    // Box 6: Design Professional
    $fields[] = "`box6_engineer_name`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'engineerName'); $types .= "s";
    $fields[] = "`box6_date`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'date'); $types .= "s";
    $fields[] = "`box6_address`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'address'); $types .= "s";
    $fields[] = "`box6_prc_no`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'prcNo'); $types .= "s";
    $fields[] = "`box6_validity`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'validity'); $types .= "s";
    $fields[] = "`box6_ptr_no`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'ptrNo'); $types .= "s";
    $fields[] = "`box6_date_issued`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'dateIssued'); $types .= "s";
    $fields[] = "`box6_issued_at`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'issuedAt'); $types .= "s";
    $fields[] = "`box6_tin`"; $values[] = sanitize($conn, $data['box6'] ?? [], 'tin'); $types .= "s";

    // Box 7: Supervisor/In-Charge of Sanitary/Plumbing Works
    $fields[] = "`box7_engineer_name`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'engineerName'); $types .= "s";
    $fields[] = "`box7_date`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'date'); $types .= "s";
    $fields[] = "`box7_address`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'address'); $types .= "s";
    $fields[] = "`box7_prc_no`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'prcNo'); $types .= "s";
    $fields[] = "`box7_validity`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'validity'); $types .= "s";
    $fields[] = "`box7_ptr_no`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'ptrNo'); $types .= "s";
    $fields[] = "`box7_date_issued`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'dateIssued'); $types .= "s";
    $fields[] = "`box7_issued_at`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'issuedAt'); $types .= "s";
    $fields[] = "`box7_tin`"; $values[] = sanitize($conn, $data['box7'] ?? [], 'tin'); $types .= "s";

    // Box 8: Applicant
    $fields[] = "`box8_signed_name`"; $values[] = sanitize($conn, $data['box8'] ?? [], 'signedName'); $types .= "s";
    $fields[] = "`box8_date`"; $values[] = sanitize($conn, $data['box8'] ?? [], 'date'); $types .= "s";
    $fields[] = "`box8_ctc_no`"; $values[] = sanitize($conn, $data['box8'] ?? [], 'ctcNo'); $types .= "s";
    $fields[] = "`box8_date_issued`"; $values[] = sanitize($conn, $data['box8'] ?? [], 'dateIssued'); $types .= "s";
    $fields[] = "`box8_place_issued`"; $values[] = sanitize($conn, $data['box8'] ?? [], 'placeIssued'); $types .= "s";

    $stmt = $conn->prepare("INSERT INTO `sanitary_plumbing_permits` (" . implode(', ', $fields) . ") VALUES (" . implode(', ', array_fill(0, count($fields), '?')) . ")");

    // Bind parameters dynamically
    // The first argument to call_user_func_array is a reference to the statement's bind_param method,
    // and the second argument is an array of parameters. The first element of this array
    // must be the type string, followed by the values themselves.
    array_unshift($values, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($values));

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error . ". SQL: " . $stmt->sql]); // Include SQL for debugging
    }

    $stmt->close();

} else {
    // This block handles unsupported methods
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
}

$conn->close();

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

?>
```