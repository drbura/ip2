<?php
require_once 'db_config.php'; // Your database connection

function getAssignedSchoolDeans() {
    global $conn;

    $query = "SELECT DISTINCT schoolName FROM ddu_staff WHERE staff = 'SchoolDean'";
    $result = mysqli_query($conn, $query);

    $assignedDeans = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $assignedDeans[] = $row['schoolName'];
    }
    mysqli_close($conn);

    return $assignedDeans;
}

header('Content-Type: application/json');
echo json_encode(getAssignedSchoolDeans());
?>
