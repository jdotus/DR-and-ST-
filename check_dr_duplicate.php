<?php
// check_dr_duplicate.php
// AJAX endpoint to check if DR Number already exists in database

header('Content-Type: application/json');

// Database connection (adjust credentials as needed)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Final_DR"; // Change to your actual database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get DR Number from POST request
    $dr_number = isset($_POST['dr_number']) ? trim($_POST['dr_number']) : '';

    // Validate input
    if (empty($dr_number)) {
        echo json_encode([
            'success' => false,
            'message' => 'DR Number is required'
        ]);
        exit;
    }

    // Sanitize input
    $dr_number = $conn->real_escape_string($dr_number);

    // Query to check if DR Number exists
    // Change table name "delivery_rental" to your actual table name
    $sql = "SELECT dr_number FROM main WHERE dr_number = '$dr_number' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // DR Number exists (duplicate found)
        echo json_encode([
            'exists' => true,
            'dr_number' => htmlspecialchars($dr_number),
            'message' => 'This DR Number already exists'
        ]);
    } else {
        // DR Number does not exist (available)
        echo json_encode([
            'exists' => false,
            'dr_number' => htmlspecialchars($dr_number),
            'message' => 'DR Number is available'
        ]);
    }

    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
