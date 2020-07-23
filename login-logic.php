<?php 
    require "getDB.php";
    $db = get_db();
    session_start();

    try { 
        $attemptedP = $_POST['passwords'];
        $attemptedE = $_POST['email'];

        $statement = $db->prepare("SELECT users_id, users_name, password, email FROM users WHERE email='$attemptedE'AND password='$attemptedP'");
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($count = $statement->rowCount() == 0) {
            header("Location: index.php");
            exit();
        }
        else{
            $_SESSION['username'] = $row['users_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['users_id'] = $row['users_id'];

            header("Location: dashboard.php");
            exit();
        }       
    }
    catch(PDOException $ex) {
        header("Location: index.php");
        exit();
    }
?>