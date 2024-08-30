<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

function openConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function closeConnection($conn) {
    $conn->close();
}

function fetchClearanceRequestsByDate($startDate, $endDate) {
    $conn = openConnection();
    $sql = "SELECT RequestId, StudentId, AcademicYear, Semester, Reason, RequestDate, 
                   Advisor, LabAssistant, DepartmentHead, SchoolDean, 
                   BookStore, Library, Cafeteria, StudentLoan, Dormitory, 
                   StudentService, Store, AcademicEnrollment 
            FROM request 
            WHERE RequestDate BETWEEN ? AND ?
            ORDER BY RequestDate ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $requests = $result->fetch_all(MYSQLI_ASSOC);
    closeConnection($conn);
    return $requests;
}

// Example usage:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $requests = fetchClearanceRequestsByDate($startDate, $endDate);
    
    echo "<div class='container mt-5'>";
    echo "<div class='card'>";
    echo "<div class='card-header bg-primary text-white'>";
    echo "<h5 class='card-title'>Clearance Requests Report from $startDate to $endDate</h5>";
    echo "</div>";
    echo "<div class='card-body'>";
    
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped' style='border-radius: 0.5rem; width: 100%; max-width: 1200px;'>";
    echo "<thead class='table-dark'>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Student ID</th>
                <th scope='col'>Academic Year</th>
                <th scope='col'>Semester</th>
                <th scope='col'>Reason</th>
                <th scope='col'>Request Date</th>
                <th scope='col'>Advisor</th>
                <th scope='col'>Lab Assistant</th>
                <th scope='col'>Department Head</th>
                <th scope='col'>School Dean</th>
                <th scope='col'>Book Store</th>
                <th scope='col'>Library</th>
                <th scope='col'>Cafeteria</th>
                <th scope='col'>Student Loan</th>
                <th scope='col'>Dormitory</th>
                <th scope='col'>Student Service</th>
                <th scope='col'>Store</th>
                <th scope='col'>Academic Enrollment</th>
            </tr>
          </thead>
          <tbody>";
    
    $rowClass = 'bg-white';
    foreach ($requests as $request) {
        $rowClass = ($rowClass == 'bg-white') ? 'bg-light' : 'bg-white'; // Alternate row colors
        
        echo "<tr class='$rowClass'>
                <th scope='row'>{$request['RequestId']}</th>
                <td>{$request['StudentId']}</td>
                <td>{$request['AcademicYear']}</td>
                <td>{$request['Semester']}</td>
                <td>{$request['Reason']}</td>
                <td>{$request['RequestDate']}</td>";
        
        $statuses = [
            'Advisor', 'LabAssistant', 'DepartmentHead', 'SchoolDean', 
            'BookStore', 'Library', 'Cafeteria', 'StudentLoan', 
            'Dormitory', 'StudentService', 'Store', 'AcademicEnrollment'
        ];
        
        foreach ($statuses as $status) {
            $statusValue = $request[$status];
            $statusLabel = ($statusValue == 'APPROVED') ? 'Ap' :
                           (($statusValue == 'REJECT') ? 'Rj' : 'Pd');
            $statusClass = ($statusValue == 'APPROVED') ? 'bg-success' : 
                           (($statusValue == 'REJECT') ? 'bg-danger' : 'bg-warning');
            
            echo "<td><span class='badge $statusClass'>$statusLabel</span></td>";
        }
        
        echo "</tr>";
    }
    
    echo "</tbody></table>";
    echo "</div>"; // Close table-responsive

    echo "<div class='d-flex justify-content-between mt-3'>
            <a href='report_page.php' class='btn btn-secondary'>Back</a>
            <div>
                <button class='btn btn-primary' onclick='downloadReport()'>Download Report</button>
                <select id='downloadFormat' class='form-select d-inline-block ms-2'>
                    <option value='pdf'>PDF</option>
                    <option value='png'>PNG</option>
                </select>
            </div>
          </div>";

    echo "</div>"; // Close card-body
    echo "</div>"; // Close card
    echo "</div>"; // Close container

    echo "<script>
            function downloadReport() {
                const format = document.getElementById('downloadFormat').value;
                window.location.href = 'download_report.php?format=' + format;
            }
          </script>";
}
?>
