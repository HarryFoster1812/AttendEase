<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
    if(unserialize($_SESSION["user"])->getRoleId() != 2){
        header("location:../statistics/");
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
    <link rel="stylesheet" href="../css/lecturer_statistics.css">

</head>
<body>
    <?php include($nav_path); ?>
    <section id="content">
        <h2 class="text-black text-center my-5">Lesson Statistics</h2>
        <div class="d-flex flex-column align-items-center justify-content-center">
            

            <div class="text-primary d-flex align-items-center justify-content-center mb-5">
                <h2>Selected Module:&emsp;</h2>
                <select id="ModuleDropdown" class="form-select w-auto">
                </select>
            </div>

            <div class="text-primary d-flex align-items-center justify-content-center mb-5">
                <h2>Selected Type:&emsp;</h2>
                <select id="TypeDropdown" class="form-select w-auto">
                </select>
            </div>       
         </div>        
        <div class="px-5">
            <canvas id="AttendanceChart" class="mb-4 bg-primary p-3"></canvas>
        </div>
    </section>

    <?php include("../php/template/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="./lecturer_statistics.js"></script>

</body>
</html>
