<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Allow cross-origin requests, adjust as needed for security in a production environment
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Handle OPTIONS requests for CORS pre-flight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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

// Define the upload directory. Make sure this directory exists and is writable by the web server.
// For example, create a folder named 'uploads' in the same directory as your PHP script.
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

// Create the uploads directory if it doesn't exist
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) { // 0777 grants full permissions, adjust for production
        echo json_encode(["success" => false, "message" => "Failed to create upload directory."]);
        $conn->close();
        exit();
    }
}

/**
 * Handles the upload of files and returns an array of their saved paths.
 *
 * @param array $fileInput An entry from $_FILES (e.g., $_FILES['unifiedApplicationForm'] or $_FILES['architecturalFiles']).
 * @param string $uploadDir The directory where files should be moved.
 * @return array An array of paths where the files were saved.
 */
function handleFileUpload(array $fileInput, string $uploadDir): array {
    $uploadedPaths = [];

    // Check if it's a multiple file input (name is an array) and actually contains files (not UPLOAD_ERR_NO_FILE)
    if (isset($fileInput['name']) && is_array($fileInput['name'])) {
        // We need to check if *any* valid file was uploaded in this multi-file input
        $hasValidFile = false;
        foreach ($fileInput['error'] as $error) {
            if ($error === UPLOAD_ERR_OK) {
                $hasValidFile = true;
                break;
            }
        }

        if ($hasValidFile) {
            foreach ($fileInput['name'] as $index => $fileName) {
                if ($fileInput['error'][$index] === UPLOAD_ERR_OK) {
                    $tmpName = $fileInput['tmp_name'][$index];
                    $newFileName = uniqid() . '_' . basename($fileName); // Generate unique filename
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($tmpName, $destination)) {
                        // Store relative path to the upload directory for database
                        $uploadedPaths[] = 'src/pages/Upload-Backend/uploads/' . $newFileName;
                    } else {
                        error_log("Failed to move uploaded file: " . $tmpName . " to " . $destination);
                    }
                }
            }
        }
    }
    // If $fileInput['name'] is not set (field omitted by FormData for example)
    // or if it was a single file input and error was UPLOAD_ERR_NO_FILE,
    // $uploadedPaths remains an empty array, which is correct.
    return $uploadedPaths;
}

// Handle POST request to save data and files (UPSERT logic)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect text data from $_POST
    $applicantFullName = $conn->real_escape_string($_POST['applicantFullName'] ?? '');
    $projectFullAddress = $conn->real_escape_string($_POST['projectFullAddress'] ?? '');

    // Get current latest ID for potential update
    $latestId = null;
    $result = $conn->query("SELECT id FROM `document_uploads` ORDER BY id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latestId = $row['id'];
    }

    // Initialize all file path columns to empty arrays.
    // This ensures that if a field is cleared, its database column will be updated to '[]'.
    $filePathsToSave = [
        'unified_application_pdf_paths' => [],
        'general_clearances_pdf_paths' => [],
        'architectural_files_paths' => [],
        'structural_files_paths' => [],
        'electrical_files_paths' => [],
        'mechanical_files_paths' => [],
        'sanitary_files_paths' => [],
        'electronics_files_paths' => [],
        'fencing_files_paths' => [],
        'sign_files_paths' => [],
        'billboard_files_paths' => [],
        'excavation_files_paths' => [],
        'demolition_files_paths' => [],
        'other_permit_files_paths' => []
    ];

    // Process Unified Application Form PDF(s)
    if (isset($_FILES['unifiedApplicationForm'])) {
        $filePathsToSave['unified_application_pdf_paths'] = handleFileUpload($_FILES['unifiedApplicationForm'], $uploadDir);
    }

    // Process General Clearances PDF(s)
    if (isset($_FILES['generalClearances'])) {
        $filePathsToSave['general_clearances_pdf_paths'] = handleFileUpload($_FILES['generalClearances'], $uploadDir);
    }
    // No other ancillary document processing as per previous request

    // Convert arrays of paths to JSON strings for database storage
    $jsonFilePaths = [];
    foreach ($filePathsToSave as $colName => $pathsArray) {
        $jsonFilePaths[$colName] = json_encode($pathsArray);
    }

    $sql = "";
    if ($latestId) {
        // UPDATE existing record
        $updateFields = [];
        foreach ($jsonFilePaths as $col => $jsonVal) {
            $updateFields[] = "`$col` = '$jsonVal'";
        }
        $sql = "UPDATE `document_uploads` SET " . implode(', ', $updateFields) . ", 
                `applicant_full_name` = '$applicantFullName', 
                `project_full_address` = '$projectFullAddress', 
                `submission_date` = NOW() 
                WHERE `id` = $latestId";
    } else {
        // INSERT new record
        $columns = "`applicant_full_name`, `project_full_address`, `submission_date`";
        $values = "'$applicantFullName', '$projectFullAddress', NOW()";

        foreach ($jsonFilePaths as $col => $jsonVal) {
            $columns .= ", `$col`";
            $values .= ", '$jsonVal'";
        }
        $sql = "INSERT INTO `document_uploads` ($columns) VALUES ($values)";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Application and documents " . ($latestId ? "updated" : "submitted") . " successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error saving data: " . $conn->error . " SQL: " . $sql]);
    }
}
// Handle GET request to retrieve data
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the latest record from the 'document_uploads' table
    $sql = "SELECT * FROM `document_uploads` ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Decode JSON fields back into arrays for the frontend
        foreach ($row as $key => $value) {
            // Check if the key ends with '_paths' and the value is a non-empty string
            if (strpos($key, '_paths') !== false && $value !== null && $value !== '') {
                $decoded = json_decode($value, true);
                $row[$key] = is_array($decoded) ? $decoded : [];
            } else if (strpos($key, '_paths') !== false && ($value === null || $value === '')) {
                $row[$key] = []; // Explicitly set to empty array if null/empty string
            }
        }
        
        // Send the fetched data as a JSON response
        echo json_encode(["success" => true, "data" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "No data found."]);
    }
} else {
    // This block handles unsupported methods
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
}

$conn->close();
