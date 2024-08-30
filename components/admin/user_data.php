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
            margin-top: 0px;
        }
        .btn {
            border: none;
            background-color: black;
            color: red;
            font-size: 7px;
        }
        .editable td {
            background-color: #ffffcc;
        }
        .editable input {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<br>
<br>
<main>
    <div class="container">
        <form id="bulk-action-form" action="update&delete.php" method="post">
            <h2>Admin</h2>
            <table class="table centered-table table-bordered" id="admin-table">
                <thead>
                    <tr>
                        <th></th>
                        
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
                            <tr data-id="<?php echo $row["id"]; ?>">
                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                              
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
                        <th></th>
                        <th data-column="fName">fName</th>
                        <th data-column="mName">mName</th>
                        <th data-column="lName">lName</th>
                        <th data-column="staff">staff</th>
                        <th data-column="schoolName">schoolName</th>
                        <th data-column="position">position</th>
                        <th data-column="phone">phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($staff_deans) > 0): ?>
                        <?php foreach($staff_deans as $row): ?>
                            <tr data-id="<?php echo $row["staff_id"]; ?>">
                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                        <td data-column="fName"><?php echo $row["fName"]; ?></td>
                        <td data-column="mName"><?php echo $row["mName"]; ?></td>
                        <td data-column="lName"><?php echo $row["lName"]; ?></td>
                        <td data-column="staff"><?php echo $row["staff"]; ?></td>
                        <td data-column="schoolName"><?php echo $row["schoolName"]; ?></td>
                        <td data-column="position"><?php echo $row["position"]; ?></td>
                        <td data-column="phone"><?php echo $row["phone"]; ?></td>
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
                        <th></th>
                        <th data-column="fName">fName</th>
                        <th data-column="mName">mName</th>
                        <th data-column="lName">lName</th>
                        <th data-column="staff">staff</th>
                        <th data-column="position">position</th>
                        <th data-column="phone">phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($other_staff) > 0): ?>
                        <?php foreach($other_staff as $row): ?>
                            <tr data-id="<?php echo $row["staff_id"]; ?>">
                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                <td data-column="fName"><?php echo $row["fName"]; ?></td>
                                <td data-column="mName"><?php echo $row["mName"]; ?></td>
                                <td data-column="lName"><?php echo $row["lName"]; ?></td>
                                <td data-column="staff"><?php echo $row["staff"]; ?></td>
                                <td data-column="position"><?php echo $row["position"]; ?></td>
                                <td data-column="phone"><?php echo $row["phone"]; ?></td>
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
                            <tr data-id="<?php echo $row["subStaff_id"]; ?>">
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
                        <tr><td colspan="7">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Lab Assistants</h2>
            <table class="table centered-table table-bordered" id="lab-assistants-table">
                <thead>
                    <tr>
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
                    <?php if (count($subStaff_labAssistants) > 0): ?>
                        <?php foreach($subStaff_labAssistants as $row): ?>
                            <tr data-id="<?php echo $row["subStaff_id"]; ?>">
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
                        <tr><td colspan="7">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Advisors</h2>
            <table class="table centered-table table-bordered" id="advisors-table">
                <thead>
                    <tr>
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
                            <tr data-id="<?php echo $row["subStaff_id"]; ?>">
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
                        <tr><td colspan="9">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </div>
</main>

<script>
    $(document).ready(function() {
        // Enable editing
    $('#bulk-action-form').on('click', '.edit-btn', function() {
        var $row = $(this).closest('tr');
        $row.addClass('editable');
        $row.find('td').each(function(index, td) {
            if (index > 1) { // Skip the edit and delete buttons
                var $td = $(td);
                var text = $td.text().trim();
                $td.html('<input type="text" value="' + text + '">');
            }
        });
        $(this).text('Save').removeClass('edit-btn').addClass('save-btn');
    });

    // Handle save functionality
    $('#bulk-action-form').on('click', '.save-btn', function() {
        var $row = $(this).closest('tr');
        var tableId = $row.closest('table').attr('id');
        var rowId = $row.data('id');

        $row.find('input').each(function(index, input) {
            var $input = $(input);
            var column = $input.closest('td').attr('data-column');
            var value = $input.val();

            // Send AJAX request to update the record
            $.post('update.php', { id: rowId, table: tableId, column: column, value: value }, function(response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    $input.closest('td').text(value); // Update the table cell with the new value
                } else {
                    alert(response.message);
                }
            });
        });

        $row.removeClass('editable');
        $(this).text('Edit').removeClass('save-btn').addClass('edit-btn');
    });
    // Delete functionality
    $('#bulk-action-form').on('click', '.delete-btn', function() {
        var $row = $(this).closest('tr');
        var confirmed = confirm("Are you sure you want to delete this row?");
        if (confirmed) {
            var rowId = $row.data('id');
            var tableId = $row.closest('table').attr('id');

            // Send AJAX request to delete the record from the database
            $.post('update&delete.php', { action: 'delete', id: rowId, table: tableId }, function(response) {
                console.log(response);
                $row.remove();
            });
        }
    });
});
</script>
</body>
</html>
