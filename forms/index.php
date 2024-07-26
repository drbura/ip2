<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./components/Login/style/login_style.css">
</head>
<body>
    <div class="container" id="signIn">
        <h1 class="form-title">Welcome</h1>
        <div class="logo"><img src="./components/Images/download.jpg" alt=""></div>
        <form id="StudentForm" method="post" action="check_login.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="text" class="inputemail2" name="email" id="studId" placeholder="Email" required>
                <label for="studId" class="username">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="studPass">Password</label>
            </div>
            <input type="submit" class="btn" value="Login" name="signIn">
        </form>
    </div>
    <script src="./components/Login/js/login_script.js"></script>
</body>
</html>
