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

$sql_students = "SELECT student_id, first_Name, father_Name, gfather_Name, department, year, phone_number FROM ddustudentdata";
$result_students = $conn->query($sql_students);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 320px;
            margin-top:50px;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for better contrast */
        }

        .container {
            padding: 20px; 
            overflow: auto; /* Ensure content is scrollable */
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
        }

        .centered-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .centered-table th, .centered-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .centered-table th {
            background-color: #012970;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        /* Alternating Row Colors */
        .centered-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .centered-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #1B3E98;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545; /* Keeping delete button distinct */
            border: none;
        }

        .btn-primary:hover {
            background-color: #155a9c;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Editable Row Styles */
        .editable td {
            background-color: #e9ecef;
        }
        .centered-table tbody td {
            font-family: Tahoma, sans-serif;
        }
        /* Red Presentation cursor */
        .centered-table tbody td {
    position: relative; /* Required for the pseudo-element */
}

.centered-table tbody td:hover {
    cursor: pointer;
}

.centered-table tbody td:hover::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 10px; /* Adjust the size as needed */
    height: 10px;
    background-color: red;
    border-radius: 50%;
    z-index: 10;
}


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            body {
                margin-left: 0;
                padding: 10px;
            }

            .centered-table th, .centered-table td {
                padding: 8px;
                font-size: 12px;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn {
                font-size: 12px;
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>
<main>
    <div class="container">
        <h2>Students Data</h2>
        <div class="table-responsive">
            <table class="table centered-table table-bordered" id="student-table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Father's Name</th>
                        <th>Grandfather's Name</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_students->num_rows > 0): ?>
                        <?php while($row = $result_students->fetch_assoc()): ?>
                            <tr data-id="<?php echo htmlspecialchars($row["student_id"]); ?>">
                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                <td data-column="student_id"><?php echo htmlspecialchars($row["student_id"]); ?></td>
                                <td data-column="first_Name"><?php echo htmlspecialchars($row["first_Name"]); ?></td>
                                <td data-column="father_Name"><?php echo htmlspecialchars($row["father_Name"]); ?></td>
                                <td data-column="gfather_Name"><?php echo htmlspecialchars($row["gfather_Name"]); ?></td>
                                <td data-column="department"><?php echo htmlspecialchars($row["department"]); ?></td>
                                <td data-column="year"><?php echo htmlspecialchars($row["year"]); ?></td>
                                <td data-column="phone_number"><?php echo htmlspecialchars($row["phone_number"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="no-data">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
$(document).ready(function() {
    // Enable editing
    $('#student-table').on('click', '.edit-btn', function() {
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
    $('#student-table').on('click', '.save-btn', function() {
        var $row = $(this).closest('tr');
        var rowId = $row.data('id');
        var rowData = {};

        $row.find('input').each(function(index, input) {
            var $input = $(input);
            var columnName = $input.closest('td').data('column');
            rowData[columnName] = $input.val(); // Collect column names and values
        });

        console.log("Data to be sent:", {
            action: 'update',
            student_id: rowId,
            data: rowData
        });

        var $button = $(this); // Reference to the current button

        // Send AJAX request to update the record
        $.post('u&dstudents.php', {
            action: 'update',
            student_id: rowId,
            data: rowData
        }).done(function(response) {
            console.log("Update response:", response);
            $row.removeClass('editable');
            $row.find('input').each(function() {
                var $input = $(this);
                $input.closest('td').text($input.val()); // Update the table cell with the new value
            });
            $button.text('Edit').removeClass('save-btn').addClass('edit-btn');
        }).fail(function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        });
    });

    // Delete functionality
    $('#student-table').on('click', '.delete-btn', function() {
        if (!confirm('Are you sure you want to delete this record?')) {
            return;
        }

        var $row = $(this).closest('tr');
        var rowId = $row.data('id');

        // Send AJAX request to delete the record
        $.post('u&dstudents.php', {
            action: 'delete',
            student_id: rowId
        }).done(function(response) {
            console.log("Delete response:", response);
            $row.remove(); // Remove row from the table
        }).fail(function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        });
    });
});
</script>

</body>
</html>
