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
    <link rel="stylesheet" href="../css/lecturer_statistics.css">

</head>
<body>
    <?php include($nav_path); ?>
    <section id="content">
        <h2 class="text-black text-center my-5">Lesson Statistics</h2>
        <h2 class="text-primary text-center mb-5">Selected Module: COMP10120</h2>
        <div class="px-5">
            <canvas id="AttendanceChart" class="mb-4 bg-primary p-3"></canvas>
        </div>
    </section>

    <?php include("../php/template/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./lecturer_statistics.js"></script>

</body>
</html>
