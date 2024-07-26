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

    if (isset($_POST['signIn'])) {
        // Get user input
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Define queries for each table
        $queries = [
            "SELECT * FROM ddu_admin WHERE email = ?",
            "SELECT * FROM ddu_staff WHERE email = ?",
            "SELECT * FROM ddu_substaff WHERE email = ?"
        ];

        $user_found = false;

        // Function to check if a password is MD5
        function isMd5($password) {
            return preg_match('/^[a-f0-9]{32}$/', $password);
        }

        // Function to handle MD5 password check
        function checkMd5Password($storedPassword, $inputPassword) {
            return md5($inputPassword) === $storedPassword;
        }

        // Loop through queries to check each table
        for ($i = 0; $i < count($queries); $i++) {
            $stmt = $conn->prepare($queries[$i]);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['password'];
                $staff = $row['staff'];

                // Define placeholder redirect URLs for each table
        $redirects = [
            './components/admin/dashboard.php', // Placeholder URL for ddu_admin
            './components/actors/actor_dashboard.php?actor='.urlencode($staff), // Placeholder URL for ddu_staff
            './components/actors/actor_dashboard.php?actor='.urlencode($staff),
            // 'student.php' // Placeholder URL for ddu_substaff
        ];

                // Determine if the password is MD5 or securely hashed
                if (isMd5($storedPassword)) {
                    // Check MD5 password
                    if (checkMd5Password($storedPassword, $password)) {
                        $user_found = true;
                        header("Location: " . $redirects[$i]);
                        exit();
                    }
                } else {
                    // Check password using password_verify for modern hashing
                    if (password_verify($password, $storedPassword)) {
                        $user_found = true;
                        header("Location: " . $redirects[$i]);
                        exit();
                    }
                }
            }

            $stmt->close();
        }

        if (!$user_found) {
            echo '<script>alert("Invalid credentials");</script>';
        }
    }

    // Close the connection
    $conn->close();
}
?>
