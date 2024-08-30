<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])) {
    $_SESSION['agreed'] = true;
    header('Location: welcome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guideline and Terms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        #popup {
            display: block;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px #000;
            width: 50%;
            max-height: 80%;
            overflow-y: auto;
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        #okButton:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div id="overlay"></div>
    <div id="popup" class="container">
        <h2 class="text-center">Guideline and Terms</h2>
        <p>Please read the following guidelines and terms carefully:</p>
        <div class="content">
            <ul>
                <li>Guideline 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum.</li>
                <li>Guideline 2: Cras vehicula dapibus cursus. Morbi luctus vel neque at faucibus.</li>
                <li>Guideline 3: Suspendisse potenti. Nam facilisis, nisl a bibendum consectetur, elit est facilisis quam, vel sollicitudin massa magna a lorem.</li>
                <li>Guideline 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum.</li>
                <li>Guideline 2: Cras vehicula dapibus cursus. Morbi luctus vel neque at faucibus.</li>
                <li>Guideline 3: Suspendisse potenti. Nam facilisis, nisl a bibendum consectetur, elit est facilisis quam, vel sollicitudin massa magna a lorem.</li>
                <li>Guideline 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum.</li>
                <li>Guideline 2: Cras vehicula dapibus cursus. Morbi luctus vel neque at faucibus.</li>
                
                <!-- Add more guidelines as needed -->
            </ul>
        </div>
        <form method="post" action="">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="agree" name="agree">
                <label class="form-check-label" for="agree">I agree to the terms and policies</label>
            </div>
            <br>
            <button type="submit" id="okButton" class="btn btn-primary" disabled>OK</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#agree').click(function() {
                if ($(this).is(':checked')) {
                    $('#okButton').prop('disabled', false);
                } else {
                    $('#okButton').prop('disabled', true);
                }
            });
        });
    </script>
</body>
</html>
