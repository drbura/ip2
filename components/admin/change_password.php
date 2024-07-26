<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "Clearance";

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $ccurrent_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    // $renew_password = mysqli_real_escape_string($conn, $_POST['renewpassword']);

    // // Check if new passwords match
    // if ($new_password !== $renew_password) {
    //     die("New passwords do not match.");
    // }

    // Query to check if the email exists
    $sql = "SELECT password FROM admin WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $current_password = md5($ccurrent_password);

        // Verify current password
        if ($current_password == $hashed_password) {
            // Hash the new password
            $new_hashed_password = md5 ($new_password);

            // Update the password in the database
            $update_sql = "UPDATE admin SET password='$new_hashed_password' WHERE email='$email'";
            if (mysqli_query($conn, $update_sql)) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Current password is incorrect.";
        }
    } else {
        echo "Email not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<?php include 'users-profile.php' ?>