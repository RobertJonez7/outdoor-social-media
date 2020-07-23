<?php 
    require "getDB.php";
    $db = get_db();
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
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
                echo "<h1>" . $_SESSION['username'] . "</h1>";
            ?>
        </div>
        <hr>
        <br>
        <h2>Your Posts</h2>
        <br>
        <?php 
            $statement = $db->prepare("SELECT posts_id, post, user_post_id, post_location FROM posts WHERE user_post_id=$_SESSION[users_id]");
            $statement->execute();

            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $post = $row['post'];
                    $delete = 'delete-post' . $row['posts_id'];
                    $edit = 'edit-post' . $row['posts_id'];

                    echo
                    '<form action="" method="POST">
                        <div class="post">
                            <div class="post-container"> 
                                <div class="outline-post">
                            <div class="mini-profile"></div>
                        </div>
                        <span class="name-post">'.  $_SESSION['username'] .'</span>';
                        if($row['user_post_id'] == $_SESSION['users_id']) {
                            echo '<div class="post-button-container">
                                    <button class="delete-post" name='. $delete .'><img src="./Assets/trash.png" class="icon" alt="trash"></button><br>
                                    <button class="edit-post" name='. $edit .'><img src="./Assets/edit.png" class="icon" alt="edit"></button>
                                </div>';
                        };
                    echo
                    '</div>
                    <div class="text-post"> ' . $post . '</div>
                    </div>
                  </form>';

                if(isset($_POST[$delete])) {
                    $target = $row['posts_id'];
                    $sql = "DELETE FROM posts WHERE posts_id=?";

                    $statement2 = $db->prepare($sql);
                    $statement2->execute([$target]);
                    
                    header("Location: profile.php");
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
                            <input type="hidden" name="page" value="profile.php">
                            <button class="post-submit" type="submit" name="yo">Edit</button>
                        </div>
                    </form>';
                }
            }
            echo "<br><br><br>";
        ?>
    </div>
</body>
</html>
