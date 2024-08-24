<?php
header('Content-Type: application/json');
require_once 'db_config.php'; // Include your database connection script

// Fetch input data
$role = isset($_POST['staff']) ? $_POST['staff'] : '';
$collegeName = isset($_POST['collegeName']) ? $_POST['collegeName'] : '';

// Initialize response array
$response = [
    'staffExists' => false,
    'schoolDeanExists' => false,
];

// Prepare SQL query to check for existing staff roles
if ($role) {
    $query = "SELECT COUNT(*) as count FROM ddu_staff WHERE staff = ? ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$role]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['count'] > 0) {
        $response['staffExists'] = true;
    }
}

// Prepare SQL query to check if a School Dean exists for the given college/school
if ($collegeName) {
    $query = "SELECT COUNT(*) as count FROM ddu_staff WHERE staff = 'SchoolDean' AND collegeName = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$collegeName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['count'] > 0) {
        $response['schoolDeanExists'] = true;
    }
}

// Return the response as JSON
echo json_encode($response);
