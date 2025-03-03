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
    <base  href=".">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../css/attend.css">
<?php    
if(isset($_COOKIE["darkMode"])){
    echo '<link rel="stylesheet" id="darkstylesheet" href="../css/dashboard_dark.css">';
}

?>
</head>
<body>
     <?php include($nav_path); ?>
     <div class="attend-backdrop d-none justify-content-center align-items-center">
        <div class="attend-popup">
            <div class="container px-5 py-4">
                <div class="d-flex justify-content-end mb-2">
                    <div class="attend-close-icon">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="d-flex mb-3 justify-content-center">
                    <div class="">
                        <h2>Mark Your Attendance!</h2>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group rounded-pill">
                        <button class="btn btn-secondary" id="loc-button">Location</button>
                        <button class="btn btn-light" id="code-button">Enter Code</button>
                    </div>
                </div>      
                    
                <div class="d-flex justify-content-center attend-image mb-4" id="attend-image">
                    <img src="../images/map.png" alt="">
                </div>
                <div class="row attend-code-block mb-4 d-none" id="code-block">
                    <form action="">
                        <input type="text" class="form-control form-control-lg attend-code" placeholder="Enter Class Code..." id="attend-code">
                    </form>
                </div>
                <div class="row mt-5 pt-3">
                    <div class="col-lg-6 mb-3">
                        <h3 class="attend-details-title">Class</h3>
                        <h4 class="attend-details-content">COMP10120</h4>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <h3 class="attend-details-title">Time</h3>
                        <h4 class="attend-details-content">10:00 - 11:00</h4>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3">
                        <h3 class="attend-details-title">Location</h3>
                        <h4 class="attend-details-content">Kilburn TH 1.1</h4>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <h3 class="attend-details-title">Instructor</h3>
                        <h4 class="attend-details-content">Mr. Walter White</h4>
                    </div>
                </div>
                <div class="attendance-control d-flex justify-content-end gap-3 mt-5">
                    <button class="btn btn-light">Cancel</button>
                    <button class="btn btn-success">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <section class="user-details mt-5 mb-4">
        <!-- <div class="loader"></div> --> 
        <div class="px-5">
            <div class="row justify-content-center justify-content-xxl-start">
                <div class="col-xxl-6 mb-5">
                    <div class="row pt-5 outer">
                        <div class="col-xxl-3 user-img justify-content-center d-flex d-xxl-block">
                        <img src="<?php echo $userData->getPfpPath(); ?>" alt="">
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
    <script src="../js/attend.js"></script>
</body>
</html>
