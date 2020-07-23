<?php 
    require "getDB.php";
    $db = get_db();
    session_start();

    try {
        $name = $_POST['groupname'];
        $desc = $_POST['groupdesc'];

        $sql = "INSERT INTO groups (group_name, group_desc) VALUES (?,?)";
        $insert = $db->prepare($sql);
        $insert->execute([$name, $desc]);

        $last_id = $db->lastInsertId();
       
        $_SESSION['gid'] = $last_id;
        $id = $_SESSION['users_id'];
    

        $sql2 = "INSERT INTO user_groups (user_id, group_id) VALUES (?,?)";
        $insert2 = $db->prepare($sql2);
        $insert2->execute([$id, $last_id]);


        header("Location: groups.php");
        exit();
    }
    catch(PDOException $ex) {
        header("Location: index.php");
        exit();
    }
?>