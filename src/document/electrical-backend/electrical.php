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
$dbname = "buildingpermit"; // Your database name (as confirmed, using 'buildingpermit' database)

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Handle GET request to retrieve data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the latest record from the 'electrical' table
    $sql = "SELECT * FROM electrical ORDER BY id DESC LIMIT 1";
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
    
    $address_no = $conn->real_escape_string($data['address']['no'] ?? '');
    $address_street = $conn->real_escape_string($data['address']['street'] ?? '');
    $address_barangay = $conn->real_escape_string($data['address']['barangay'] ?? '');
    $address_city = $conn->real_escape_string($data['address']['city'] ?? '');
    
    $zip = $conn->real_escape_string($data['zip'] ?? '');
    $phone = $conn->real_escape_string($data['phone'] ?? '');
    $email = $conn->real_escape_string($data['email'] ?? '');

    // Location of Installation
    $location_lotNo = $conn->real_escape_string($data['location']['lotNo'] ?? '');
    $location_blkNo = $conn->real_escape_string($data['location']['blkNo'] ?? '');
    $location_tctNo = $conn->real_escape_string($data['location']['tctNo'] ?? '');
    $location_taxDecNo = $conn->real_escape_string($data['location']['taxDecNo'] ?? '');
    $location_street = $conn->real_escape_string($data['location']['street'] ?? '');
    $location_barangay = $conn->real_escape_string($data['location']['barangay'] ?? '');
    $location_city = $conn->real_escape_string($data['location']['city'] ?? '');

    // Scope of Work
    $scope = $conn->real_escape_string($data['scope'] ?? '');
    $scopeOtherDetails = $conn->real_escape_string($data['scopeOtherDetails'] ?? '');

    // Summary of Electrical Loads/Capacities Applied For
    $totalConnectedLoads = $conn->real_escape_string($data['electricalSummary']['totalConnectedLoads'] ?? '');
    $totalTransformerCapacity = $conn->real_escape_string($data['electricalSummary']['totalTransformerCapacity'] ?? '');
    $totalGeneratorUpsCapacity = $conn->real_escape_string($data['electricalSummary']['totalGeneratorUpsCapacity'] ?? '');

    // Box 2: Design Professional Electrical Engineer
    $designProf_name = $conn->real_escape_string($data['designProfessionalElectrical']['name'] ?? '');
    $designProf_date = $conn->real_escape_string($data['designProfessionalElectrical']['date'] ?? '');
    $designProf_address = $conn->real_escape_string($data['designProfessionalElectrical']['address'] ?? '');
    $designProf_prcNo = $conn->real_escape_string($data['designProfessionalElectrical']['prcNo'] ?? '');
    $designProf_prcValidity = $conn->real_escape_string($data['designProfessionalElectrical']['prcValidity'] ?? '');
    $designProf_ptrNo = $conn->real_escape_string($data['designProfessionalElectrical']['ptrNo'] ?? '');
    $designProf_ptrDateIssued = $conn->real_escape_string($data['designProfessionalElectrical']['ptrDateIssued'] ?? '');
    $designProf_issuedAt = $conn->real_escape_string($data['designProfessionalElectrical']['issuedAt'] ?? '');
    $designProf_tin = $conn->real_escape_string($data['designProfessionalElectrical']['tin'] ?? '');

    // Box 3: Supervisor/In-Charge Professional Plans and Specifications
    $supervisor_peEngineer = (int)($data['supervisorProfessional']['peEngineer'] ?? 0);
    $supervisor_reEngineer = (int)($data['supervisorProfessional']['reEngineer'] ?? 0);
    $supervisor_masterElectrician = (int)($data['supervisorProfessional']['masterElectrician'] ?? 0);
    $supervisor_name = $conn->real_escape_string($data['supervisorProfessional']['name'] ?? '');
    $supervisor_date = $conn->real_escape_string($data['supervisorProfessional']['date'] ?? '');
    $supervisor_address = $conn->real_escape_string($data['supervisorProfessional']['address'] ?? '');
    $supervisor_prcNo = $conn->real_escape_string($data['supervisorProfessional']['prcNo'] ?? '');
    $supervisor_prcValidity = $conn->real_escape_string($data['supervisorProfessional']['prcValidity'] ?? '');
    $supervisor_ptrNo = $conn->real_escape_string($data['supervisorProfessional']['ptrNo'] ?? '');
    $supervisor_ptrDateIssued = $conn->real_escape_string($data['supervisorProfessional']['ptrDateIssued'] ?? '');
    $supervisor_issuedAt = $conn->real_escape_string($data['supervisorProfessional']['issuedAt'] ?? '');
    $supervisor_tin = $conn->real_escape_string($data['supervisorProfessional']['tin'] ?? '');

    // Box 4: Building Owner - Safely access nested properties
    $buildingOwner_signatureName = $conn->real_escape_string($data['buildingOwner']['signatureName'] ?? '');
    $buildingOwner_date = $conn->real_escape_string($data['buildingOwner']['date'] ?? '');
    $buildingOwner_address = $conn->real_escape_string($data['buildingOwner']['address'] ?? '');
    $buildingOwner_ctcNo = $conn->real_escape_string($data['buildingOwner']['ctcNo'] ?? '');
    
    // These were the problematic variables
    $buildingOwner_dateIssued = '';
    if (isset($data['buildingOwner']) && is_array($data['buildingOwner'])) {
        $buildingOwner_dateIssued = $conn->real_escape_string($data['buildingOwner']['dateIssued'] ?? '');
    }
    
    $buildingOwner_placeIssued = '';
    if (isset($data['buildingOwner']) && is_array($data['buildingOwner'])) {
        $buildingOwner_placeIssued = $conn->real_escape_string($data['buildingOwner']['placeIssued'] ?? '');
    }

    // Box 5: Lot Owner - Safely access nested properties
    $lotOwner_signatureName = $conn->real_escape_string($data['lotOwner']['signatureName'] ?? '');
    $lotOwner_date = $conn->real_escape_string($data['lotOwner']['date'] ?? '');
    $lotOwner_address = $conn->real_escape_string($data['lotOwner']['address'] ?? '');
    $lotOwner_ctcNo = $conn->real_escape_string($data['lotOwner']['ctcNo'] ?? '');
    
    // These were the problematic variables
    $lotOwner_dateIssued = '';
    if (isset($data['lotOwner']) && is_array($data['lotOwner'])) {
        $lotOwner_dateIssued = $conn->real_escape_string($data['lotOwner']['dateIssued'] ?? '');
    }
    
    $lotOwner_placeIssued = '';
    if (isset($data['lotOwner']) && is_array($data['lotOwner'])) {
        $lotOwner_placeIssued = $conn->real_escape_string($data['lotOwner']['placeIssued'] ?? '');
    }

    // Box 6: Civil Structural Documents (checkboxes) - Safely access nested properties
    $civilStructural_designsComputations = (int)($data['civilStructuralDocuments']['designsComputations'] ?? 0);
    $civilStructural_billOfMaterials = (int)($data['civilStructuralDocuments']['billOfMaterials'] ?? 0);
    $civilStructural_costEstimates = (int)($data['civilStructuralDocuments']['costEstimates'] ?? 0);
    $civilStructural_others = (int)($data['civilStructuralDocuments']['others'] ?? 0);
    $civilStructural_othersDetails = $conn->real_escape_string($data['civilStructuralDocuments']['othersDetails'] ?? '');
    
    // This was the problematic variable
    $proposedStartingDate = 0; // Initialize to default for boolean/int
    if (isset($data['civilStructuralDocuments']) && is_array($data['civilStructuralDocuments'])) {
        $proposedStartingDate = (int)($data['civilStructuralDocuments']['proposedStartingDate'] ?? 0);
    }

    // Construct the SQL query for insertion into the 'electrical' table
    $sql = "INSERT INTO electrical (
                        last_name, first_name, mi, tin,
                        address_no, address_street, address_barangay, address_city,
                        zip, phone, email,
                        location_lot_no, location_blk_no, location_tct_no,
                        location_tax_dec_no, location_street, location_barangay, location_city,
                        scope, scope_other_details,
                        total_connected_loads, total_transformer_capacity, total_generator_ups_capacity,
                        design_prof_name, design_prof_date, design_prof_address, design_prof_prc_no,
                        design_prof_prc_validity, design_prof_ptr_no, design_prof_ptr_date_issued,
                        design_prof_issued_at, design_prof_tin,
                        supervisor_pe_engineer, supervisor_re_engineer, supervisor_master_electrician,
                        supervisor_name, supervisor_date, supervisor_address, supervisor_prc_no,
                        supervisor_prc_validity, supervisor_ptr_no, supervisor_ptr_date_issued,
                        supervisor_issued_at, supervisor_tin,
                        building_owner_signature_name, building_owner_date, building_owner_address,
                        building_owner_ctc_no, building_owner_date_issued, building_owner_place_issued,
                        lot_owner_signature_name, lot_owner_date, lot_owner_address,
                        lot_owner_ctc_no, lot_owner_date_issued, lot_owner_place_issued,
                        civil_structural_designs_computations, civil_structural_bill_of_materials,
                        civil_structural_cost_estimates, civil_structural_others, civil_structural_others_details,
                        proposed_starting_date
                    ) VALUES (
                        '$lastName', '$firstName', '$mi', '$tin',
                        '$address_no', '$address_street', '$address_barangay', '$address_city',
                        '$zip', '$phone', '$email',
                        '$location_lotNo', '$location_blkNo', '$location_tctNo',
                        '$location_taxDecNo', '$location_street', '$location_barangay', '$location_city',
                        '$scope', '$scopeOtherDetails',
                        '$totalConnectedLoads', '$totalTransformerCapacity', '$totalGeneratorUpsCapacity',
                        '$designProf_name', '$designProf_date', '$designProf_address', '$designProf_prcNo',
                        '$designProf_prcValidity', '$designProf_ptrNo', '$designProf_ptrDateIssued',
                        '$designProf_issuedAt', '$designProf_tin',
                        $supervisor_peEngineer, $supervisor_reEngineer, $supervisor_masterElectrician,
                        '$supervisor_name', '$supervisor_date', '$supervisor_address', '$supervisor_prcNo',
                        '$supervisor_prcValidity', '$supervisor_ptrNo', '$supervisor_ptrDateIssued',
                        '$supervisor_issuedAt', '$supervisor_tin',
                        '$buildingOwner_signatureName', '$buildingOwner_date', '$buildingOwner_address',
                        '$buildingOwner_ctcNo', '$buildingOwner_dateIssued', '$buildingOwner_placeIssued',
                        '$lotOwner_signatureName', '$lotOwner_date', '$lotOwner_address',
                        '$lotOwner_ctcNo', '$lotOwner_dateIssued', '$lotOwner_placeIssued',
                        $civilStructural_designsComputations, $civilStructural_billOfMaterials,
                        $civilStructural_costEstimates, $civilStructural_others, '$civilStructural_othersDetails',
                        $proposedStartingDate
                    )";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        // Removed <br> here, as it can cause JSON parsing issues on frontend
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error . ". SQL: " . $sql]);
    }
} else {
    // This block handles OPTIONS requests for CORS pre-flight, or any other unsupported methods
    http_response_code(200); // Respond with OK for OPTIONS requests
}

$conn->close();
?>