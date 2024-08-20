<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT COUNT(*) FROM ddu_staff WHERE email = ?");
    // Bind the email parameter
    $stmt->bind_param('s', $email);
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
