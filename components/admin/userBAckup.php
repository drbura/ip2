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

$sql_admin = "SELECT id, fName, mName, lName, role, phone FROM ddu_admin";
$sql_staff = "SELECT staff_id, fName, mName, lName, staff, schoolName, position, phone FROM ddu_staff";
$sql_substaff = "SELECT subStaff_id, fName, mName, lName, staff, collegeName, department, semester, year, phone FROM ddu_subStaff";

$result_admin = $conn->query($sql_admin);
$result_staff = $conn->query($sql_staff);
$result_substaff = $conn->query($sql_substaff);

$staff_deans = [];
$other_staff = [];
$subStaff_heads = [];
$subStaff_labAssistants = [];
$subStaff_advisors = [];

// Process staff data
while($row = $result_staff->fetch_assoc()) {
    if ($row["staff"] === "SchoolDean") {
        $staff_deans[] = $row;
    } else {
        $other_staff[] = $row;
    }
}

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
    <title>User Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
        .btn-margin {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<main>
    <h1>User Data</h1>
    <div class="container">
        <form id="bulk-action-form" action="update&delete.php" method="post">
            <h2>Admin</h2>
            <table class="table centered-table table-bordered">
                <thead>
                    <tr>
                        <th></th>
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
                                <td><input type="checkbox" name="selected_ids_admin[]" value="<?php echo $row["id"]; ?>"></td>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["fName"]; ?></td>
                                <td><?php echo $row["mName"]; ?></td>
                                <td><?php echo $row["lName"]; ?></td>
                                <td><?php echo $row["role"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>School Deans</h2>
            <table class="table centered-table table-bordered" id="deans-table">
                <thead>
                    <tr>
                        <th></th>
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
                    <?php if (count($staff_deans) > 0): ?>
                        <?php foreach($staff_deans as $row): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids_staff_deans[]" value="<?php echo $row["staff_id"]; ?>"></td>
                                <td><?php echo $row["staff_id"]; ?></td>
                                <td><?php echo $row["fName"]; ?></td>
                                <td><?php echo $row["mName"]; ?></td>
                                <td><?php echo $row["lName"]; ?></td>
                                <td><?php echo $row["staff"]; ?></td>
                                <td><?php echo $row["schoolName"]; ?></td>
                                <td><?php echo $row["position"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Other Staff</h2>
            <table class="table centered-table table-bordered" id="staff-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>staff_id</th>
                        <th>fName</th>
                        <th>mName</th>
                        <th>lName</th>
                        <th>staff</th>
                        <th>position</th>
                        <th>phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($other_staff) > 0): ?>
                        <?php foreach($other_staff as $row): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids_other_staff[]" value="<?php echo $row["staff_id"]; ?>"></td>
                                <td><?php echo $row["staff_id"]; ?></td>
                                <td><?php echo $row["fName"]; ?></td>
                                <td><?php echo $row["mName"]; ?></td>
                                <td><?php echo $row["lName"]; ?></td>
                                <td><?php echo $row["staff"]; ?></td>
                                <td><?php echo $row["position"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Department Heads</h2>
            <table class="table centered-table table-bordered" id="heads-table">
                <thead>
                    <tr>
                        <th></th>
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
                                <td><input type="checkbox" name="selected_ids_heads[]" value="<?php echo $row["subStaff_id"]; ?>"></td>
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
                        <tr><td colspan="9">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Lab Assistants</h2>
            <table class="table centered-table table-bordered" id="labAssistants-table">
                <thead>
                    <tr>
                        <th></th>
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
                                <td><input type="checkbox" name="selected_ids_labAssistants[]" value="<?php echo $row["subStaff_id"]; ?>"></td>
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
                        <tr><td colspan="11">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Advisors</h2>
            <table class="table centered-table table-bordered" id="advisors-table">
                <thead>
                    <tr>
                        <th></th>
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
                                <td><input type="checkbox" name="selected_ids_advisors[]" value="<?php echo $row["subStaff_id"]; ?>"></td>
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
                        <tr><td colspan="11">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- <div class="text-center btn-margin">
                <input type="submit" class="btn btn-danger" value="Delete Selected">
                <input type="submit" class="btn btn-primary" value="Update Selected">
            </div> -->
        </form>
    </div>
</main>

</body>
</html>

