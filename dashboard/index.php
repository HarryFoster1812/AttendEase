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

$userData = unserialize($_SESSION["user"]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
     <?php include($nav_path); ?>

    <section class="user-details mt-5 mb-4">
        <!-- <div class="loader"></div> --> 
        <div class="px-5">
            <div class="row justify-content-center justify-content-xxl-start">
                <div class="col-xxl-6 mb-5">
                    <div class="row pt-5 outer">
                        <div class="col-xxl-3 user-img justify-content-center d-flex d-xxl-block">
                            <img src="../images/pfp.png" alt="">
                        </div>
                        <div class="col-xxl-9 justify-content-center text-center text-xxl-start d-xl-block">
                        <h2 class="text-black"><b>Welcome, <?php echo $userData->getName() ?> </b></h2>
                        <h5 class="text-muted"><?php echo $userData->getEmail() ?></h5>
                            <h4 class="text-black">B.Sc Chemistry</h3>
                            <h4 class="text-black">ID: <?php echo $userData->getUserId() ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 outer">
                    <div class="row">
                        <div class="col-lg-4">
                            <canvas id="attendanceChart" class="mb-4"></canvas>
                        </div>
                        <div class="col-lg-4">
                            <canvas id="timeChart" class="mb-4"></canvas>
                        </div>
                        <div class="col-lg-4">
                            <canvas id="rankChart" class="mb-4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr class="mx-5 border-secondary dash-line py-2 border-3">
    <section class="upcoming-classes mb-4 outer">
        <div class="px-5">
            <div class="row justify-content-center justify-content-lg-start"></div>   
                <h2 class="text-center text-black">Upcoming Classes</h2>
            <div class="row mt-5 class-block-list">

            </div>
        </div>
    </section>
    <hr class="mx-5 border-secondary dash-line py-2 border-3">
    
    <?php include("../php/template/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="../js/date.js"></script>
    <script type="module" src="dashboard.js"></script>
</body>
</html>
