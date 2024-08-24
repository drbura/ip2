<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

$servername = "localhost"; // Adjust as needed
$username = "root"; // Adjust as needed
$password_db = ""; // Adjust as needed
$dbname = "ddu_clerance"; // Adjust as needed

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // Ensure this file correctly sets up $conn

$email = $_SESSION['email'];

// Query to fetch user details from ddu_staff, ddu_substaff, or ddu_admin based on email
$sql = "SELECT CONCAT_WS(' ', fName, mName, lName) AS full_name, position AS role, phone, email
        FROM ddu_staff WHERE email = ? 
        UNION 
        SELECT CONCAT_WS(' ', fName, mName, lName) AS full_name, staff AS role, phone, email
        FROM ddu_substaff WHERE email = ? 
        UNION 
        SELECT CONCAT_WS(' ', fName, mName, lName) AS full_name, role, phone, email
        FROM ddu_admin WHERE email = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("sss", $email, $email, $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

$user = $result->fetch_assoc();
if (!$user) {
    die("No user found with the given email.");
}

$stmt->close();
$conn->close();

// Extract user details
$fullName = $user['full_name'];
$role = $user['role'];
$phone = $user['phone'];
$email = $user['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin-top: 30px;
        }
        .navbar-custom {
            background-color: #343a40;
            height: 60px;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: #ffffff;
        }
        .navbar-custom .dropdown-menu {
            right: 0;
            left: auto;
        }
        .navbar-toggler {
            border: none;
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .profile-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
        .profile-card h2, .profile-card h3 {
            margin: 0;
        }
        .nav-tabs {
            margin-bottom: 1.5rem;
        }
        .nav-link.active {
            color: #007bff;
            background-color: #ffffff;
            border: 1px solid #007bff;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .nav-link {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.75rem 1.25rem;
        }
        .tab-content {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0 0 0.5rem 0.5rem;
            padding: 1.5rem;
        }
        .form-control {
            border-radius: 0.25rem;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004080;
        }
        .label {
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'lib.php'; ?>
<?php include 'header.php'; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Profile</h1>
       
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card profile-card">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h2><?php echo htmlspecialchars($fullName); ?></h2>
                        <h3><?php echo htmlspecialchars($role); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#profile-overview">Overview</a>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile-change-password">Change Password</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active" id="profile-overview">
                               
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($fullName); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Role</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($role); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($phone); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($email); ?></div>
                                </div>
                            </div>

                          

                            <div class="tab-pane fade" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="change_password.php" method="post">
                                    
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="currentpassword" type="password" class="form-control" id="currentPassword">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    function removeProfileImage(event) {
        event.preventDefault();
        document.getElementById('profileImg').src = 'assets/img/default-profile.png';
        // Additional logic to handle the removal on the server-side can be implemented here.
    }
</script>
</body>
</html>

