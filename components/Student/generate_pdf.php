<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: welcome.php');
    exit;
}

require 'vendor/autoload.php'; // Ensure you have installed mPDF via Composer
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

// Generate PDF using mPDF
$mpdf = new \Mpdf\Mpdf();
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dduclerance Final Status</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .status-approved { background-color: #d4edda; }
        .status-rejected { background-color: #f8d7da; }
        .status-pending { background-color: #fff3cd; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Final Status</h1>
        <table>
            
           
            <tbody>
                <tr>
                    <td>Full Name</td>
                    <td>' . htmlspecialchars($fullName) . '</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>' . htmlspecialchars($student['student_id']) . '</td>
                </tr>
                <tr>
                    <td>College</td>
                    <td>' . htmlspecialchars($student['school']) . '</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>' . htmlspecialchars($student['Department']) . '</td>
                </tr>
                <tr>
                    <td>year</td>
                    <td>' . htmlspecialchars($student['year']) . '</td>
                </tr>
                <tr>
                    <td>semester</td>
                    <td>' . htmlspecialchars($student['semester']) . '</td>
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
foreach ($request as $actor => $status) {
    if (in_array($actor, ['Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 'BookStore', 'Library', 'Cafeteria', 'StudentLoan', 'Dormitory', 'StudentService', 'Store', 'AcademicEnrollment'])) {
        $class = $status === 'REJECT' ? 'status-rejected' : ($status === 'APPROVED' ? 'status-approved' : 'status-pending');
        $html .= '
                <tr>
                    <td>' . htmlspecialchars($actor) . '</td>
                    <td class="' . $class . '">' . htmlspecialchars($status) . '</td>
                </tr>';
    }
}
$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('Final_Status_' . htmlspecialchars($student['student_id']) . '.pdf', 'D');
exit;
?>