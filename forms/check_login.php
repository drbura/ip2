<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "clearance";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['signIn'])) {
        // Login
        $email = $_POST['email'];
        $password = $_POST['password'];
        $Hpassword = md5($password);

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $Hpassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $staff = $row['staff'];
            
            if ($staff === 'admin') {
                header('Location: ../clear/dashboard.php');
                exit();
            } else {
                header("Location: ../clear/components/actors/actor_dashboard.php?actor=" . urlencode($staff));
                exit();
            }
        } else {
            echo '<script>alert("Invalid credentials");</script>';
        }

        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>
<?php include 'indexx.php' ?>
