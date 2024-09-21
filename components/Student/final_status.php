<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: welcome.php');
    exit;
}

include 'connect.php'; // Ensure this file correctly sets up $conn

$studentId = $_SESSION['id']; // Ensure student_id is stored in session

/// Query to fetch student details from clearedstudentslist table
$sql_cleared = "SELECT full_name, department, AcademicYear, semester FROM clearedstudentslist WHERE student_id = ?";
$stmt_cleared = $conn->prepare($sql_cleared);
if ($stmt_cleared === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_cleared->bind_param("s", $studentId);
$stmt_cleared->execute();
$result_cleared = $stmt_cleared->get_result();
if ($result_cleared === false) {
    die("Execute failed: (" . $stmt_cleared->errno . ") " . $stmt_cleared->error);
}

$student_cleared = $result_cleared->fetch_assoc();
$stmt_cleared->close();

// Get full name, department, AcademicYear, and semester from clearedstudentslist
$fullName = $student_cleared['full_name'];
$department = $student_cleared['department'];
$academicYear = $student_cleared['AcademicYear'];
$semester = $student_cleared['semester'];

// Query to fetch the school from ddustudentdata table
$sql_ddustudent = "SELECT school FROM ddustudentdata WHERE student_id = ?";
$stmt_ddustudent = $conn->prepare($sql_ddustudent);
if ($stmt_ddustudent === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_ddustudent->bind_param("s", $studentId);
$stmt_ddustudent->execute();
$result_ddustudent = $stmt_ddustudent->get_result();
if ($result_ddustudent === false) {
    die("Execute failed: (" . $stmt_ddustudent->errno . ") " . $stmt_ddustudent->error);
}

$student_ddustudent = $result_ddustudent->fetch_assoc();
$stmt_ddustudent->close();

// Fetch school from ddustudentdata
$school = $student_ddustudent['school'];


// Query to fetch clearance reason and request date from request table
$sql_request = "SELECT Reason, RequestDate FROM request_processed WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1";
$stmt_request = $conn->prepare($sql_request);
if ($stmt_request === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_request->bind_param("s", $studentId);
$stmt_request->execute();
$result_request = $stmt_request->get_result();
if ($result_request === false) {
    die("Execute failed: (" . $stmt_request->errno . ") " . $stmt_request->error);
}

$request = $result_request->fetch_assoc();
$stmt_request->close();

$conn->close();

// Set default approvals for all departments
$approvals = [
    'Advisor' => 'APPROVED',
    'LabAssistant' => 'APPROVED',
    'DepartmentHead' => 'APPROVED',
    'SchoolDean' => 'APPROVED',
    'BookStore' => 'APPROVED',
    'Library' => 'APPROVED',
    'Cafeteria' => 'APPROVED',
    'StudentLoan' => 'APPROVED',
    'Dormitory' => 'APPROVED',
    'StudentService' => 'APPROVED',
    'Store' => 'APPROVED',
    'AcademicEnrollment' => 'APPROVED'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            max-width: 1000px;
            margin-top: 30px;
        }
        .navbar-custom {
            background-color: #007bff;
            height: 60px;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
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
        .btn-confirm {
            background-color: blue;
            color: white;
            border: none;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            text-align: center;
        }
        .header img {
            height: 80px;
            width: 80px;
            margin: 0 10px;
        }
        .header h1 {
            display: inline-block;
            margin: 0;
            vertical-align: middle;
            font-size: 34px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="../Images/download.jpg" alt="DDU Logo">
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
                        <a class="dropdown-item" href="index.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="header">
        <img src="../Images/download.jpg" alt="DDU  Logo">
        <h1>
            Dire Dawa University<br>
            Student Clearance (Withdraw Form)<br>
            for Regular Undergraduate Students
        </h1>
        <img src="../Images/download.jpg" alt="DDU  Logo">
    </div>
    <div class="container">
        <table class="table table-striped">
           
        <tbody>
                <tr>
                    <td>Full Name</td>
                    <td><?php echo htmlspecialchars($fullName) ?></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><?php echo htmlspecialchars($studentId) ?></td>
                </tr>
                <tr>
                    <td>College</td>
                    <td><?php echo htmlspecialchars($school) ?></td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td><?php echo htmlspecialchars($department) ?></td>
                </tr>
                <tr>
                    <td>Academic Year</td>
                    <td><?php echo htmlspecialchars($academicYear) ?></td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td><?php echo htmlspecialchars($semester) ?></td>
                </tr>
                <tr>
                    <td>Reason</td>
                    <td><?php echo htmlspecialchars($request['Reason']) ?></td>
                </tr>
                <tr>
                    <td>Request Date</td>
                    <td><?php echo htmlspecialchars($request['RequestDate']) ?></td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center">Approvals</h2>
        <table class="table table-striped">
            
            <tbody>
                <?php foreach ($approvals as $actor => $status): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($actor); ?></td>
                        <td>
                            <button class="btn <?php echo $status === 'APPROVED' ? 'btn-success' : 'btn-warning'; ?>" disabled>
                                <?php echo htmlspecialchars($status); ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="generate_pdf.php" method="post">
            <div class="text-center mt-4">
                <a href="generate_pdf.php" class="btn btn-confirm">Download PDF</a>
            </div>
        </form>
        <form action="view_pdf.php" method="post" target="_blank">
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary">View PDF</button>
            </div>
        </form>
    </div>
</body>
</html>
