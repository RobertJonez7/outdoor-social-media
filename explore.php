<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <title>Explore</title>
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
            <h1 class="header-title">Explore</h1>
            <a href="profile.php">
                <div class="mini-outline">
                    <div class="mini-profile"></div>
                </div>
            </a>
            <hr>
            <div class="explore-container">
                <div class="card"></div>
                <div class="card"></div>
                <div class="card"></div>
                <div class="card"></div>
                <div class="card"></div>
                <div class="card"></div>
            </div>
        </div>
    </div>
</body>
</html>