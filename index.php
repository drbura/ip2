<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <link href="assetes/css/bootstrap.min.css" rel="stylesheet">
    <link href="assetes/css/font-awesome.min.css" rel="stylesheet">
    <link href="assetes/css/style.css" rel="stylesheet">

    <style>
    
      .error-message {
        color: red;
        text-align: center;
        margin-bottom: 10px;
      }
      
    </style>
  </head>
  <body>
    <section class="form-01-main">
      <div class="form-cover">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="form-sub-main">
                <div class="_main_head_as text-center">
                  <a href="#">
                    <img src="./components/Images/download.jpg" alt="Logo">
                  </a>
                </div>
                 <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <div id="errorDiv" class="error-message" style="display: none;"></div>
                <form id="StudentForm" method="post" action="login_check.php">
                  <div class="form-group">
                    <input id="email" name="email" class="form-control _ge_de_ol" type="text" placeholder="Enter Email" required>
                  </div>
                  <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" placeholder="********" required>
                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                  </div>
                  <div class="form-group">
                    <div class="check_box_main">
                      <a href="#" class="pas-text" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a>
                    </div>
                  </div>
                  <div class="btn_uy">
                    <input type="submit" class="btn " value="Login" name="signIn">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="forgotPasswordForm" method="post" action="forgot_password.php">
              <div class="form-group">
                <label for="forgotEmail">Enter your email:</label>
                <input type="email" class="form-control" id="forgotEmail" name="forgotEmail" placeholder="Email" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div id="forgotPasswordError" class="error-message" style="display: none;"></div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Toggle password visibility
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordField = document.querySelector(this.getAttribute('toggle'));
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // Display error message if passed via URL
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        if (error) {
            document.getElementById('errorDiv').innerText = error;
            document.getElementById('errorDiv').style.display = 'block';
        }

        // Display forgot password error if passed via URL
        const forgotPasswordError = urlParams.get('forgotError');
        if (forgotPasswordError) {
            document.getElementById('forgotPasswordError').innerText = forgotPasswordError;
            document.getElementById('forgotPasswordError').style.display = 'block';
            $('#forgotPasswordModal').modal('show');
        }

        // Display success message if passed via URL
        const success = urlParams.get('success');
        if (success) {
            alert("Done Successfully");
        }
    </script>
  </body>
</html>
