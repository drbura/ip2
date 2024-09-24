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

// Fetch promoted students from clearedstudentslist and their current year and semester from ddustudentdata
$sql_promoted_students = "
    SELECT c.student_id, c.full_Name, c.department, d.Year, d.semester
    FROM clearedstudentslist c
    INNER JOIN ddustudentdata d ON c.student_id = d.student_id
    WHERE c.promoted = 1";

$result_promoted_students = $conn->query($sql_promoted_students);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promoted Students</title>
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
            margin-top: 20px;
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

<main>
    <div class="container">
        <h2>Promoted Students</h2>
        <table class="centered-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Promoted To Year</th>
                    <th>Promoted To Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_promoted_students->num_rows > 0): ?>
                    <?php while($row = $result_promoted_students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["student_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["full_Name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Year"]); ?></td>
                            <td><?php echo htmlspecialchars($row["semester"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No promoted students found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
