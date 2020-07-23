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
    <title>Groups</title>
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
        <div class="content-container" id="content">
            <h1 class="header-title">Groups</h1>
            <a href="profile.php">
                <div class="mini-outline">
                    <div class="mini-profile"></div>
                </div>
            </a>
            <hr>
            <br>
            <h2>Create New Group</h2>
            <div class="groups">
                <form action="add-group.php" method="POST">
                    <div class="group-container">
                        <input type="text" class="input-group" name="groupname" placeholder="Group Name"/>
                        <br>
                        <input type="text" class="input-group" name="groupdesc" placeholder="Group Desc"/>
                        <br>
                        <button class="post-submit" type="submit">Create</button>
                    </div>
                </form>
            </div>
            <br>
            <h2>Your Groups</h2>
            <br><hr>
            <br>
            <?php 
                $user = $_SESSION['users_id'];
                $sql = "SELECT group_id FROM user_groups WHERE user_id=?";

                $statement = $db->prepare($sql);
                $statement->execute([$user]);

                while($find = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $display = $db->prepare("SELECT group_name, group_desc, group_id FROM groups WHERE group_id=$find[group_id]");
                    $display->execute();
                    $name = $display->fetch(PDO::FETCH_ASSOC);

                    echo 
                    '<form action="group-page.php" method="POST">
                        <div class="post" id="search-container">
                            <div class="post-container"> 
                                <div class="outline-post">
                                    <div class="mini-profile"></div>
                                </div>
                            <span class="name-post">'. $name['group_name'] .'</span> 
                            </div>
                            <div class="end">
                                <button class="post-submit" type="submit">View</button>
                            </div>
                            <input name="id" type="hidden" value=' . $name['group_id'] .'>
                        </div>
                    </form>';
                }
                echo "<br><br><br>";
            ?>
        </div>
    </div>
</body>
</html>