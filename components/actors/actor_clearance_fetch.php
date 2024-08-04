<?php
session_start();
$actor = $_GET['actor'] ?? '';
$searchTerm = $_GET['search'] ?? '';
$userEmail = $_SESSION['UserEmail'] ?? '';

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
    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            ddustudentdata.first_name, ddustudentdata.father_name, ddustudentdata.school, ddustudentdata.department, ddustudentdata.year, ddustudentdata.semester
            FROM request 
            JOIN ddustudentdata ON request.StudentId = ddustudentdata.student_id";

    if ($actor === 'Advisor' && !empty($userEmail)) {
        $advisorQuery = "SELECT department, school, year, semester FROM ddu_substaff WHERE UserEmail = '" . $conn->real_escape_string($userEmail) . "'";
        $advisorResult = $conn->query($advisorQuery);

        if ($advisorResult->num_rows > 0) {
            $advisor = $advisorResult->fetch_assoc();
            $sql .= " WHERE ddustudentdata.department = '" . $conn->real_escape_string($advisor['department']) . "'
                      AND ddustudentdata.school = '" . $conn->real_escape_string($advisor['school']) . "'
                      AND ddustudentdata.year = '" . $conn->real_escape_string($advisor['year']) . "'
                      AND ddustudentdata.semester = '" . $conn->real_escape_string($advisor['semester']) . "'";
        }
    }

    if (!empty($searchTerm)) {
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND request.StudentId LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
        } else {
            $sql .= " WHERE request.StudentId LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
        }
    }

    $result = $conn->query($sql);

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
