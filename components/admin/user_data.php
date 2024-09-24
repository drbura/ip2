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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 320px;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for better contrast */
        }

        .container {
            padding: 20px; 
            overflow: auto; /* Ensure content is scrollable */
            background-color: #ffffff; /* White background for containers */
            border-radius: 10px; /* Rounded corners for container */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        h2 {
            text-align: center;
            color: #012970; 
            margin-bottom: 20px; 
        }

        /* Fixed Header Table */
        .table-responsive {
            max-height: 600px; /* Adjust as needed */
            overflow-y: auto;
            margin-bottom: 40px;
        }

        .centered-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            border-radius: 10px; /* Rounded corners for table */
            overflow: hidden; /* Ensures border-radius is applied properly */
        }

        .centered-table th, .centered-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-family: Tahoma, sans-serif; /* Set font to Tahoma */
            position: relative; /* Required for cursor pointer pseudo-element */
        }

        .centered-table th {
            background-color: #012970;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
            border-bottom: 2px solid #1B3E98; /* Slightly different shade for distinction */
        }

        /* Alternating Row Colors */
        .centered-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .centered-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Rounded Corners for Table Cells */
        .centered-table th:first-child,
        .centered-table th:last-child {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .centered-table td:first-child,
        .centered-table td:last-child {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #1B3E98;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #155a9c;
        }

        .btn-danger {
            background-color: #dc3545; /* Distinct red color */
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Editable Row Styles */
        .editable td {
            background-color: #e9ecef;
        }

        /* Custom Cursor: Red Round Pointer */
        .centered-table tbody td {
            cursor: default; /* Default cursor */
        }

        .centered-table tbody td:hover {
            cursor: pointer; /* Pointer cursor on hover */
        }

        .centered-table tbody td:hover::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px; /* Adjust size as needed */
            height: 12px;
            background-color: red;
            border-radius: 50%;
            pointer-events: none; /* Ensure it doesn't block clicks */
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            body {
                margin-left: 0;
                padding: 10px;
            }

            .container {
                padding: 10px; 
            }

            .centered-table th, .centered-table td {
                padding: 8px;
                font-size: 12px;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn-primary, .btn-danger {
                font-size: 10px;
                padding: 4px 8px;
            }
        }

        @media (max-width: 768px) {
            .centered-table th, .centered-table td {
                padding: 6px;
                font-size: 10px;
            }

            h2 {
                font-size: 1.2rem;
            }

            .btn-primary, .btn-danger {
                font-size: 9px;
                padding: 3px 6px;
            }
        }
    </style>
</head>
<body>
<br>
<br>
<main>
    <div class="container">
        <form id="bulk-action-form" action="update&delete.php" method="post">
            <!-- Admin Section -->
            <h2>Admin</h2>
            <div class="table-responsive">
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
                                <tr data-id="<?php echo htmlspecialchars($row["id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["role"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>

            <!-- School Deans Section -->
            <h2>School Deans</h2>
            <div class="table-responsive">
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
                                <tr data-id="<?php echo htmlspecialchars($row["staff_id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["staff"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["schoolName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["position"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>

            <!-- Other Staff Section -->
            <h2>Other Staff</h2>
            <div class="table-responsive">
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
                                <tr data-id="<?php echo htmlspecialchars($row["staff_id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["staff"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["position"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>

            <!-- Department Heads Section -->
            <h2>Department Heads</h2>
            <div class="table-responsive">
                <table class="table centered-table table-bordered" id="heads-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
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
                                <tr data-id="<?php echo htmlspecialchars($row["subStaff_id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["staff"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["collegeName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["department"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>

            <!-- Lab Assistants Section -->
            <h2>Lab Assistants</h2>
            <div class="table-responsive">
                <table class="table centered-table table-bordered" id="lab-assistants-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
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
                                <tr data-id="<?php echo htmlspecialchars($row["subStaff_id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["staff"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["collegeName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["department"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr>

            <!-- Advisors Section -->
            <h2>Advisors</h2>
            <div class="table-responsive">
                <table class="table centered-table table-bordered" id="advisors-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
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
                                <tr data-id="<?php echo htmlspecialchars($row["subStaff_id"]); ?>">
                                    <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                    <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                    <td><?php echo htmlspecialchars($row["fName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["mName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["lName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["staff"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["collegeName"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["department"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["semester"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["year"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="11" class="no-data">No data available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
                    $td.html('<input type="text" value="' + $('<div>').text(text).html() + '">');
                }
            });
            $(this).text('Save').removeClass('edit-btn').addClass('save-btn');
        });

        // Handle save functionality
        $('#bulk-action-form').on('click', '.save-btn', function() {
            var $row = $(this).closest('tr');
            var tableId = $row.closest('table').attr('id');
            var rowId = $row.data('id');
            var rowData = {};

            $row.find('input').each(function(index, input) {
                var $input = $(input);
                var column = $input.closest('td').attr('data-column');
                var value = $input.val();
                if(column) { // Only add if data-column attribute exists
                    rowData[column] = value;
                }
            });

            console.log("Data to be sent:", {
                action: 'update',
                id: rowId,
                table: tableId,
                data: rowData
            });

            var $button = $(this); // Reference to the current button

            // Send AJAX request to update the record
            $.post('update&delete.php', {
                action: 'update',
                id: rowId,
                table: tableId,
                data: rowData
            }).done(function(response) {
                console.log("Update response:", response);
                // Assuming response is JSON with a status property
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.status === 'success') {
                        $row.removeClass('editable');
                        $row.find('input').each(function() {
                            var $input = $(this);
                            var newValue = $input.val();
                            $input.closest('td').text(newValue); // Update the table cell with the new value
                        });
                        $button.text('Edit').removeClass('save-btn').addClass('edit-btn');
                    } else {
                        alert(jsonResponse.message || 'Update failed.');
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', response);
                    alert('An error occurred while processing the update.');
                }
            }).fail(function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Failed to update the record. Please try again.');
            });
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
                    // Optionally, handle response
                    $row.remove();
                }).fail(function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Failed to delete the record. Please try again.');
                });
            }
        });
    });
</script>
</body>
</html>
