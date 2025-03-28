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
    <body data-role-id="<?php echo $userData->getRoleId(); ?>">
     <?php include($nav_path); ?>

    <?php include("../php/template/popup.php"); ?>
    <section class="user-details mt-5 mb-4">
        <!-- <div class="loader"></div> --> 
        <div class="px-5">
            <div class="row justify-content-center justify-content-xxl-start">
                <div class="col-xxl-6 mb-5">
                    <div class="row pt-5 outer">
                        <div class="col-xxl-3 user-img justify-content-center d-flex d-xxl-block">
                        <img src="<?php echo $userData->getPfpPath(); ?>" alt="" class="user-pfp">
                        </div>
                        <div class="col-xxl-9 justify-content-center text-center text-xxl-start d-xl-block">
                        <h2 class="text-black"><b>Welcome, <?php echo $userData->getName() ?> </b></h2>
                        <h5 class="text-muted"><?php echo $userData->getEmail() ?></h5>
                        <h4 class="text-black"><?php echo $userData->getAcademic() ?></h4>
                        <h4 class="text-black">ID: <?php echo $userData->getUserId() ?></h4>
                        <?php if ($userData->getRoleId() > 0): ?>
                                <a class="btn btn-lg btn-primary check-requests" href="../appeals/?id=<?php echo $userData->getUserId() ?>">Check Appeals</a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 outer">
                    <div class="row justify-content-end">
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
