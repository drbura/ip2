<?php
session_start();

// Check if session email is set
if (isset($_SESSION['email'])) {
    echo json_encode(['email' => $_SESSION['email']]);
} else {
    echo json_encode(['error' => 'No session email found']);
}
?>
