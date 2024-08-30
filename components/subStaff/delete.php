<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if required POST variables are set
if (!isset($_POST['action'], $_POST['id'], $_POST['table'])) {
    echo "Required parameters missing.";
    $conn->close();
    exit();
}

$action = $_POST['action'];
$id = $_POST['id'];
$table = $_POST['table'];

switch ($action) {
    case "delete":
        switch ($table) {
            case "LabAssistants-table":
            case "Advisors-table":
                $sql = "DELETE FROM ddu_subStaff WHERE subStaff_id = ?";
                break;
            default:
                echo "Invalid table";
                $conn->close();
                exit();
        }

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            $conn->close();
            exit();
        }

        $stmt->bind_param("i", $id); // Assuming id is an integer

        if (!$stmt->execute()) {
            echo "Error deleting record: " . $stmt->error;
        } else {
            echo "Record deleted successfully.";
        }
        $stmt->close();
        break;

    default:
        echo "Invalid action";
}

$conn->close();
exit();

?>
