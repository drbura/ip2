<?php
// session_start();

$actor = $_GET['actor'] ?? '';

// Ensure $actor is a valid column name
$validActors = ['Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 'Store', 'Library', 'BookStore', 'Cafeteria', 'AcademicEnrollment', 'StudentService', 'Dormitory', 'StudentLoan'];

if (!in_array($actor, $validActors)) {
    die("Invalid actor specified.");
}

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

function fetchRequests($conn, $actor, $searchTerm = '') {
    // Prepare the SQL query
    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            ddustudentdata.first_name, ddustudentdata.father_name, ddustudentdata.school, ddustudentdata.department, ddustudentdata.year, ddustudentdata.semester
            FROM request 
            JOIN ddustudentdata ON request.StudentId = ddustudentdata.student_id";

    if (!empty($searchTerm)) {
        $sql .= " WHERE request.StudentId LIKE ?";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    if (!empty($searchTerm)) {
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bind_param('s', $searchTerm);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $requests = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Apply approval sequence logic
            if ($actor === 'Advisor' && $row['LabAssistant'] !== 'APPROVED') {
                continue; // Skip if LabAssistant hasn't approved
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

$searchTerm = $_GET['search'] ?? '';
$requests = fetchRequests($conn, $actor, $searchTerm);
$conn->close();

$showSearchAndApproveAll = in_array($actor, $validActors);
?>

<script>
comfirm("This is your email" $UserEmail)
</script>
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
            margin-top: 70px;
            margin-left: 350px;
        }
        .status-btn {
            margin-right: 2px;
        }
        .btn {
            padding: 3px;
            font-size: 15px;
        }
        .search-bar {
            margin-bottom: 20px;
            align-content: center;
        }
        .approve-all-btn {
            /* margin-top: 10px; */
            border-radius: 15px;
            font-family: Courier, monospace;
            font-size: 10px;
        }
        #search {
            width: 400px;
            margin: auto;
            border-radius: 15px;
            font-weight: bold;
            font-family: Courier, monospace;
            border-width:  medium;
        }
    </style>
</head>
<body>
    <div class="container">
    
        <?php if ($showSearchAndApproveAll): ?>
            <div class="search-bar">
                <input type="hidden" id="actor" value="<?php echo htmlspecialchars($actor); ?>">
                <input type="text" id="search" class="form-control" placeholder="Search">
                <!-- <button type="button" id="searchBtn" class="btn btn-primary mt-2">Search</button> -->
            </div>
        <?php endif; ?>
        <table class="table table-bordered" id="requestsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>College</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Status    <button class="btn btn-success approve-all-btn" onclick="approveAll()">Approve All</button>
</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here via AJAX -->
            </tbody>
        </table>
        
    </div>
    <script>
        $(document).ready(function() {
            const actor = $('#actor').val();

            function fetchRequests(searchTerm = '') {
                $.ajax({
                    type: 'GET',
                    url: 'actor_clearance_fetch.php',
                    data: { actor: actor, search: searchTerm },
                    success: function(response) {
                        $('#requestsTable tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", error);
                        console.error("Response text:", xhr.responseText);
                    }
                });
            }

            $('#search').on('input', function() {
                const searchTerm = $(this).val();
                fetchRequests(searchTerm);
            });

            fetchRequests(); // Initial fetch to display all data

            $('#searchBtn').on('click', function() {
                const searchTerm = $('#search').val();
                fetchRequests(searchTerm);
            });
        });

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

        function approveAll() {
            if (confirm("Are you sure you want to approve all requests?")) {
                $.ajax({
                    type: 'POST',
                    url: 'actor_approve_all.php',
                    data: { actor: '<?php echo $actor; ?>' },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", error);
                        console.error("Response text:", xhr.responseText);
                    }
                });
            }
        }
    </script>
</body>
</html>
