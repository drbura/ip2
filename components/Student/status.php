<?php
session_start();
if (!isset($_SESSION['id'])){
    header('Location: welcome.php');
    exit;
}

include 'connect.php';

$studentId = $_SESSION['id'];

// Query to get the latest request for the student
$sql = "SELECT Advisor, LabAssistant, DepartmentHead, SchoolDean, BookStore, Library, Cafeteria, StudentLoan, Dormitory, StudentService, Store, AcademicEnrollment FROM request WHERE StudentId = ? ORDER BY RequestDate DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Filter out statuses that are "PENDING"
    $statuses = array_filter($row, function($status) {
        return $status !== 'Pending';
    });
} else {
    $statuses = []; // No status to show
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            max-width: 1000px;
            margin-top: 30px;
        }
        .navbar-custom {
            background-color: #007bff;
            height: 60px; /* Adjusted height */
        }
        .navbar-custom .navbar-brand img {
            height: 40px; /* Adjusted logo size */
        }
        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }
        .navbar-custom .dropdown-menu {
            right: 0;
            left: auto;
        }
        .navbar-toggler {
            border: none;
        }
        .btn-success {
            background-color: green;
            color: white;
            border: none;
        }
        .btn-danger {
            background-color: red;
            color: white;
            border: none;
        }
        .btn-warning {
            background-color: orange;
            color: white;
            border: none;
        }
        .btn-confirm {
            background-color: blue;
            color: white;
            border: none;
        }
        .btn-confirm:disabled {
            background-color: gray;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="./Images/Dire-Dawa_University-removebg.png" alt="Ethiopian Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">Status Overview</h1>
        <?php if (!empty($statuses)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Actor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statuses as $actor => $status): ?>
                <tr>
                    <td><?php echo htmlspecialchars($actor); ?></td>
                    <td>
                        <button class="btn <?php echo $status === 'REJECT' ? 'btn-danger' : ($status === 'APPROVED' ? 'btn-success' : 'btn-warning'); ?>" disabled>
                            <?php echo htmlspecialchars($status); ?>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <form id="confirmForm" method="post" action="final_status.php">
                <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>">
                <button type="submit" id="confirmButton" class="btn btn-confirm" disabled>Confirm</button>
            </form>
            <br><br><br>
        </div>
        <?php else: ?>
        <p class="text-center">No status updates available.</p>
        <?php endif; ?>
    </div>
    <script>
        $(document).ready(function() {
            function updateConfirmButton() {
                let allApproved = true;
                $('table tbody tr').each(function() {
                    const statusButton = $(this).find('button');
                    if (statusButton.text().trim() !== 'APPROVED') {
                        allApproved = false;
                        return false; // Exit loop early
                    }
                });

                // Enable or disable the confirm button based on status
                $('#confirmButton').prop('disabled', !allApproved);
            }

            // Call updateConfirmButton initially
            updateConfirmButton();
        });
    </script>
</body>
</html>