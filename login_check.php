<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection details
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
        $email = $_POST['email'];
        $password = $_POST['password'];

        $queries = [
            "SELECT * FROM ddu_admin WHERE email = ?",
            "SELECT * FROM ddu_staff WHERE email = ?",
            "SELECT * FROM ddu_substaff WHERE email = ?"
        ];

        $user_found = false;

        function isMd5($password) {
            return preg_match('/^[a-f0-9]{32}$/', $password);
        }

        function checkMd5Password($storedPassword, $inputPassword) {
            return md5($inputPassword) === $storedPassword;
        }

        for ($i = 0; $i < count($queries); $i++) {
            $stmt = $conn->prepare($queries[$i]);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['password'];
                $staff = $row['staff'];
                $_SESSION['email'] = $email;

                $redirects = [
                    './components/admin/dashboard.php', // For ddu_admin
                    './components/actors/actor_dashboard.php?actor='.urlencode($staff), // For ddu_staff
                    './components/actors/actor_dashboard.php?actor='.urlencode($staff), // For ddu_substaff
                ];

                if (isMd5($storedPassword)) {
                    if (checkMd5Password($storedPassword, $password)) {
                        $user_found = true;
                        header("Location: " . $redirects[$i]);
                        exit();
                    }
                } else {
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
            $_SESSION['error'] = "Invalid email or password. Please try again.";
            header("Location: index.php"); // Redirect back to the login page
            exit();
        }
    }

    $conn->close();
}
