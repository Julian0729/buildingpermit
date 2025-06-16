<?php
// Ensure absolutely NO whitespace or characters before this opening PHP tag.
// This is critical for headers to be sent correctly.

// Start output buffering to prevent accidental output before JSON.
ob_start();

// --- CORS HEADERS ---
// Define your allowed origins. CRUCIAL for security and functionality.
$allowedOrigin = 'http://localhost:3000'; // Match your Vue.js dev server origin
header('Access-Control-Allow-Origin: ' . $allowedOrigin);
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Ensure OPTIONS is allowed
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Common headers
header('Access-Control-Max-Age: 86400'); // Cache preflight response

// --- HANDLE PREFLIGHT (OPTIONS) REQUEST ---
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    ob_end_clean();
    exit();
}

// --- MAIN SIGNUP LOGIC (for POST requests) ---

// Database connection details
$dbHost = '127.0.0.1';
$dbName = 'buildingpermit';
$dbUser = 'root';
$dbPass = '';

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $firstName = $data['firstName'] ?? '';
    $lastName = $data['lastName'] ?? '';
    $role = $data['role'] ?? 'applicant'; // Default role to 'applicant'

    // --- Input Validation ---
    if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
        $response = ['success' => false, 'message' => 'All fields are required.'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = ['success' => false, 'message' => 'Invalid email format.'];
    } elseif (strlen($password) < 6) { // Basic password length check
        $response = ['success' => false, 'message' => 'Password must be at least 6 characters long.'];
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $response = ['success' => false, 'message' => 'Email already registered.'];
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $pdo->prepare(
                "INSERT INTO users (email, password, first_name, last_name, role) VALUES (:email, :password, :firstName, :lastName, :role)"
            );
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Registration successful! You can now log in.'];
            } else {
                $response = ['success' => false, 'message' => 'Registration failed. Please try again.'];
            }
        }
    }

} catch (PDOException $e) {
    error_log("Database error in signup.php: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'Database operation failed. Please try again later.'];
} catch (Exception $e) {
    error_log("Unexpected error in signup.php: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again.'];
} finally {
    ob_end_clean();
    echo json_encode($response);
    exit();
}
?>