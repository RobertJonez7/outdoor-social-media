<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['submit-register'])) {
            require "register-logic.php";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
    <h1 id="login-title">Outdoor App</h1>
            <div class="login">
                <div class="button-container">
                    <a href="index.php"><button id="login-button-reg">Log In</button></a>
                    <a href="register.php"><button id="signup-button-reg">Sign Up</button></a>
                </div>
            <br>
            <br>
            <form action="register-logic.php" method="POST">
                <input type="text" class="login-input" id="username-input" name="username" placeholder="Full Name*" required>
                <br>
                <br>
                <input type="text" class="login-input" id="email-input" name="email" placeholder="Email*" required>
                <br>
                <br>
                <input type="password" class="login-input" id="password-input" name="passwords" placeholder="Password*" required>
                <br>
                <br>
                <div class="button-container">
                    <button type="submit" class="submit" name="submit-register">Create User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>