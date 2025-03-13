<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaderboard | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="../css/calendar.css">
    <link rel="stylesheet" href="leaderboard.css">

</head>
<body>
    <template id="leaderboard-block">
        <div class="leaderboard-content rounded bg-primary row m-2 p-2 text-center align-items-center">
            <div class="col-1">
                <h4 class="rank"># 1</h4>
            </div>
            <div class="col-2">
                <h4 class="name">Bartholomew Jeremiah</h4>
            </div>
            <div class="col-3">
                <h4 class="streak">21</h4>
            </div>
            <div class="col-3">
                <h4 class="on-time">89.1%</h4>
            </div>
            <div class="col-3">
                <h4 class="attendance">98.3%</h4>
            </div>
        </div>
    </template>
    <?php include($nav_path); ?>
    <h2 class="text-black text-center my-5">🏆 Leaderboard 🏆</h2>
        <div class="leaderboard-wrapper">
        <div class="leaderboard-title rounded bg-primary row m-2 p-2 text-center align-items-center">
                <div class="col-1">
                    <h4>Rank</h4>
                </div>
                <div class="col-2">
                    <h4>Name</h4>
                </div>
                <div class="col-3">
                    <h4>Streak</h4>
                </div>
                <div class="col-3 text-truncate">
                    <h4>On Time</h4>
                </div>
                <div class="col-3 text-truncate">
                    <h4>Attendance</h4>
                </div>
            </div>
        </div>
    
    <?php include("../php/template/footer.php"); ?>
    <script type="module" src="leaderboard.js"></script>
</body>
</html>
