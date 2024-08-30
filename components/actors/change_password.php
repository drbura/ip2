<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

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

$email = $_SESSION['email'];
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentpassword'];
    $newPassword = trim($_POST['newpassword']);
    $renewPassword = trim($_POST['renewpassword']);

    if ($newPassword === $renewPassword) {
        // Fetch the current password from the database
        $sql = "SELECT password FROM ddu_staff WHERE email = ?
                UNION
                SELECT password FROM ddu_substaff WHERE email = ?
                UNION
                SELECT password FROM ddu_admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the current password
            if (password_verify($currentPassword, $row['password'])) {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the respective table
                $updateSuccess = false;

                // Update in ddu_staff
                $updateSql = "UPDATE ddu_staff SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedNewPassword, $email);
                $updateStmt->execute();
                if ($updateStmt->affected_rows > 0) {
                    $updateSuccess = true;
                }

                // Update in ddu_substaff
                $updateSql = "UPDATE ddu_substaff SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedNewPassword, $email);
                $updateStmt->execute();
                if ($updateStmt->affected_rows > 0) {
                    $updateSuccess = true;
                }

                // Update in ddu_admin
                $updateSql = "UPDATE ddu_admin SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedNewPassword, $email);
                $updateStmt->execute();
                if ($updateStmt->affected_rows > 0) {
                    $updateSuccess = true;
                }

                $updateStmt->close();

                if ($updateSuccess) {
                    $successMessage = "Password successfully changed.";
                } else {
                    $errorMessage = "Failed to update the password.";
                }
            } else {
                $errorMessage = "Current password is incorrect.";
            }
        } else {
            $errorMessage = "User not found.";
        }
        $stmt->close();
    } else {
        $errorMessage = "New passwords do not match.";
    }
}

$conn->close();
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>


