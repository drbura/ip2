<?php
require '../student/connect.php';
session_start(); // Start session at the very beginning

$user_email = $_SESSION['email'] ?? ''; // Fetch email from session
$user_role = ''; // Initialize user_role

// Check if the user is a registrar or department head
$role_query_staff = "SELECT 'registrar' AS role FROM ddu_staff WHERE email = ?";
$role_query_substaff = "SELECT 'department_head' AS role, department FROM ddu_substaff WHERE email = ?";

// Check if the user is a registrar
$stmt = $conn->prepare($role_query_staff);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('s', $user_email);
$stmt->execute();
$role_result = $stmt->get_result();

if ($role_result && $role_result->num_rows > 0) {
    $user_role = 'Registrar';
    
    // Fetch all cleared students
    $display_query = "
        SELECT c.student_id, CONCAT(d.first_name, ' ', d.father_name, ' ', d.gfather_name) AS student_name, 
               c.department, c.AcademicYear, c.Semester
        FROM clearedstudentslist c
        INNER JOIN ddustudentdata d ON c.student_id = d.student_id
        WHERE c.is_completed = 1";

    $stmt = $conn->prepare($display_query);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $stmt->execute();
    $results = $stmt->get_result();
    
} else {
    // Check if the user is a department head
    $stmt = $conn->prepare($role_query_substaff);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $role_result = $stmt->get_result();

    if ($role_result && $role_result->num_rows > 0) {
        $user_data = $role_result->fetch_assoc();
        $user_role = 'Department Head';
        $user_department = $user_data['department'];

        // Fetch cleared students for the department head
        $display_query = "
            SELECT c.student_id, CONCAT(d.first_name, ' ', d.father_name, ' ', d.gfather_name) AS student_name, 
                   c.department, c.AcademicYear, c.Semester
            FROM clearedstudentslist c
            INNER JOIN ddustudentdata d ON c.student_id = d.student_id
            WHERE c.is_completed = 1 AND c.department = ?";

        $stmt = $conn->prepare($display_query);
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $stmt->bind_param('s', $user_department);
        $stmt->execute();
        $results = $stmt->get_result();

    } else {
        echo "<tr><td colspan='6'>Invalid User Role or Email</td></tr>";
        $results = false;
    }
}

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Student Clearance List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            margin-top: 70px;
            margin-left: 350px;
        }
        h1 {
            margin-top: 1rem;
        }
        .btn-group {
            display: flex;
            justify-content: flex-start; 
             gap: 5px; 
         }
    </style>
    <script>
        function promoteAll() {
            if (confirm("Are you sure you want to promote all cleared students?")) {
                $.ajax({
                    url: 'promote_logic.php',
                    type: 'POST',
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert("All students promoted successfully");
                            location.reload();  // Reload the page to reflect updated student data
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function () {
                        alert("An error occurred while promoting students.");
                    }
                });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12" align="center">
                <br>
                <h1 align="center">Cleared Students List</h1>
                <br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Academic Year</th>
                        <th>Semester</th>
                        <th>Action 
                            <?php if ($user_role === 'Registrar'): ?>
                                <button class="btn btn-primary btn-sm" onclick="promoteAll()">Promote All</button>
                            <?php endif; ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($results && $results->num_rows > 0) {
                            while ($data_row = $results->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data_row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($data_row['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($data_row['department']); ?></td>
                                    <td><?php echo htmlspecialchars($data_row['AcademicYear']); ?></td>
                                    <td><?php echo htmlspecialchars($data_row['Semester']); ?></td>
                                    <td>
    <div class="btn-group">
        <a href="student_specific.php?student_id=<?php echo htmlspecialchars($data_row['student_id']); ?>&action=view" class="btn btn-info btn-sm">View PDF</a>
        <a href="student_specific.php?student_id=<?php echo htmlspecialchars($data_row['student_id']); ?>&action=download" class="btn btn-success btn-sm">Download PDF</a>
    </div>
</td>

                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No Cleared Students yet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
