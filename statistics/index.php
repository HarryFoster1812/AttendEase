<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
    if(unserialize($_SESSION["user"])->getRoleId() == 2){
        header("location:../statistics-lecturer/");
    }
}

else{
    header("Location:../");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistics | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="../css/student_statistics.css">
    <?php    
if(isset($_COOKIE["darkMode"])){
    echo '<link rel="stylesheet" id="darkstylesheet" href="../css/statistics_dark.css">';
}

?>
</head>
<body>
    <?php include($nav_path); ?>
   <section id="content">
        <h2 class="text-center text-black my-5 ">Your Statistics</h2>
        <div class="px-5">
            <div class="row text-center text-lg-start">
                <div class="col-xl-5 mb-4 statistic-box">
                    <h3 class="text-primary">Classes Attended:&nbsp;</h3>
                    <h3 class="text-primary" id="TotalAttended"></h3>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4 statistic-box">
                    <h3 class="text-primary">Most Attended Module: &nbsp; </h3>
                    <h3 class="text-primary" id="MostAttended"></h3>
                </div>
            </div>
            <div class="row justify-content-center text-center text-lg-start">
                <div class="col-xl-5 mb-4 statistic-box">
                    <h3 class="text-primary">Classes Missed:&nbsp; </h3>
                    <h3 class="text-primary" id="TotalMissed"></h3>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4 statistic-box">
                    <h3 class="text-primary">Least Attended Module:&nbsp; </h3>
                    <h3 class="text-primary" id="LeastAttened"></h3>
                </div>
            </div>
            <div class="row justify-content-center text-center text-lg-start">
                <div class="col-xl-5 mb-4 statistic-box">
                    <h3 class="text-primary">Classes Attended On Time:&nbsp; </h3>
                    <h3 class="text-primary" id="TotalOnTime"></h3>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4 statistic-box">
                    <h3 class="text-primary">Highest Attendance Streak:&nbsp; </h3>
                    <h3 class="text-primary" id="Streak"></h3>
                </div>
            </div>
        </div>


    </section>
    <section id="graphs">
        <div class="px-5 mt-5">
            <div class="row">
                <div class="col-xl-6">
                    <canvas id="AttendanceBar" class="mb-4 bg-primary p-3"></canvas>
                </div>
                <div class="col-xl-6">
                    <canvas id="AttendanceLine" class="mb-4 bg-primary p-3"></canvas>
                </div>
            </div>
        </div>
    </section>


    <?php include("../php/template/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/date.js"></script>
    <script type="module" src="./student_statistics.js"></script>

</body>
</html>





