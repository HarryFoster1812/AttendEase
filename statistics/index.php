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
    <title>Statistics | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="../css/student_statistics.css">

</head>
<body>
    <?php include($nav_path); ?>
   <section id="content">
        <h2 class="text-center text-black my-5">Your Statistics</h2>
        <div class="px-5">
            <div class="row text-center text-lg-start">
                <div class="col-xl-5 mb-4">
                    <h3 class="text-primary">Classes Attended: 76</h5>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4">
                    <h3 class="text-primary">Most Attended Module: COMP10120</h5>
                </div>
            </div>
            <div class="row justify-content-center text-center text-lg-start">
                <div class="col-xl-5 mb-4">
                    <h3 class="text-primary">Classes Missed: 24</h5>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4">
                    <h3 class="text-primary">Least Attended Module: COMP19191</h5>
                </div>
            </div>
            <div class="row justify-content-center text-center text-lg-start">
                <div class="col-xl-5 mb-4">
                    <h3 class="text-primary">Classes Attended On Time: 56</h5>
                </div>
                <div class="col-xl-5 offset-xl-2 mb-4">
                    <h3 class="text-primary">Highest Attendance Streak: 16</h5>
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
    <script src="./student_statistics.js"></script>

</body>
</html>





