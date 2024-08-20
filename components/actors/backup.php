
actor clearance file 

<?php
// session_start();

// $UserEmail = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Retrieve the email from the session

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

function fetchRequests($conn, $actor, $searchTerm = '') {
    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            ddustudentdata.first_name, ddustudentdata.father_name, ddustudentdata.school, ddustudentdata.department, ddustudentdata.year, ddustudentdata.semester
            FROM request 
            JOIN ddustudentdata ON request.StudentId = ddustudentdata.student_id";

    if (!empty($searchTerm)) {
        $sql .= " WHERE request.StudentId LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
    }

    $result = $conn->query($sql);

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

$showSearchAndApproveAll = in_array($actor, ['LabAssistant', 'Advisor','DepartmentHead','SchoolDean','Store', 'Library', 'BookStore', 'Cafeteria', 'AcademicEnrollment', 'StudentService', 'Dormitory', 'StudentLoan']);
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
        <h1 class="text-center"><?php echo htmlspecialchars($actor); ?> Clearance Requests</h1>
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


actor clearance fetch file 
<?php
session_start();
$actor = $_GET['actor'] ?? '';
$searchTerm = $_GET['search'] ?? '';
$userEmail = $_SESSION['email'] ?? '';

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

function fetchRequests($conn, $actor, $searchTerm = '', $userEmail = '') {
    $allowedActors = ['Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean'];

    if (!in_array($actor, $allowedActors)) {
        die("Invalid actor specified.");
    }

    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            ddustudentdata.first_name, ddustudentdata.father_name, ddustudentdata.school, ddustudentdata.department, ddustudentdata.year, ddustudentdata.semester
            FROM request 
            JOIN ddustudentdata ON request.StudentId = ddustudentdata.student_id";

    // Check for advisor, lab assistant, department head, or school dean
    if (!empty($userEmail)) {
        $substaffQuery = "";
        if ($actor === 'SchoolDean') {
            $substaffQuery = "SELECT schoolName FROM ddu_staff WHERE email = ?";
        } elseif ($actor === 'DepartmentHead') {
            $substaffQuery = "SELECT department, collegeName FROM ddu_subStaff WHERE email = ?";
        } else { // Advisor or LabAssistant
            $substaffQuery = "SELECT department, year, semester FROM ddu_subStaff WHERE email = ?";
        }
        
        $stmt = $conn->prepare($substaffQuery);
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();
        $substaffResult = $stmt->get_result();

        if ($substaffResult->num_rows > 0) {
            $substaff = $substaffResult->fetch_assoc();
            $conditions = [];

            if ($actor === 'SchoolDean') {
                $conditions[] = "ddustudentdata.school = ?";
            } elseif ($actor === 'DepartmentHead') {
                $conditions[] = "ddustudentdata.department = ?";
                $conditions[] = "ddustudentdata.school = ?";
            } elseif ($actor === 'Advisor' || $actor === 'LabAssistant') {
                $conditions[] = "ddustudentdata.department = ?";
                $conditions[] = "ddustudentdata.year = ?";
                $conditions[] = "ddustudentdata.semester = ?";
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
                $stmt->close();

                // Prepare the statement again with the new conditions
                $stmt = $conn->prepare($sql);

                // Bind parameters dynamically based on the conditions
                $types = str_repeat('s', count($conditions));
                $params = array_values($substaff);
                $stmt->bind_param($types, ...$params);

                $stmt->execute();
                $result = $stmt->get_result();
            }
        }
    }

    if (!empty($searchTerm)) {
        $searchCondition = "request.StudentId LIKE ?";
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND " . $searchCondition;
        } else {
            $sql .= " WHERE " . $searchCondition;
        }

        $searchTerm = '%' . $searchTerm . '%';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    if (!$result) {
        die("Query error: " . $conn->error);
    }

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

$requests = fetchRequests($conn, $actor, $searchTerm, $userEmail);

$conn->close();

foreach ($requests as $request) {
    echo '<tr>
        <td>' . htmlspecialchars($request['StudentId']) . '</td>
        <td>' . htmlspecialchars($request['first_name'] . ' ' . $request['father_name']) . '</td>
        <td>' . htmlspecialchars($request['school']) . '</td>
        <td>' . htmlspecialchars($request['department']) . '</td>
        <td>' . htmlspecialchars($request['year']) . '</td>
        <td>' . htmlspecialchars($request['semester']) . '</td>
        <td>';
            if ($request[$actor] == 'APPROVED') {
                echo '<button class="btn btn-success status-btn" disabled>Approved</button>
                      <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\')">Restore</button>';
            } elseif ($request[$actor] == 'REJECT') {
                echo '<button class="btn btn-danger status-btn" disabled>Rejected</button>
                      <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\')">Restore</button>';
            } else {
                echo '<button class="btn btn-success status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'APPROVED\')">Approve</button>
                      <button class="btn btn-danger status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'REJECT\')">Reject</button>
                      <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\')">Restore</button>';
            }
    echo '</td></tr>';
}
?>
