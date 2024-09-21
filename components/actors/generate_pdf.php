<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    die("No student ID set in session.");
}

require 'vendor/autoload.php'; // Ensure you have installed mPDF via Composer
include '../Student/connect.php'; // Ensure this file correctly sets up $conn

$studentId = $_SESSION['student_id'];

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

// Generate PDF using mPDF
$mpdf = new \Mpdf\Mpdf();
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dire Dawa University Student Clearance (Withdraw Form) for Regular Undergraduate Students</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .status-approved { background-color: #d4edda; }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 80px;
            width: 80px;
            margin: 0 10px;
        }
        .header h1 {
            display: inline-block;
            margin: 0 20px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
   <div class="header">
        <img src="../Images/download.jpg" alt="DDU Logo">
        <h1>
            Dire Dawa University<br>
            Student Clearance (Withdraw Form)<br>
            for Regular Undergraduate Students
        </h1>
    </div>
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td>Full Name</td>
                    <td>' . htmlspecialchars($fullName) . '</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>' . htmlspecialchars($studentId) . '</td>
                </tr>
                <tr>
                    <td>College</td>
                    <td>' . htmlspecialchars($school) . '</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>' . htmlspecialchars($department) . '</td>
                </tr>
                <tr>
                    <td>Academic Year</td>
                    <td>' . htmlspecialchars($academicYear) . '</td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td>' . htmlspecialchars($semester) . '</td>
                </tr>
                <tr>
                    <td>Reason</td>
                    <td>' . htmlspecialchars($request['Reason']) . '</td>
                </tr>
                <tr>
                    <td>Request Date</td>
                    <td>' . htmlspecialchars($request['RequestDate']) . '</td>
                </tr>
            </tbody>
        </table>
        <h2>Approvals</h2>
        <table>
            <tbody>';
// Hardcoded approvals as 'APPROVED'
$approvals = [
    'Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 'BookStore', 'Library', 'Cafeteria', 
    'StudentLoan', 'Dormitory', 'StudentService', 'Store', 'AcademicEnrollment'
];

foreach ($approvals as $actor) {
    $status = 'APPROVED'; // Default status for all
    $class = 'status-approved';
    $html .= '
            <tr>
                <td>' . htmlspecialchars($actor) . '</td>
                <td class="' . $class . '">' . htmlspecialchars($status) . '</td>
            </tr>';
}

$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>';

// Output the PDF
$mpdf->WriteHTML($html);
$mpdf->Output('Final_Status_' . htmlspecialchars($studentId) . '.pdf', 'D'); // 'I' to display in browser
exit;
?>
