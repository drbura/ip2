<?php
session_start();

// Check if the user is logged in by verifying the session variables
if (!isset($_SESSION['id'])) {
    header('Location: index.php'); // Redirect to login page if session is not set
    exit;
}

// Check if the user has agreed to the terms
if (!isset($_SESSION['agreed'])) {
    header('Location: agree.php');
    exit;
}

$idError = isset($_SESSION['id_error']) ? $_SESSION['id_error'] : '';
$formError = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the session errors
unset($_SESSION['id_error']);
unset($_SESSION['error']);

$studentId = isset($_SESSION['id']) ? $_SESSION['id'] : ''; // Retrieve the student ID from the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get student data
$sql = "SELECT student_id, first_name, father_name, gfather_name, department, year, semester FROM ddustudentdata WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$studentData = $result->fetch_assoc();

$fullName = htmlspecialchars($studentData['first_name'] . ' ' . $studentData['father_name'] . ' ' . $studentData['gfather_name']);
$department = htmlspecialchars($studentData['department']);
$year = htmlspecialchars($studentData['year']);
$semester = htmlspecialchars($studentData['semester']);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            max-width: 600px;
        }
        .navbar-custom {
            background-color: #007bff;
            height: 60px; /* Adjusted height */
        }
        .navbar-custom .navbar-brand img {
            height: 40px; /* Adjusted logo size */
        }
        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }
        .navbar-custom .dropdown-menu {
            right: 0;
            left: auto;
        }
        .navbar-toggler {
            border: none;
        }
        @media (max-width: 300px) {
            .navbar-custom .dropdown-menu {
                min-width: 200px; /* Ensure dropdown menu is wide enough */
            }
            .navbar-custom .dropdown-toggle::after {
                display: none; /* Remove dropdown indicator */
            }
            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="./Images/Dire-Dawa_University-removebg.png" alt="Ethiopian Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center">Clearance Form</h1>
        <?php if ($idError): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($idError); ?></div>
        <?php endif; ?>
        <?php if ($formError): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($formError); ?></div>
        <?php endif; ?>
        <form id="studentForm" class="needs-validation" novalidate method="post" action="insert_request.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $fullName; ?>" readonly required>
                <div class="invalid-feedback">Please enter your full name.</div>
            </div>
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="<?php echo $studentData['student_id']; ?>" readonly required>
                <div class="invalid-feedback">Please enter your ID.</div>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo $department; ?>" readonly required>
                <div class="invalid-feedback">Please enter your department.</div>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" class="form-control" id="year" name="year" value="<?php echo $year; ?>" readonly required>
                <div class="invalid-feedback">Please enter your year.</div>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" value="<?php echo $semester; ?>" readonly required>
                <div class="invalid-feedback">Please enter your semester.</div>
            </div>
            <div class="form-group">
                <label for="reason">Reason</label>
                <select class="form-control" id="reason" name="reason" required>
                    <option value="">Select Reason</option>
                    <option value="Semester End">For Semester End</option>
                    <option value="Withdraw">For Withdraw</option>
                    <option value="Graduation">For Graduation</option>
                </select>
                <div class="invalid-feedback">Please select your reason.</div>
            </div>
            <button type="submit" id="sendRequestButton" name="send_request" class="btn btn-primary">Send Request</button>
            <button type="button" id="clearFormButton" class="btn btn-secondary ml-2">Clear</button>
        </form>
    </div>
    <br><br><br><br>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementById('studentForm');
                
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }
                }, false);
                
                $('#clearFormButton').on('click', function() {
                    if (true) {
                        form.reset();
                        form.classList.remove('was-validated');
                    }
                });
            }, false);
        })();
    </script>
</body>
</html>
