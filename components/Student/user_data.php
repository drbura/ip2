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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 320px;
            padding: 20px;
        }
        .container {
            display: block;
            padding: 20px; 
            overflow: visible; /* Make sure overflow doesn't hide content */
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
            color: #333; 
             z-index: 9999;
            position: relative; 
            display: block;
            margin-top: 20px; 
            padding: 10px        
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
<main>
    <div class="container">
    <h2>Students Data</h2>
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
                        <tr data-id="<?php echo $row["student_id"]; ?>">
                            <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                            <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                            <td data-column="student_id"><?php echo $row["student_id"]; ?></td>
                            <td data-column="first_Name"><?php echo $row["first_Name"]; ?></td>
                            <td data-column="father_Name"><?php echo $row["father_Name"]; ?></td>
                            <td data-column="gfather_Name"><?php echo $row["gfather_Name"]; ?></td>
                            <td data-column="department"><?php echo $row["department"]; ?></td>
                            <td data-column="year"><?php echo $row["year"]; ?></td>
                            <td data-column="phone_number"><?php echo $row["phone_number"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9">No data available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
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
                $td.html('<input type="text" value="' + text + '">');
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
            $(this).text('Edit').removeClass('save-btn').addClass('edit-btn');
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
