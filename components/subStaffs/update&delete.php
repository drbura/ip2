<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine whether it's an update or delete action
$action = $_POST['action'];
$id = $_POST['id'];
$table = $_POST['table'];

if ($action == "update") {
    $data = $_POST['data']; // This will be the key-value pairs sent via AJAX
    $setStatements = [];

    // Construct SQL SET clause from the received data
    foreach ($data as $key => $value) {
        list($column) = explode('-', $key); // Extract column name
        $column = $conn->real_escape_string($column);
        $value = $conn->real_escape_string($value);
        $setStatements[] = "$column='$value'";
    }

    $setClause = implode(", ", $setStatements);

    // Determine which table and primary key column to update
    switch ($table) {
        case "admin-table":
            $sql = "UPDATE ddu_admin SET $setClause WHERE id='$id'";
            break;
        case "deans-table":
        case "staff-table":
            $sql = "UPDATE ddu_staff SET $setClause WHERE staff_id='$id'";
            break;
        case "heads-table":
        case "lab-assistants-table":
        case "advisors-table":
            $sql = "UPDATE ddu_subStaff SET $setClause WHERE subStaff_id='$id'";
            break;
        default:
            echo "Invalid table";
            exit();
    }

    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }

} elseif ($action == "delete") {
    // Determine which table and primary key column to delete
    switch ($table) {
        case "admin-table":
            $sql = "DELETE FROM ddu_admin WHERE id='$id'";
            break;
        case "deans-table":
        case "staff-table":
            $sql = "DELETE FROM ddu_staff WHERE staff_id='$id'";
            break;
        case "heads-table":
        case "lab-assistants-table":
        case "advisors-table":
            $sql = "DELETE FROM ddu_subStaff WHERE subStaff_id='$id'";
            break;
        default:
            echo "Invalid table";
            exit();
    }

    if ($conn->query($sql) !== TRUE) {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
exit();
?>
