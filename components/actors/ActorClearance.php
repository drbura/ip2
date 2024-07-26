<?php
$actor = $_GET['actor'] ?? '';

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchRequests($conn, $actor) {
    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            student_data.Fname, student_data.Mname 
            FROM request 
            JOIN student_data ON request.StudentId = student_data.student_id";
    $result = $conn->query($sql);

    $requests = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Apply approval sequence logic
            if ($actor === 'LabAssistant' && $row['Advisor'] !== 'APPROVED') {
                continue; // Skip if Advisor hasn't approved
            }
            if ($actor === 'DepartmentHead' && ($row['Advisor'] !== 'APPROVED' || $row['LabAssistant'] !== 'APPROVED')) {
                continue; // Skip if either Advisor or LabAssistant hasn't approved
            }
            if ($actor === 'SchoolDean' && ($row['Advisor'] !== 'APPROVED' || $row['LabAssistant'] !== 'APPROVED' || $row['DepartmentHead'] !== 'APPROVED')) {
                continue; // Skip if Advisor, LabAssistant, or DepartmentHead hasn't approved
            }
            $requests[] = $row;
        }
    }
    return $requests;
}

$requests = fetchRequests($conn, $actor);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($actor); ?> Clearance</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            margin-top: 100px; /* 100px from the top */
            margin-left: 350px; /* 300px from the left */
        }
        .status-btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo htmlspecialchars($actor); ?> Clearance Requests</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['StudentId']); ?></td>
                        <td><?php echo htmlspecialchars($request['Fname'] . ' ' . $request['Mname']); ?></td>
                        <td>
                            <?php if ($request[$actor] == 'APPROVED') : ?>
                                <button class="btn btn-success status-btn" disabled>Approved</button>
                                <button class="btn btn-warning status-btn" onclick="updateStatus(<?php echo $request['RequestId']; ?>, 'PENDING')">Restore</button>
                            <?php elseif ($request[$actor] == 'REJECT') : ?>
                                <button class="btn btn-danger status-btn" disabled>Rejected</button>
                                <button class="btn btn-warning status-btn" onclick="updateStatus(<?php echo $request['RequestId']; ?>, 'PENDING')">Restore</button>
                            <?php else : ?>
                                <button class="btn btn-success status-btn" onclick="updateStatus(<?php echo $request['RequestId']; ?>, 'APPROVED')">Approve</button>
                                <button class="btn btn-danger status-btn" onclick="updateStatus(<?php echo $request['RequestId']; ?>, 'REJECT')">Reject</button>
                                <button class="btn btn-warning status-btn" onclick="updateStatus(<?php echo $request['RequestId']; ?>, 'PENDING')">Restore</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function updateStatus(requestId, status) {
            $.ajax({
                type: 'POST',
                url: 'actor_update_status.php',
                data: { requestId: requestId, status: status, actor: '<?php echo $actor; ?>' },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    console.error("Response text:", xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
