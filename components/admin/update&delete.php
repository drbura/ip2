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

// Assuming you're receiving arrays from the form
$id = $_POST['id'];
$staff_id = $_POST['staff_id'];
$subStaff_id = $_POST['subStaff_id'];
$schoolName = $_POST['schoolName'];
$collegeName = $_POST['collegeName'];
$staff = $_POST['staff'];
$department = $_POST['department'];
$year = $_POST['year'];
$semester = $_POST['semester'];
$position = $_POST['position'];
$first_names = $_POST['fName'];
$middle_names = $_POST['mName'];
$last_names = $_POST['lName'];
$roles = $_POST['role'];
$phones = $_POST['phone'];

for ($i = 0; $i < count($staff_ids); $i++) {
    $id = $conn->real_escape_string($id[$i]);
    $staff_id = $conn->real_escape_string($staff_id[$i]);
    $subStaff_id = $conn->real_escape_string($subStaff_id[$i]);
    $fName = $conn->real_escape_string($first_names[$i]);
    $mName = $conn->real_escape_string($middle_names[$i]);
    $lName = $conn->real_escape_string($last_names[$i]);
    $role = $conn->real_escape_string($roles[$i]);
    $phone = $conn->real_escape_string($phones[$i]);

    $sql = "UPDATE ddu_staff 
            SET fName='$fName', mName='$mName', lName='$lName', role='$role', phone='$phone' 
            WHERE staff_id='$staff_id'";

    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();

// Redirect back to the form page or a success page
header("Location: success_page.php");
exit();
?>
