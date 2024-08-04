<?php
$servername = "localhost";
$username = "root"; // change this if your MySQL user is different
$password = ""; // change this if your MySQL password is different
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $father_name = $_POST['father_name'];
    $gfather_name = $_POST['gfather_name'];
    $gender = $_POST['gender'];
    $enrolment_date = $_POST['enrolment_date'];
    $year = $_POST['year'];
    $semester = $_POST['semister'];
    $marital_status = $_POST['Marital_status'];
    $nationality = $_POST['Nationality'];
    $school = $_POST['school'];
    $department = $_POST['department'];
    $amharic_first_name = $_POST['amharic_first_name'];
    $amharic_middle_name = $_POST['amharic_middle_name'];
    $amharic_last_name = $_POST['amharic_last_name'];
    $mother_first_name = $_POST['mother_first_name'];
    $mother_last_name = $_POST['mother_last_name'];
    $father_occupation = $_POST['father_occupation'];
    $mother_occupation = $_POST['mother_occupation'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob2 = $_POST['dob2'];
    $birth_place = $_POST['birth_place'];
    $religion = $_POST['religion'];
    $ethnic = $_POST['ethnic'];

    // Handle file upload
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }

    $stmt = $conn->prepare("INSERT INTO dduStudentData (student_id, first_name, father_name, gfather_name, dob, gender, enrolment_date, year, semester, marital_status, nationality, school, department, amharic_first_name, amharic_middle_name, amharic_last_name, mother_first_name, mother_last_name, father_occupation, mother_occupation, email, phone_number, dob2, birth_place, religion, ethnic, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssiiissssssssssssssssb", $student_id, $first_name, $father_name, $gfather_name, $dob, $gender, $enrolment_date, $year, $semester, $marital_status, $nationality, $school, $department, $amharic_first_name, $amharic_middle_name, $amharic_last_name, $mother_first_name, $mother_last_name, $father_occupation, $mother_occupation, $email, $phone_number, $dob2, $birth_place, $religion, $ethnic, $photo);

    if ($stmt->execute()) {
        header('Location: index.php');
} else {
    echo "Error: " . $stmt->error;
}

    $stmt->close();
}

$conn->close();
?>
