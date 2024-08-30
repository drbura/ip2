<?php
// line_chart_report.php

// Database connection details
$host = 'localhost';
$db = 'ddu_clerance';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to count the status for each actor
$sql = "
    SELECT
    actor,
    SUM(CASE WHEN status = 'PENDING' THEN 1 ELSE 0 END) AS PendingCount,
    SUM(CASE WHEN status = 'REJECT' THEN 1 ELSE 0 END) AS RejectedCount,
    SUM(CASE WHEN status = 'APPROVED' THEN 1 ELSE 0 END) AS ApprovedCount
FROM (
    SELECT 'Advisor' AS actor, Advisor AS status FROM request
    UNION ALL
    SELECT 'LabAssistant' AS actor, LabAssistant AS status FROM request
    UNION ALL
    SELECT 'DepartmentHead' AS actor, DepartmentHead AS status FROM request
    UNION ALL
    SELECT 'SchoolDean' AS actor, SchoolDean AS status FROM request
    UNION ALL
    SELECT 'BookStore' AS actor, BookStore AS status FROM request
    UNION ALL
    SELECT 'Library' AS actor, Library AS status FROM request
    UNION ALL
    SELECT 'Cafeteria' AS actor, Cafeteria AS status FROM request
    UNION ALL
    SELECT 'StudentLoan' AS actor, StudentLoan AS status FROM request
    UNION ALL
    SELECT 'Dormitory' AS actor, Dormitory AS status FROM request
    UNION ALL
    SELECT 'StudentService' AS actor, StudentService AS status FROM request
    UNION ALL
    SELECT 'Store' AS actor, Store AS status FROM request
    UNION ALL
    SELECT 'AcademicEnrollment' AS actor, AcademicEnrollment AS status FROM request
) AS combined
GROUP BY actor
    -- Add similar queries for other actors as needed
";

$result = $conn->query($sql);

$actors = [];
$pendingCounts = [];
$approvedCounts = [];
$rejectedCounts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $actors[] = $row['actor'];
        $pendingCounts[] = $row['PendingCount'];
        $approvedCounts[] = $row['ApprovedCount'];
        $rejectedCounts[] = $row['RejectedCount'];
    }
}

$conn->close();

$data = [
    'actors' => $actors,
    'pendingCounts' => $pendingCounts,
    'approvedCounts' => $approvedCounts,
    'rejectedCounts' => $rejectedCounts,
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
