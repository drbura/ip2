<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actor = $_POST['actor'];
    $studentId = $_POST['studentId'];

    // Query to fetch the reason for the given actor and studentId
    $sql = "SELECT reason FROM reason WHERE request_id = (SELECT RequestId FROM request WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1) ";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo htmlspecialchars($row['reason']);
    } else {
        echo "No reason found.";
    }

    $stmt->close();
    $conn->close();
}
?>
