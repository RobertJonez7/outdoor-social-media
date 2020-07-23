<?php
    require "getDB.php";
    $db = get_db();
    session_start();

    $id = $_POST['statusid'];
    $status = $_POST['statustext'];
    $location = $_POST['loc'];
    $page = $_POST['page'];
    
    $sql = "UPDATE posts SET post=? WHERE posts_id=? AND post_location=?";
    $statement = $db->prepare($sql);
    $statement->execute([$status, $id, $location]);

    header("Location: $page");
    exit();
?>