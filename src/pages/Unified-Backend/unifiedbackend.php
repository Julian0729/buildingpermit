<?php
// Set CORS headers to allow requests from your Vue.js frontend
header("Access-Control-Allow-Origin: http://localhost:3000"); // Adjust this if your Vue app runs on a different port
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
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
$dbname = "buildingpermit"; // The database name you created
$table = "buildingpermit"; // The table name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true); // Decode JSON into an associative array

    // Check if JSON decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Invalid JSON data received."]);
        exit();
    }

    // Prepare data for insertion
    // Use mysqli_real_escape_string to prevent SQL injection
    $application_number = $conn->real_escape_string($data['generatedApplicationNumber'] ?? '');
    $access_password = $conn->real_escape_string($data['generatedPassword'] ?? '');

    // Application Details
    $application_type = $conn->real_escape_string($data['applicationDetails']['applicationType'] ?? '');
    $application_status = $conn->real_escape_string($data['applicationDetails']['applicationStatus'] ?? '');
    // For arrays like scopeOfWork, store as JSON string
    $scope_of_work = json_encode($data['applicationDetails']['scopeOfWork'] ?? []);
    $other_scope_of_work = $conn->real_escape_string($data['applicationDetails']['otherScopeOfWork'] ?? '');
    $occupancy_group = $conn->real_escape_string($data['applicationDetails']['occupancyGroup'] ?? '');
    $occupancy_type = $conn->real_escape_string($data['applicationDetails']['occupancyType'] ?? '');
    $other_occupancy_type = $conn->real_escape_string($data['applicationDetails']['otherOccupancyType'] ?? '');

    // Owner/Applicant Information
    $owner_last_name = $conn->real_escape_string($data['ownerApplicantInfo']['lastName'] ?? '');
    $owner_first_name = $conn->real_escape_string($data['ownerApplicantInfo']['firstName'] ?? '');
    $owner_middle_name = $conn->real_escape_string($data['ownerApplicantInfo']['middleName'] ?? '');
    $owner_tin = $conn->real_escape_string($data['ownerApplicantInfo']['tin'] ?? '');
    // Convert boolean to tinyint (0 or 1)
    $owner_is_enterprise_owned = isset($data['ownerApplicantInfo']['isEnterpriseOwned']) ? (int)$data['ownerApplicantInfo']['isEnterpriseOwned'] : 0;
    $owner_form_ownership = $conn->real_escape_string($data['ownerApplicantInfo']['formOwnership'] ?? '');
    $owner_address_no = $conn->real_escape_string($data['ownerApplicantInfo']['ownerAddressNo'] ?? '');
    $owner_address_street = $conn->real_escape_string($data['ownerApplicantInfo']['ownerAddressStreet'] ?? '');
    $owner_address_barangay = $conn->real_escape_string($data['ownerApplicantInfo']['ownerAddressBarangay'] ?? '');
    $owner_address_municipal = $conn->real_escape_string($data['ownerApplicantInfo']['ownerAddressMunicipal'] ?? '');
    $owner_address_zip_code = $conn->real_escape_string($data['ownerApplicantInfo']['ownerAddressZipCode'] ?? '');
    $owner_contact_number = $conn->real_escape_string($data['ownerApplicantInfo']['contactNumber'] ?? '');

    // Location of Construction
    $const_lot_no = $conn->real_escape_string($data['constructionLocation']['lotNo'] ?? '');
    $const_blk_no = $conn->real_escape_string($data['constructionLocation']['blkNo'] ?? '');
    $const_tct_no = $conn->real_escape_string($data['constructionLocation']['tctNo'] ?? '');
    $const_tax_dec_no = $conn->real_escape_string($data['constructionLocation']['taxDecNo'] ?? '');
    $const_street = $conn->real_escape_string($data['constructionLocation']['constructionStreet'] ?? '');
    $const_barangay = $conn->real_escape_string($data['constructionLocation']['constructionBarangay'] ?? '');
    $const_municipal = $conn->real_escape_string($data['constructionLocation']['constructionMunicipal'] ?? '');

    // Occupancy Details
    $occupancy_classified = $conn->real_escape_string($data['occupancyDetails']['occupancyClassified'] ?? '');
    $number_of_units = (int)($data['occupancyDetails']['numberOfUnits'] ?? 0);
    $number_of_storey = (int)($data['occupancyDetails']['numberOfStorey'] ?? 0);
    $total_floor_area = (float)($data['occupancyDetails']['totalFloorArea'] ?? 0.00);
    $lot_area = (float)($data['occupancyDetails']['lotArea'] ?? 0.00);

    // Estimated Costs
    $cost_building = (float)($data['estimatedCosts']['costBuilding'] ?? 0.00);
    $cost_electrical = (float)($data['estimatedCosts']['costElectrical'] ?? 0.00);
    $cost_mechanical = (float)($data['estimatedCosts']['costMechanical'] ?? 0.00);
    $cost_electronics = (float)($data['estimatedCosts']['costElectronics'] ?? 0.00);
    $cost_plumbing = (float)($data['estimatedCosts']['costPlumbing'] ?? 0.00);
    $cost_equipment = (float)($data['estimatedCosts']['costEquipment'] ?? 0.00);

    // Project Timeline
    $proposed_date = $conn->real_escape_string($data['projectTimeline']['proposedDate'] ?? '');
    $expected_date = $conn->real_escape_string($data['projectTimeline']['expectedDate'] ?? '');


    // SQL INSERT statement
    $sql = "INSERT INTO $table (
                application_number, access_password, application_type, application_status,
                owner_last_name, owner_first_name, owner_middle_name, owner_tin,
                owner_is_enterprise_owned, owner_form_ownership, owner_address_no,
                owner_address_street, owner_address_barangay, owner_address_municipal,
                owner_address_zip_code, owner_contact_number, const_lot_no, const_blk_no,
                const_tct_no, const_tax_dec_no, const_street, const_barangay,
                const_municipal, scope_of_work, other_scope_of_work, occupancy_group,
                occupancy_type, other_occupancy_type, occupancy_classified, number_of_units,
                number_of_storey, total_floor_area, lot_area, cost_building,
                cost_electrical, cost_mechanical, cost_electronics, cost_plumbing,
                cost_equipment, proposed_date, expected_date
            ) VALUES (
                '$application_number', '$access_password', '$application_type', '$application_status',
                '$owner_last_name', '$owner_first_name', '$owner_middle_name', '$owner_tin',
                $owner_is_enterprise_owned, '$owner_form_ownership', '$owner_address_no',
                '$owner_address_street', '$owner_address_barangay', '$owner_address_municipal',
                '$owner_address_zip_code', '$owner_contact_number', '$const_lot_no', '$const_blk_no',
                '$const_tct_no', '$const_tax_dec_no', '$const_street', '$const_barangay',
                '$const_municipal', '$scope_of_work', '$other_scope_of_work', '$occupancy_group',
                '$occupancy_type', '$other_occupancy_type', '$occupancy_classified', $number_of_units,
                $number_of_storey, $total_floor_area, $lot_area, $cost_building,
                $cost_electrical, $cost_mechanical, $cost_electronics, $cost_plumbing,
                $cost_equipment, '$proposed_date', '$expected_date'
            )";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} else {
    // If not a POST request, return an error
    echo json_encode(["success" => false, "message" => "Invalid request method. Only POST requests are allowed."]);
}

$conn->close();
?>
