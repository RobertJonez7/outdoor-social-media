<?php
    require "getDB.php";
    $db = get_db();
    session_start();

   try {
        $gid = $_POST['groupidperson'];
        $person = $_POST['addperson'];
        $sql = "SELECT users_id FROM users WHERE email=?";

        $statement = $db->prepare($sql);
        $statement->execute([$person]);

        $id = $statement->fetch(PDO::FETCH_ASSOC);

        if(is_null($id['users_id'])) {
            header("Location: add-person-failed.php");
            exit();
        }

        $userid = $id['users_id'];
        $sql2 = "INSERT INTO user_groups(user_id, group_id) VALUES(?,?)";
        $stmt = $db->prepare($sql2);
        $stmt->execute([$userid, $gid]);

        header("Location: add-person-success.php");
        exit();
    }
    catch(PDOException $ex) {
        header("Location: add-person-failed.php");
        exit();
    }
?>