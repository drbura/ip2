<?php
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

// SQL query to get recently rejected students
$sql = "
SELECT 
    StudentId, 
    GREATEST(
        IF(Advisor = 'REJECT', RequestDate, '0000-00-00'),
        IF(LabAssistant = 'REJECT', RequestDate, '0000-00-00'),
        IF(DepartmentHead = 'REJECT', RequestDate, '0000-00-00'),
        IF(SchoolDean = 'REJECT', RequestDate, '0000-00-00'),
        IF(BookStore = 'REJECT', RequestDate, '0000-00-00'),
        IF(Library = 'REJECT', RequestDate, '0000-00-00'),
        IF(Cafeteria = 'REJECT', RequestDate, '0000-00-00'),
        IF(StudentLoan = 'REJECT', RequestDate, '0000-00-00'),
        IF(Dormitory = 'REJECT', RequestDate, '0000-00-00'),
        IF(StudentService = 'REJECT', RequestDate, '0000-00-00'),
        IF(Store = 'REJECT', RequestDate, '0000-00-00'),
        IF(AcademicEnrollment = 'REJECT', RequestDate, '0000-00-00')
    ) AS LastRejectionDate
FROM request
HAVING LastRejectionDate != '0000-00-00'
ORDER BY LastRejectionDate ASC;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='activity-item d-flex'>";
        echo "<div class='activite-label'>" . date_diff(date_create($row['LastRejectionDate']), date_create('today'))->format('%a days ago') . "</div>";
        echo "<i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>";
        echo "<div class='activity-content'>";
        echo "Student ID: <a href='#' class='fw-bold text-dark'>{$row['StudentId']}</a> was rejected.";
        echo "</div>";
        echo "</div><!-- End activity item -->";
    }
} else {
    echo "<div class='activity-item d-flex'>";
    echo "<div class='activity-content'>No rejected students found</div>";
    echo "</div><!-- End activity item -->";
}

$conn->close();
?>
