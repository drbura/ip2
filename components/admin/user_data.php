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

$sql_admin = "SELECT id,fName,mName,lName,role,phone FROM ddu_admin";
$sql_staff = "SELECT staff_id,fName,mName,lName, staff,schoolName,position,phone FROM ddu_staff";
$sql_substaff = "SELECT subStaff_id,fName,mName,lName, staff,collegeName,department,semester,year,role,phone FROM ddu_subStaff";

$result_admin = $conn->query($sql_admin);
$result_staff = $conn->query($sql_staff);
$result_substaff = $conn->query($sql_substaff);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        body{
            
            margin-left: 320px;
        }
        .centered-table {
            font-size:14px;
            /* margin-left: auto;
            margin-right: auto; */
        }
        h1, h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Your Header and Sidebar Code -->

<main>
    <h1>User Data</h1>
    <div class="container">
        <h2>Admin Data</h2>
        <table class="table centered-table" border="2">
            <thead>
                <tr>
                    <th>id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>role</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_admin->num_rows > 0): ?>
                    <?php while($row = $result_admin->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["role"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Staff Data</h2>
        <table class="table centered-table" border="2">
            <thead>
                <tr>
                    <th>staff_id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>staff</th>
                    <th>schoolName</th>
                    <th>position</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_staff->num_rows > 0): ?>
                    <?php while($row = $result_staff->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["staff_id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["staff"]; ?></td>
                            <td><?php echo $row["schoolName"]; ?></td>
                            <td><?php echo $row["position"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Substaff Data</h2>
        <table class="table centered-table" border="2">
            <thead>
                <tr>
                    <th>substaff_id</th>
                    <th>fName</th>
                    <th>mName</th>
                    <th>lName</th>
                    <th>staff</th>
                    <th>collegeName</th>
                    <th>department</th>
                    <th>year</th>
                    <th>semester</th>
                    <th>role</th>
                    <th>phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_substaff->num_rows > 0): ?>
                    <?php while($row = $result_substaff->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["subStaff_id"]; ?></td>
                            <td><?php echo $row["fName"]; ?></td>
                            <td><?php echo $row["mName"]; ?></td>
                            <td><?php echo $row["lName"]; ?></td>
                            <td><?php echo $row["staff"]; ?></td>
                            <td><?php echo $row["collegeName"]; ?></td>
                            <td><?php echo $row["department"]; ?></td>
                            <td><?php echo $row["year"]; ?></td>
                            <td><?php echo $row["semester"]; ?></td>
                            <td><?php echo $row["role"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="11">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Your Footer Code -->

</body>
</html>
