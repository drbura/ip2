<?php
// Database connection
$servername = "localhost"; // Adjust as needed
$username = "root"; // Adjust as needed
$password_db = ""; // Adjust as needed
$dbname = "ddu_clerance"; // Adjust as needed

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Prepare the SQL statement with UNION to check across all three tables
    $stmt = $conn->prepare("
        SELECT COUNT(*) FROM (
            SELECT email FROM ddu_admin WHERE email = ?
            UNION
            SELECT email FROM ddu_staff WHERE email = ?
            UNION
            SELECT email FROM ddu_subStaff WHERE email = ?
        ) AS combined
    ");
    // Bind the email parameter for all three queries
    $stmt->bind_param('sss', $email, $email, $email);
    // Execute the statement
    $stmt->execute();
    // Bind result variables
    $stmt->bind_result($count);
    // Fetch the result
    $stmt->fetch();

    if ($count > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }

    // Close statement
    $stmt->close();
} else {
    echo 'invalid_request';
}

// Close connection
$conn->close();
?>
