<?php
// Database connection
include('db_config.php');

// Fetch assigned roles from the database
$query = "SELECT DISTINCT staff FROM ddu_staff";
$result = mysqli_query($conn, $query);

$assignedRoles = [];

while ($row = mysqli_fetch_assoc($result)) {
    $assignedRoles[] = $row['staff'];
}

// Return the assigned roles as a JSON array
echo json_encode($assignedRoles);
?>

