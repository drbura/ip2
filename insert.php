<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['father_name']); 
    $last_name = mysqli_real_escape_string($conn, $_POST['gfather_name']); 
    $birth_date = mysqli_real_escape_string($conn, $_POST['dob']);
    $sex = mysqli_real_escape_string($conn, $_POST['gender']);
    $enrollment_date = mysqli_real_escape_string($conn, $_POST['enrolment_date']);
    $school = mysqli_real_escape_string($conn, $_POST['school']);
    $department = mysqli_real_escape_string($conn, $_POST['slct2']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO student_data (student_id, Fname, Mname, Lname, birth_date, sex, enrollment_date, school, department) 
            VALUES ('$student_id', '$first_name', '$middle_name', '$last_name', '$birth_date', '$sex', '$enrollment_date', '$school', '$department')";
    // Execute the query
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

    // Close the database connection
    mysqli_close($conn);
}

?>
<?php include 'admition.php' ?>