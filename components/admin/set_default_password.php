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

    $user_id = $_POST['user_id'];

    // Fetch the user's email from the forget_password table
    $stmt = $conn->prepare("SELECT user_email FROM forget_password WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['user_email'];

    // Update the user's password to 'root' in the appropriate table
    $queries = [
        "UPDATE ddu_admin SET password = MD5('root') WHERE email = ?",
        "UPDATE ddu_staff SET password = MD5('root') WHERE email = ?",
        "UPDATE ddu_substaff SET password = MD5('root') WHERE email = ?"
    ];

    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    // Update the forget_password table to mark the request as completed
    $stmt = $conn->prepare("UPDATE forget_password SET status = 'COMPLETED' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect back to the admin page (or wherever you'd like)
    header("Location: dashboard.php?notification=success");
    exit();

    $stmt->close();
    $conn->close();
}
?>
