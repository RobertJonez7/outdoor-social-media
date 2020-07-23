<?php 
    require "getDB.php";
    $db = get_db();
    session_start();
    $message = '';

    if(!is_null($_POST['id'])) {
        $_SESSION['group_page_id'] = $_POST['id'];
        $groupid = $_SESSION['group_page_id'];
    }
    else {
        $groupid = $_SESSION ['group_page_id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script src="scripts.js"></script>
    <title>Outdoor App</title>
</head>
<body>
    <div class="container">
        <aside id="main-sidebar">
            <h1 id="main-title">Outdoor App</h1>
            <ul id="main-list">
                <li><a href="dashboard.php"><img src="./Assets/dash.png" class="icon" alt="dash"><span class="icon-text">Dashboard</span></a></li>
                <li><a href="explore.php"><img src="./Assets/explore.png" class="icon" alt="explore"><span class="icon-text">Explore</span></a></li>
                <li><a href="groups.php"><img src="./Assets/groups.png" class="icon" alt="groups"><span class="icon-text">Groups</span></a></li>
                <li><a href="profile.php"><img src="./Assets/profile.png" class="icon" alt="profile"><span class="icon-text">Profile</a></span></li>
                <li><a href="search.php"><img src="./Assets/search.png" class="icon" alt="search"><span class="icon-text">Search</span></a></li>
            </ul>
            <form action="logout.php" method="GET" id="logout-form">
                <button id="size-button" type="submit"><img src="./Assets/logout.png" class="icon" alt="logout"></button>
                <div id="logouttext">Logout</div>
            </form>
        </aside>

        <div class="content-container">
            <div class="center">
                <div id="profile-outline">
                    <div id="profile-pic"></pic>
                </div>
            </div>
            <br>

            <?php 
                $sql = "SELECT group_name, group_desc FROM groups WHERE group_id='$groupid'";
                
                $statement = $db->prepare($sql);
                $statement->execute();
                $find = $statement->fetch(PDO::FETCH_ASSOC);

                echo "<h1>" . $find['group_name'] . "</h1>";
                echo "<div class=center>" . $find['group_desc'] . "</div>";
            ?>

        </div>

        <br><hr><br><h2>Members</h2><br>
        <div class="center-row">
            <form action="" method="POST">
                <input type="text" class="group-input" name="addperson" placeholder="Enter Email to add Person"/>
                <?php echo "<input type=hidden name=groupidperson value=$groupid />" ?>
                <button class="post-submit" type="submit" name="add">Submit</button>
            </form>
        </div>

        <?php 
            if(isset($_POST["add"])) {
                $gid = $_POST['groupidperson'];
                $person = $_POST['addperson'];
                $sql = "SELECT users_id FROM users WHERE email=?";

                $statement = $db->prepare($sql);
                $statement->execute([$person]);

                $id = $statement->fetch(PDO::FETCH_ASSOC);

                if(is_null($id['users_id'])) {
                    $message = 'Error: could not find person';
                }
                else {     
                    $userid = $id['users_id'];
                    $sql2 = "INSERT INTO user_groups(user_id, group_id) VALUES(?,?)";
                    $stmt = $db->prepare($sql2);
                    $stmt->execute([$userid, $gid]);
                }
            }
        ?>

        <br>
        <div class="member-container">
        <?php
            $sql = "SELECT user_id FROM user_groups WHERE group_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$groupid]);

            while($member = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $name = $member['user_id'];
                $find = $db->prepare("SELECT users_name FROM users WHERE users_id=?");
                $find->execute([$name]);
                $result = $find->fetch(PDO::FETCH_ASSOC);

                echo 
                '<div class="post-container"> 
                    <div class="outline-post">
                        <div class="mini-profile"></div>
                    </div>
                    <span class="member-post">'. $result['users_name'] .'</span> 
                </div>';
            }
        ?>
        </div>
        <?php 
            echo '<br><div class="red"><div class="center">' . $message . '</div></div>';
        ?>

        <br><hr><br>
        <h2>Group Posts</h2>
        <br>
        <div class="post">
            <form action="group-post.php" method="POST">
                <div class="post-container">
                    <div class="outline-post">
                        <div class="mini-profile"></div>
                    </div>
                    <input type="text" class="input-post" name="grouptext" placeholder="Say Something!"/>
                    <input name="group_id_pass" type="hidden" value=<?php echo $groupid ?>>
                    <button class="post-submit" type="submit" name='group-submit'>Submit</button>
                </div>
            </form>
        </div>

        <?php
            $statement3 = $db->prepare("SELECT posts_id, post, user_post_id, post_location FROM posts WHERE post_location=?");
            $statement3->execute([$groupid]);

            while($row = $statement3->fetch(PDO::FETCH_ASSOC)) {
                $grouppost = $row['post'];
                $search = $db->prepare("SELECT users_name FROM users WHERE users_id=$row[user_post_id]");
                $search->execute();
                $title = $search->fetch(PDO::FETCH_ASSOC);
                $delete = 'delete-post' . $row['posts_id'];
                $edit = 'edit-post' . $row['posts_id'];

                echo
                '<form action="" method="POST">
                    <div class="post">
                    <div class="post-container"> 
                        <div class="outline-post">
                            <div class="mini-profile"></div>
                        </div>
                        <span class="name-post">'. $title['users_name'] .'</span> ';

                        if($row['user_post_id'] == $_SESSION['users_id']) {
                            echo '<div class="post-button-container">
                                    <button class="delete-post" name='. $delete .'><img src="./Assets/trash.png" class="icon" alt="trash"></button><br>
                                    <button class="edit-post" name='. $edit .'><img src="./Assets/edit.png" class="icon" alt="edit"></button>
                                </div>';
                        }

                    echo '</div>
                    <div class="text-post"> ' . $grouppost . '</div>
                </div>
                </form>';

                if(isset($_POST[$delete])) {
                    $target = $row['posts_id'];
                    $sql = "DELETE FROM posts WHERE posts_id=?";

                    $statement2 = $db->prepare($sql);
                    $statement2->execute([$target]);
                    
                    header("Location: group-page.php");
                    exit();
                }
                if(isset($_POST[$edit])) {
                    echo 
                    '<form action="update-status.php" method="POST">
                        <div class="edit-container">
                            <div>Edit Status</div>
                            <input type="text" class="input-post" name="statustext" placeholder="Update Status Here" />
                            <input type="hidden" name="statusid" value=' . $row['posts_id'] . '>
                            <input type="hidden" name="loc" value='. $row['post_location'] .'>
                            <input type="hidden" name="page" value="group-page.php">
                            <button class="post-submit" type="submit" name="yo">Edit</button>
                        </div>
                    </form>';
                }
            }
            echo '<br><br>';
            echo'
            <form action="" method="POST">
                <div class="group-buttons-container">
                    <button class="delete-group" name="deletegroup">Delete Group</div>
                </div>
            </form>';

            if(isset($_POST['deletegroup'])) {
                $sql = "DELETE FROM groups WHERE group_id=?";
                $statement4 = $db->prepare($sql);
                $statement4->execute([$groupid]);

                $sql2 = "DELETE FROM user_groups WHERE group_id=?";
                $statement5 = $db->prepare($sql2);
                $statement5->execute([$groupid]);

                header("Location: groups.php");
                exit();
            }
            echo '<br><br>';
        ?>
    </div>
</body>
</html>