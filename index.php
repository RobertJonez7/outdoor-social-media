<?php
    session_start();

    if(isset($_SESSION['users_id'])) {
        header("Location: dashboard.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['submit-login'])) {
            require 'login.php';
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
                <a href="index.php"><button id="login-button">Log In</button></a>
                <a href="register.php"><button id="signup-button">Sign Up</button></a>
            </div>

            <form action="login-logic.php" method="POST" class="login-form">
                <br>
                <br>
                <input type="text" class="login-input" id="email-input" name="email" placeholder="Email" required>
                <br>
                <input type="password" class="login-input" id="password-input" name="passwords" placeholder="Password" required>
                <br>
                <br>
                <button type="submit" class="submit" name="submit-login">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>