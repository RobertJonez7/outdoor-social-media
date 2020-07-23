<?php 
    require "getDB.php";
    $db = get_db();
    session_start();

    try { 
        //$hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $insert = $db->prepare("INSERT INTO users(users_name, password, email) VALUES('$_POST[username]', '$_POST[passwords]', '$_POST[email]')");
        $insert->execute();

        $statement = $db->prepare("SELECT users_id, users_name, password, email FROM users WHERE email='$_POST[email]' AND users_name='$_POST[username]'");
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
    
        $_SESSION['username'] = $row['users_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['users_id'] = $row['users_id'];

        header("Location: dashboard.php");
        exit();
    }
    catch(PDOException $ex) {
        header("Location: register.php");
        exit();
    }
?>