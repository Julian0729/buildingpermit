<?php
// Ensure absolutely NO whitespace or characters before this opening PHP tag.
// This is critical for headers to be sent correctly.

// Start output buffering to prevent accidental output before JSON.
// This helps catch any accidental echoes before the final JSON output.
ob_start();

// --- CORS HEADERS ---
// Define your allowed origins. CRUCIAL for security and functionality.
// This MUST exactly match the origin of your Vue.js development server.
$allowedOrigin = 'http://localhost:3000'; // Make sure this is correct for your Vue.js app

// Set common CORS headers for all requests (GET, POST, OPTIONS)
header('Access-Control-Allow-Origin: ' . $allowedOrigin);
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Ensure OPTIONS is allowed
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Common headers, add more if your frontend sends them
header('Access-Control-Max-Age: 86400'); // Cache preflight response for 24 hours (optional but good for performance)

// --- HANDLE PREFLIGHT (OPTIONS) REQUEST ---
// Browsers send an OPTIONS request before certain cross-origin requests (like POST with custom headers)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond with 200 OK for preflight. No content is needed.
    http_response_code(200);
    ob_end_clean(); // Clear any output buffering.
    exit(); // IMPORTANT: Terminate script execution immediately after preflight.
}

// --- ACTUAL LOGIN LOGIC STARTS HERE (for POST requests) ---

// Database connection details
$dbHost = '127.0.0.1';
$dbName = 'buildingpermit'; // Your database name from phpMyAdmin
$dbUser = 'root';
$dbPass = ''; // Default XAMPP root user has no password

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

try {
    // --- Database Connection ---
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- Get POST data ---
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // --- Input Validation ---
    if (empty($email) || empty($password)) {
        $response = ['success' => false, 'message' => 'Email and password are required.'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = ['success' => false, 'message' => 'Invalid email format.'];
    } else {
        // --- User Authentication ---
        $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $response = ['success' => true, 'message' => 'Login successful!', 'userId' => $user['id']];
            } else {
                $response = ['success' => false, 'message' => 'Invalid email or password.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Invalid email or password.'];
        }
    }

} catch (PDOException $e) {
    // Database specific error
    error_log("Database error in login.php: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'Database operation failed. Please try again later.'];
} catch (Exception $e) {
    // General unexpected error
    error_log("Unexpected error in login.php: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again.'];
} finally {
    // Ensure that the output buffer is cleaned and JSON is echoed in all cases
    ob_end_clean(); // Clean any remaining output buffer content
    echo json_encode($response); // Output the final JSON response
    exit(); // Always exit after sending the final response
}
?>
