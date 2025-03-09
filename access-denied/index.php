<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();
 $nav_path = "../php/template/navbar.php";

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Access Denied | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <style>
        body{
            background-color: #f8d7da;
        }
        .container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #721c24;
        }
        .container {
            text-align: center;
        }
        .btn-home {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <?php include($nav_path); ?>
    <div class="container">
        <h1 class="display-3">Access Denied</h1>
        <p class="lead">You do not have permission to view this page.</p>
        <a href="../" class="btn btn-danger btn-home">Go Back to Home</a>
    </div>
    <?php include("../php/template/footer.php"); ?>

</body>
</html>
