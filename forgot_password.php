<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "ddu_clerance";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['forgotEmail'];

    // Define queries for each table
    $queries = [
        "SELECT * FROM ddu_admin WHERE email = ?",
        "SELECT * FROM ddu_staff WHERE email = ?",
        "SELECT * FROM ddu_substaff WHERE email = ?"
    ];

    $user_found = false;

    // Check if the email exists in any of the tables
    for ($i = 0; $i < count($queries); $i++) {
        $stmt = $conn->prepare($queries[$i]);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_found = true;
            break;
        }

        $stmt->close();
    }

    if ($user_found) {
        // Email exists, register in forget_password table
        $stmt = $conn->prepare("INSERT INTO forget_password (user_email, status, date) VALUES (?, 'PENDING', NOW())");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect with success message
            header("Location: index.php?success=1");
        } else {
            // Redirect with error message
            header("Location: index.php?forgotError=Failed to register the request.");
        }

        $stmt->close();
    } else {
        // Redirect with error message
        header("Location: index.php?forgotError=Email not found.");
    }

    // Close the connection
    $conn->close();
}
?>
