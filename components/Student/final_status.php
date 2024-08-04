<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: welcome.php');
    exit;
}

include 'connect.php'; // Ensure this file correctly sets up $conn

$studentId = $_SESSION['id']; // Ensure student_id is stored in session

// Query to fetch student details from ddustudentdata table
$sql_student = "SELECT first_name, father_name, gfather_name, student_id, Department,year,semester, school FROM ddustudentdata WHERE student_id = ?";
$stmt_student = $conn->prepare($sql_student);
if ($stmt_student === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_student->bind_param("s", $studentId);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
if ($result_student === false) {
    die("Execute failed: (" . $stmt_student->errno . ") " . $stmt_student->error);
}

$student = $result_student->fetch_assoc();
$stmt_student->close();

// Concatenate full name
$fullName = $student['first_name'] . ' ' . $student['father_name'] . ' ' . $student['gfather_name'];

// Query to fetch clearance reason and request date from request table
$sql_request = "SELECT Reason, RequestDate, Advisor, LabAssistant, DepartmentHead, SchoolDean, BookStore, Library, Cafeteria, StudentLoan, Dormitory, StudentService, Store, AcademicEnrollment FROM request WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1";
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
    <div class="container">
        <h1 class="text-center">dduclerance Final Status</h1>
        <table class="table table-striped">
           
            <tbody>
                <tr>
                    <td>Full Name</td>
                    <td><?php echo htmlspecialchars($fullName); ?></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                </tr>
                <tr>
                    <td>College</td>
                    <td><?php echo htmlspecialchars($student['school']); ?></td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td><?php echo htmlspecialchars($student['Department']); ?></td>
                </tr>
                <tr>
                    <td>year</td>
                    <td><?php echo htmlspecialchars($student['year']); ?></td>
                </tr>
                <tr>
                    <td>semester</td>
                    <td><?php echo htmlspecialchars($student['semester']); ?></td>
                </tr>
                <tr>
                    <td>Reason</td>
                    <td><?php echo htmlspecialchars($request['Reason']); ?></td>
                </tr>
                <tr>
                    <td>Request Date</td>
                    <td><?php echo htmlspecialchars($request['RequestDate']); ?></td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center">Approvals</h2>
        <table class="table table-striped">
            
            <tbody>
                <?php foreach ($request as $actor => $status): ?>
                    <?php if (in_array($actor, ['Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 'BookStore', 'Library', 'Cafeteria', 'StudentLoan', 'Dormitory', 'StudentService', 'Store', 'AcademicEnrollment'])): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($actor); ?></td>
                            <td>
                                <button class="btn <?php echo $status === 'REJECT' ? 'btn-danger' : ($status === 'APPROVED' ? 'btn-success' : 'btn-warning'); ?>" disabled>
                                    <?php echo htmlspecialchars($status); ?>
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="generate_pdf.php" class="btn btn-confirm">Download PDF</a>
        </div>
    </div>
</body>
</html>
