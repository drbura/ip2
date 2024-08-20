<?php
// session_start();

// // Check if email session is set
// if (!isset($_SESSION['email'])) {
//     echo "Session email is not set.";
//     exit;
// }

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user's email
// $email = $_SESSION['email'];

// Fetch schoolName based on the logged-in SchoolDean's email
$sql_school = "SELECT schoolName FROM ddu_staff WHERE email = ? AND staff = 'SchoolDean'";
$stmt_school = $conn->prepare($sql_school);
$stmt_school->bind_param("s", $email);
$stmt_school->execute();
$result_school = $stmt_school->get_result();

if ($result_school->num_rows > 0) {
    $school_row = $result_school->fetch_assoc();
    $user_school_name = $school_row['schoolName'];
} else {
    echo "No school found for the logged-in user.";
    exit;
}

// Fetch Department Heads, Lab Assistants, and Advisors for the logged-in SchoolDean's school
$sql_substaff = "SELECT subStaff_id, fName, mName, lName, staff, collegeName, department, semester, year, phone 
                 FROM ddu_subStaff 
                 WHERE collegeName = ?";

$stmt_substaff = $conn->prepare($sql_substaff);
$stmt_substaff->bind_param("s", $user_school_name);
$stmt_substaff->execute();
$result_substaff = $stmt_substaff->get_result();

$subStaff_heads = [];
$subStaff_labAssistants = [];
$subStaff_advisors = [];

// Process substaff data
while($row = $result_substaff->fetch_assoc()) {
    if ($row["staff"] === "DepartmentHead") {
        $subStaff_heads[] = $row;
    } elseif ($row["staff"] === "LabAssistant") {
        $subStaff_labAssistants[] = $row;
    } elseif ($row["staff"] === "Advisor") {
        $subStaff_advisors[] = $row;
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchoolDean SubStaff Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 320px;
            padding: 20px;
        }
        .container {
            text-align: center;
            background-color: #f4f4f4;
        }
        .centered-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .centered-table th, .centered-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            background-color: #f4f4f4;
        }
        .centered-table th {
            background-color: #ddd;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .no-data {
            text-align: center;
            color: red;
            font-weight: bold;
        }
        .btn-margin {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<main>
    <div class="container">
        <h2>Department Heads</h2>
        <table class="table centered-table table-bordered" id="heads-table">
            <thead>
                <tr>
                    <th>subStaff_id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>staff</th>
                    <th>collegeName</th>
                    <th>department</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($subStaff_heads) > 0): ?>
                    <?php foreach($subStaff_heads as $row): ?>
                        <tr>
                            <td><?php echo $row["subStaff_id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["staff"]; ?></td>
                            <td><?php echo $row["collegeName"]; ?></td>
                            <td><?php echo $row["department"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <h2>Lab Assistants</h2>
        <table class="table centered-table table-bordered" id="lab-assistants-table">
            <thead>
                <tr>
                    <th>subStaff_id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>staff</th>
                    <th>collegeName</th>
                    <th>department</th>
                    <th>semester</th>
                    <th>year</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($subStaff_labAssistants) > 0): ?>
                    <?php foreach($subStaff_labAssistants as $row): ?>
                        <tr>
                            <td><?php echo $row["subStaff_id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["staff"]; ?></td>
                            <td><?php echo $row["collegeName"]; ?></td>
                            <td><?php echo $row["department"]; ?></td>
                            <td><?php echo $row["semester"]; ?></td>
                            <td><?php echo $row["year"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Advisors</h2>
        <table class="table centered-table table-bordered" id="advisors-table">
            <thead>
                <tr>
                    <th>subStaff_id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>staff</th>
                    <th>collegeName</th>
                    <th>department</th>
                    <th>semester</th>
                    <th>year</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($subStaff_advisors) > 0): ?>
                    <?php foreach($subStaff_advisors as $row): ?>
                        <tr>
                            <td><?php echo $row["subStaff_id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["staff"]; ?></td>
                            <td><?php echo $row["collegeName"]; ?></td>
                            <td><?php echo $row["department"]; ?></td>
                            <td><?php echo $row["semester"]; ?></td>
                            <td><?php echo $row["year"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
