<?php 
    require "getDB.php";
    $db = get_db();
    session_start();

    try {
        $text = $_POST['grouptext']; 
        $groupid = $_POST['group_id_pass'];
        $id = $_SESSION['users_id'];

        $sql = "INSERT INTO posts(post, user_post_id, post_location) VALUES (?,?,?)";
        $insert = $db->prepare($sql);
        $insert->execute([$text, $id, $groupid]);

        header("Location: group-page.php");
        exit();
    }
    catch(PDOException $ex) {
        echo '<div class="red">Error: Could not post message. ' . $ex . '</div>';
    }
?>