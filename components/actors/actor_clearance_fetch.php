<?php
session_start();
$actor = $_GET['actor'] ?? '';
$searchTerm = $_GET['search'] ?? '';
$userEmail = $_SESSION['email'] ?? ''; // Ensure consistency with the session variable from login

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

    // Check for advisor, lab assistant, department head, or school dean
    if (($actor === 'Advisor' || $actor === 'LabAssistant' || $actor === 'DepartmentHead' || $actor === 'SchoolDean') && !empty($userEmail)) {
        // Get the specific details for filtering
        $substaffQuery = "SELECT department, collegeName, year, semester FROM ddu_substaff WHERE email = ?";
        $stmt = $conn->prepare($substaffQuery);
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();
        $substaffResult = $stmt->get_result();

        if ($substaffResult->num_rows > 0) {
            $substaff = $substaffResult->fetch_assoc();
            $conditions = [];

            if ($actor === 'Advisor' || $actor === 'LabAssistant') {
                $conditions[] = "ddustudentdata.department = '" . $conn->real_escape_string($substaff['department']) . "'";
                $conditions[] = "ddustudentdata.year = '" . $conn->real_escape_string($substaff['year']) . "'";
                $conditions[] = "ddustudentdata.semester = '" . $conn->real_escape_string($substaff['semester']) . "'";
            } elseif ($actor === 'DepartmentHead') {
                $conditions[] = "ddustudentdata.department = '" . $conn->real_escape_string($substaff['department']) . "'";
            } elseif ($actor === 'SchoolDean') {
                $conditions[] = "ddustudentdata.school = '" . $conn->real_escape_string($substaff['collegeName']) . "'";
            }

            if (!empty($conditions)) {
                if (strpos($sql, 'WHERE') !== false) {
                    $sql .= " AND " . implode(" AND ", $conditions);
                } else {
                    $sql .= " WHERE " . implode(" AND ", $conditions);
                }
            }
        }

        $stmt->close();
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
