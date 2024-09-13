<?php
// Start the session at the very beginning
session_start();

// Now safely assign the session email to the variable

$email = $_SESSION['email'];

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

// Fetch schoolName based on the logged-in SchoolDean's email
$sql_school = "SELECT department FROM ddu_subStaff WHERE email = ? ";
$stmt_school = $conn->prepare($sql_school);
$stmt_school->bind_param("s", $email);
$stmt_school->execute();
$result_school = $stmt_school->get_result();

if ($result_school->num_rows > 0) {
    $school_row = $result_school->fetch_assoc();
    $user_school_name = $school_row['department'];
} else {
    echo "No department found for the logged-in user.";
    exit();
}

// Fetch Department Heads, Lab Assistants, and Advisors for the logged-in SchoolDean's school
$sql_substaff = "SELECT subStaff_id, fName, mName, lName, staff, collegeName, department, semester, year, phone 
                 FROM ddu_subStaff 
                 WHERE department = ?";
$stmt_substaff = $conn->prepare($sql_substaff);
$stmt_substaff->bind_param("s", $user_school_name);
$stmt_substaff->execute();
$result_substaff = $stmt_substaff->get_result();


$subStaff_labAssistants = [];
$subStaff_advisors = [];

// Process substaff data
while($row = $result_substaff->fetch_assoc()) {
    if ($row["staff"] === "LabAssistant") {
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
    width: 100%;
    max-width: 1200px; /* Adjust as necessary */
    margin: 0 auto;
    margin-top:10px; /* Center the container */
    padding: 20px;
    background-color: #f4f4f4;
    overflow-x: auto; /* Allows horizontal scrolling if needed */
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
            <hr>

            <hr>

            <h2>Lab Assistants</h2>
            <table class="table centered-table table-bordered" id="LabAssistants-table">
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
                        <?php foreach ($subStaff_labAssistants as $row): ?>
                            <tr data-id="<?php echo $row['subStaff_id']; ?>" data-table="LabAssistants-table">

                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                <td data-column="fName"><?php echo $row["fName"]; ?></td>
                                <td data-column="mName"><?php echo $row["mName"]; ?></td>
                                <td data-column="lName"><?php echo $row["lName"]; ?></td>
                                <td data-column="staff"><?php echo $row["staff"]; ?></td>
                                <td data-column="collegeName"><?php echo $row["collegeName"]; ?></td>
                                <td data-column="department"><?php echo $row["department"]; ?></td>
                                <td data-column="phone"><?php echo $row["phone"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr>

            <h2>Advisors</h2>
            <table class="table centered-table table-bordered" id="Advisors-table">
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
                        <?php foreach ($subStaff_advisors as $row): ?>
                            <tr data-id="<?php echo $row['subStaff_id']; ?>" data-table="Advisors-table">

                                <td><button type="button" class="btn btn-primary edit-btn">Edit</button></td>
                                <td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>
                                <td data-column="fName"><?php echo $row["fName"]; ?></td>
                                <td data-column="mName"><?php echo $row["mName"]; ?></td>
                                <td data-column="lName"><?php echo $row["lName"]; ?></td>
                                <td data-column="staff"><?php echo $row["staff"]; ?></td>
                                <td data-column="collegeName"><?php echo $row["collegeName"]; ?></td>
                                <td data-column="department"><?php echo $row["department"]; ?></td>
                                <td data-column="semester"><?php echo $row["semester"]; ?></td>
                                <td data-column="year"><?php echo $row["year"]; ?></td>
                                <td data-column="phone"><?php echo $row["phone"]; ?></td>
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
$(".edit-btn").on("click", function() {
    var $row = $(this).closest("tr");
    $row.toggleClass("editable");
    var isEditable = $row.hasClass("editable");

    var id = $row.data("id");
    var table = "heads-table"; // You can hardcode it if it's always the same

    $row.find("td[data-column]").each(function() {
        var $cell = $(this);
        var columnName = $cell.data("column");
        var cellValue = $cell.text();

        if (isEditable) {
            $cell.html('<input type="text" name="' + columnName + '" value="' + cellValue + '">');
        } else {
            var newValue = $cell.find("input").val();
            $cell.html(newValue);

            $.ajax({
                url: "/clear/components/subStaffs/update.php",
                method: "POST",
                data: {
                    id: id,
                    table: table,  // Ensure 'table' is correctly passed
                    column: columnName,
                    value: newValue
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                }
            });
        }
    });
});



$(".delete-btn").on("click", function() {
    var $row = $(this).closest("tr");
    var id = $row.data("id");
    var table = $row.closest("table").attr("id"); // Get the table ID to know which table the row belongs to

    // Show confirmation dialog
    var confirmation = confirm("Are you sure you want to delete this row?");

    if (confirmation) {
        // Call AJAX to delete the data if the user confirms
        $.ajax({
            url: "/clear/components/subStaff/delete.php",
            method: "POST",
            data: {
                id: id,
                action: "delete",
                table: table // Send the table name
            },
            success: function(response) {
                console.log(response);
                if (response.includes("Record deleted successfully.")) {
                    $row.remove(); // Only remove the row if the delete was successful
                } else {
                    alert("Error: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error: ", status, error);
            }
        });
    } else {
        // If the user cancels the deletion, do nothing (optional: reset the row if needed)
        console.log("Deletion canceled.");
    }
});

</script>
</body>
</html>
