<?php 
    require "getDB.php";
    $db = get_db();
    session_start();

    try { 
        $text = $_POST['posttext']; 
        $id = $_SESSION['users_id'];
        $location = 1;

        $sql = "INSERT INTO posts(post, user_post_id, post_location) VALUES (?,?,?)";
        $insert = $db->prepare($sql);
        $insert->execute([$text, $id, $location]);

        header("Location: dashboard.php");
        exit();
    }
    catch(PDOException $ex) {
        header("Location: profile.php");
        exit();
    }
?>