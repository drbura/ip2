<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_student = "SELECT student_id,first_name,father_name,gfather_name,school,department,year,semester FROM ddustudentdata";

$result_student = $conn->query($sql_student);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- <link rel="stylesheet" href="path/to/bootstrap.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 320px;
            padding: 20px;
        }
        .container {
            text-align: center;
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
        }
        .centered-table th {
            background-color: #f4f4f4;
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
    </style>
</head>
<body>

<!-- Your Header and Sidebar Code -->

<main>
    <div class="container">
        <h2>Student Data</h2>
        <table class="centered-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Father Name</th>
                    <th>Grandfather Name</th>
                    <th>School</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_student->num_rows > 0): ?>
                    <?php while($row = $result_student->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["student_id"]; ?></td>
                            <td><?php echo $row["first_name"]; ?></td>
                            <td><?php echo $row["father_name"]; ?></td>
                            <td><?php echo $row["gfather_name"]; ?></td>
                            <td><?php echo $row["school"]; ?></td>
                            <td><?php echo $row["department"]; ?></td>
                            <td><?php echo $row["year"]; ?></td>
                            <td><?php echo $row["semester"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="no-data">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Your Footer Code -->

</body>
</html>
