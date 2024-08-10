<!doctype html>
<html lang="en">
<head>
    <title>Student Clearance List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12" align="center">
                <br>
                <h5 align="center"> Cleared Students List</h5>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                
                        require 'connect.php'; 
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch student ID and name from the ddustudentdata table where process is completed in clearedstudentslist
                        $display_query = "
                            SELECT d.student_id, CONCAT(d.first_name, ' ', d.father_name, ' ', d.gfather_name) AS student_name
                            FROM ddustudentdata d
                            INNER JOIN clearedstudentslist c ON d.student_id = c.student_id
                            WHERE c.is_completed = 1";             
                        $results = mysqli_query($conn, $display_query);   
                        $count = mysqli_num_rows($results);            
                        if($count > 0) 
                        {
                            while($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC))
                            {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data_row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($data_row['student_name']); ?></td>
                                    <td>
                                        <a href="view_pdf.php?id=<?php echo $data_row['student_id']; ?>" class="btn btn-info btn-sm">View PDF</a>
                                        <a href="generate_pdf.php?id=<?php echo $data_row['student_id']; ?>" class="btn btn-success btn-sm">Download PDF</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>No Cleared Students yet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>