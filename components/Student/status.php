<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: welcome.php');
    exit;
}

include 'connect.php'; // Ensure this file correctly sets up $conn

$studentId = $_SESSION['id']; // Ensure student_id is stored in session

// Query to get the latest request for the student
$sql = "SELECT Advisor, LabAssistant, DepartmentHead, SchoolDean, BookStore, Library, Cafeteria, StudentLoan, Dormitory, StudentService, Store, AcademicEnrollment FROM request WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
//    //   Simulate that all statuses are "APPROVED"
//      $statuses = array_map(function() {
//          return 'APPROVED';
//      }, $row);
    // Filter out statuses that are "PENDING"
    $statuses = array_filter($row, function($status) {
            return $status !== 'Pending';
    });
} else {
    $statuses = []; // No status to show
}

// Handle form submission to update the status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // Transfer data from `request` table to `request_log` table
    $sql_select_request = "SELECT * FROM request WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1";
    $stmt_select_request = $conn->prepare($sql_select_request);
    if ($stmt_select_request === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt_select_request->bind_param("s", $studentId);
    $stmt_select_request->execute();
    $result_request = $stmt_select_request->get_result();
    
    if ($request_data = $result_request->fetch_assoc()) {
        // Insert the fetched data into `request_log` table
        $sql_insert_log = "INSERT INTO request_processed (StudentId,AcademicYear,Semester, Reason, RequestDate, Advisor, LabAssistant, DepartmentHead, SchoolDean, BookStore, Library, Cafeteria, StudentLoan, Dormitory, StudentService, Store, AcademicEnrollment)
                           VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_log = $conn->prepare($sql_insert_log);
        if ($stmt_insert_log === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        // Bind parameters for inserting into `request_log`
        $stmt_insert_log->bind_param(
            "sssssssssssssssss", 
            $request_data['StudentId'],
            $request_data['AcademicYear'],
            $request_data['Semester'],
            $request_data['Reason'], 
            $request_data['RequestDate'], 
            $request_data['Advisor'], 
            $request_data['LabAssistant'], 
            $request_data['DepartmentHead'], 
            $request_data['SchoolDean'], 
            $request_data['BookStore'], 
            $request_data['Library'], 
            $request_data['Cafeteria'], 
            $request_data['StudentLoan'], 
            $request_data['Dormitory'], 
            $request_data['StudentService'], 
            $request_data['Store'], 
            $request_data['AcademicEnrollment']
        );

        // Execute the insert
        if ($stmt_insert_log->execute()) {
            // Delete the student's record from the `request` table after successful transfer
            $sql_delete_request = "DELETE FROM request WHERE StudentId = ?";
            $stmt_delete_request = $conn->prepare($sql_delete_request);
            if ($stmt_delete_request === false) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt_delete_request->bind_param("s", $studentId);
            if ($stmt_delete_request->execute()) {
                // Record deleted successfully from the `request` table
                echo "Record successfully transferred to request_log and deleted from request.";
            } else {
                echo "Error deleting record from request: " . $conn->error;
            }
            $stmt_delete_request->close();
        } else {
            echo "Error inserting record into request_log: " . $conn->error;
        }
        $stmt_insert_log->close();
    } else {
        echo "No request found to log.";
    }

    $stmt_select_request->close();

    // Check if student is already in clearedstudentslist
    $sql_check = "SELECT COUNT(*) AS count FROM clearedstudentslist WHERE student_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt_check->bind_param("s", $studentId);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    $stmt_check->close();

    if ($row_check['count'] == 0) {
        // Student is not yet in clearedstudentslist, so insert
        // Prepare the SQL query to insert into clearedstudentslist table
        $sql_insert = "INSERT INTO clearedstudentslist (student_id, full_name, department, AcademicYear, Semester, Reason, ClearedDate, is_completed) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
    
        // Fetch the student's full name and department from ddustudentdata
        $sql_student = "SELECT first_name, father_name, gfather_name, department FROM ddustudentdata WHERE student_id = ?";
        $stmt_student = $conn->prepare($sql_student);
        if ($stmt_student === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt_student->bind_param("s", $studentId);
        $stmt_student->execute();
        $result_student = $stmt_student->get_result();
        if ($result_student === false) {
            die("Execute failed: (" . $stmt_student->errno . ") " . $stmt_student->error);
        }
        $student = $result_student->fetch_assoc();
        $fullName = $student['first_name'] . ' ' . $student['father_name'] . ' ' . $student['gfather_name'];
        $department = $student['department'];  // Fetch the department
        $stmt_student->close();
    
        // Fetch AcademicYear, Semester, and Reason from request_log
        $sql_log = "SELECT AcademicYear, Semester, Reason FROM request_processed WHERE studentid = ? ORDER BY RequestDate DESC LIMIT 1";
        $stmt_log = $conn->prepare($sql_log);
        if ($stmt_log === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt_log->bind_param("s", $studentId);
        $stmt_log->execute();
        $result_log = $stmt_log->get_result();
        if ($result_log === false || $result_log->num_rows == 0) {
            die("No log data found for the student.");
        }
        $log = $result_log->fetch_assoc();
        $AcademicYear = $log['AcademicYear'];
        $Semester = $log['Semester'];
        $Reason = $log['Reason'];
        $stmt_log->close();
    
        // Set ClearedDate to the current timestamp
        $ClearedDate = date("Y-m-d H:i:s");
    
        // Bind parameters and execute the insert query into clearedstudentslist
        $stmt_insert->bind_param("sssssss", $studentId, $fullName, $department, $AcademicYear, $Semester, $Reason, $ClearedDate);
        if ($stmt_insert->execute()) {
            // Redirect to final_status.php after successful update
            header('Location: final_status.php');
            exit;
        } else {
            echo "Error inserting record: " . $conn->error;
        }
        $stmt_insert->close();
    } else {
        // Student already exists in clearedstudentslist
        echo "Student has already been processed.";
    }
    
}    


$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            max-width: 1000px;
            margin-top: 30px;
        }
        .navbar-custom {
            /* background-color: #007bff; */
            background-color: orange;
            height: 60px;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }
        .navbar-custom .dropdown-menu {
            right: 0;
            left: auto;
        }
        .navbar-toggler {
            border: none;
        }
        .btn-success {
            background-color: green;
            color: white;
            border: none;
        }
        .btn-danger {
            background-color: red;
            color: white;
            border: none;
        }
        .btn-warning {
            background-color: orange;
            color: white;
            border: none;
        }
        .btn-confirm {
            background-color: blue;
            color: white;
            border: none;
        }
        .btn-confirm:disabled {
            background-color: gray;
        }
        ul{
            list-style-type: none;
        }
        li{
            font-size: large;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">

        <img src="../Images/download.jpg" alt="DDU Logo">

           

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li><?php echo $studentId ?></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <ul >
                            <li><?php echo $studentId ?></li>
                        </ul>
                        <a class="dropdown-item" href="index.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">Status Overview</h1>
        <?php if (!empty($statuses)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Clearance Staff</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statuses as $actor => $status): ?>
                <tr>
                    <td><?php echo htmlspecialchars($actor); ?></td>
                    <td>
                        <button class="btn <?php echo $status === 'REJECT' ? 'btn-danger' : ($status === 'APPROVED' ? 'btn-success' : 'btn-warning'); ?>" disabled>
                            <?php echo htmlspecialchars($status); ?>
                        </button>

                        <?php if ($status === 'REJECT'): ?>
                        <button class="btn btn-info view-reason" data-actor="<?php echo htmlspecialchars($actor); ?>">View Reason</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <form action="status.php" method="post">
                <input type="hidden" name="confirm" value="1">
                <button id="confirmButton" type="submit" class="btn btn-confirm">Get Clearance</button>
            </form>
            <br><br><br>
        </div>
        <?php else: ?>
        <p class="text-center">No status updates available.</p>
        <?php endif; ?>
    </div>
    <!-- Modal Popup for reject reason -->
    <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Reason for Rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Reason content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Popup for reject reason -->

    <script>
        $(document).ready(function() {
            function updateConfirmButton() {
                // Check if all status buttons are 'APPROVED'
                let allApproved = true;
                $('table tbody tr').each(function() {
                    const statusButton = $(this).find('button');
                    if (statusButton.text().trim() !== 'APPROVED') {
                        allApproved = false;
                        return false; // Exit loop early
                    }
                });

                // Enable or disable the confirm button based on status
                $('#confirmButton').prop('disabled', !allApproved);
            }

            // Call updateConfirmButton initially
            updateConfirmButton();

            // Handle View Reason button click
    $('.view-reason').on('click', function() {
        const actor = $(this).data('actor');

        $.ajax({
            url: 'fetch_reason.php',
            type: 'POST',
            data: { actor: actor, studentId: "<?php echo $studentId; ?>" },
            success: function(response) {
                // Show the reason in the modal
                $('#reasonModal .modal-body').html(response);
                $('#reasonModal').modal('show');
            },
            error: function() {
                alert('Failed to fetch reason.');
            }
        });
    });
});
    </script>
</body>
</html>
