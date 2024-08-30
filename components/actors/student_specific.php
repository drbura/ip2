<?php
session_start();

if (isset($_GET['student_id']) && isset($_GET['action'])) {
    $_SESSION['student_id'] = $_GET['student_id'];

    if ($_GET['action'] === 'view') {
        header("Location: view_pdf.php");
    } elseif ($_GET['action'] === 'download') {
        header("Location: generate_pdf.php");
    }
    exit();
} else {
    die("Student ID or action not provided.");
}
?>
