<?php
session_start(); // Start session to access user data

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch user email and check if the user is a registrar
$user_email = $_SESSION['email'] ?? '';
if (!$user_email) {
    die(json_encode(['status' => 'error', 'message' => 'Session email not found']));
}

$role_query_staff = "SELECT 'registrar' AS role FROM ddu_staff WHERE email = ?";

$stmt = $conn->prepare($role_query_staff);
if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => 'Query preparation failed: ' . $conn->error]));
}
$stmt->bind_param('s', $user_email);
$stmt->execute();
$role_result = $stmt->get_result();

if ($role_result->num_rows == 0) {
    // If the user is not a registrar, stop the operation
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized action. Only registrars can promote students.']);
    exit();
}

// Fetch all students who have cleared and their promotion status
$sql = "SELECT c.student_id, d.Year, d.semester, c.reason, c.promoted 
        FROM clearedstudentslist c
        INNER JOIN ddustudentdata d ON c.student_id = d.student_id
        WHERE c.is_completed = 1";

$result = $conn->query($sql);

if (!$result) {
    // Handle SQL query failure
    die(json_encode(['status' => 'error', 'message' => 'Error fetching cleared students: ' . $conn->error]));
}

if ($result->num_rows > 0) {
    $promoted_students = 0; // Counter to track how many students get promoted

    while ($row = $result->fetch_assoc()) {
        $student_id = $row['student_id'];
        $year = $row['Year'];
        $semester = $row['semester'];
        $reason = strtolower($row['reason']); // Convert reason to lowercase for comparison
        $promoted = $row['promoted']; // Check if student is already promoted (0 = no, 1 = yes)

        // Debugging log for each student before promotion logic
        error_log("Processing student: ID = $student_id, Year = $year, Semester = $semester, Reason = $reason, Promoted = $promoted");

        // Check if student has already been promoted
        if ($promoted == 1) {
            error_log("Skipping student $student_id because they have already been promoted.");
            continue; // Skip this student
        }

        // Additional condition: Do not promote if student is in 5th Year, 2nd Semester
        if ($year == 5 && $semester == 2) {
            error_log("Skipping student $student_id because they are in 5th Year, 2nd Semester.");
            continue; // Skip this student
        }

        // Additional condition: Do not promote if reason is 'withdraw' or 'graduation'
        if ($reason == 'withdraw' || $reason == 'graduation') {
            error_log("Skipping student $student_id because their reason is $reason.");
            continue; // Skip this student
        }

        // Promotion logic based on current semester and year
        if ($semester == 1) {
            // If it's 1st semester, promote to 2nd semester in the same year
            $new_year = $year;
            $new_semester = 2;
        } elseif ($semester == 2) {
            // If it's 2nd semester, promote to 1st semester in the next year
            $new_year = $year + 1;
            $new_semester = 1;
        } else {
            // In case of an unexpected semester value
            error_log("Unexpected semester value for student $student_id: $semester. Skipping.");
            continue;
        }

        // Update student semester and year
        $update_sql = "UPDATE ddustudentdata SET Year = '$new_year', semester = '$new_semester' 
                       WHERE student_id = '$student_id'";

        if (!$conn->query($update_sql)) {
            // Log and return if there's an error during the update
            die(json_encode(['status' => 'error', 'message' => 'Error updating student ' . $student_id . ': ' . $conn->error]));
        }

        // Mark the student as promoted in clearedstudentslist
        $mark_promoted_sql = "UPDATE clearedstudentslist SET promoted = 1 WHERE student_id = '$student_id'";
        if (!$conn->query($mark_promoted_sql)) {
            // Log and return if there's an error during the update
            die(json_encode(['status' => 'error', 'message' => 'Error marking student as promoted: ' . $conn->error]));
        }

        // Increment the counter for promoted students
        $promoted_students++;
    }

    if ($promoted_students > 0) {
        echo json_encode(['status' => 'success', 'message' => "Successfully promoted $promoted_students students"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No students were promoted. Either they reached the promotion limit, were already promoted, or have withdrawal/graduation reasons.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No students found to promote']);
}

$conn->close();
?>
