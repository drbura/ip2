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
    $allowedActors = ['Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 'Store', 'Library', 'BookStore', 'Cafeteria', 'AcademicEnrollment', 'StudentService', 'Dormitory', 'StudentLoan','Registrar'];

    if (!in_array($actor, $allowedActors)) {
        die("Invalid actor specified.");
    }

    $sql = "SELECT request.StudentId, request.RequestId, request.$actor, 
            request.Advisor, request.LabAssistant, request.DepartmentHead, 
            ddustudentdata.first_name, ddustudentdata.father_name, ddustudentdata.school, ddustudentdata.department, ddustudentdata.year, ddustudentdata.semester
            FROM request 
            JOIN ddustudentdata ON request.StudentId = ddustudentdata.student_id";

    $conditions = [];
    $params = [];
    $types = '';

    // Check for actor-specific conditions
    if (!empty($userEmail)) {
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

            if ($actor === 'SchoolDean') {
                $conditions[] = "ddustudentdata.school = ?";
                $params[] = $substaff['schoolName'];
                $types .= 's';
            } elseif ($actor === 'DepartmentHead') {
                $conditions[] = "ddustudentdata.department = ?";
                $conditions[] = "ddustudentdata.school = ?";
                $params[] = $substaff['department'];
                $params[] = $substaff['collegeName'];
                $types .= 'ss';
            } elseif ($actor === 'Advisor' || $actor === 'LabAssistant') {
                $conditions[] = "ddustudentdata.department = ?";
                $conditions[] = "ddustudentdata.year = ?";
                $conditions[] = "ddustudentdata.semester = ?";
                $params[] = $substaff['department'];
                $params[] = $substaff['year'];
                $params[] = $substaff['semester'];
                $types .= 'sss';
            }
        }
    }

    // Add search term condition
    if (!empty($searchTerm)) {
        $conditions[] = "request.StudentId LIKE ?";
        $params[] = '%' . $searchTerm . '%';
        $types .= 's';
    }

    // Build the SQL query with the conditions
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

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
            <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\',  \'APPROVED\')">Restore</button>';
} elseif ($request[$actor] == 'REJECT') {
    echo '<button class="btn btn-danger status-btn" disabled>Rejected</button>
            <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\',  \'REJECTED\')">Restore</button>';
} else {
    echo '<button class="btn btn-success status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'APPROVED\', \'PENDING\' )">Approve</button>
            <button class="btn btn-danger status-btn" onclick="showRejectPopup(' . $request['RequestId'] . ')">Reject</button>
            <button class="btn btn-warning status-btn" onclick="updateStatus(' . $request['RequestId'] . ', \'PENDING\',  \'PENDING\')">Restore</button>';
}

    echo '</td></tr>';
}
