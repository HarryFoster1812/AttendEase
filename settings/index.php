<?php 
$URI = $_SERVER["REQUEST_URI"];

if(substr($URI, -1) == "/"){
    $new_URI = rtrim($URI, "/");
    header("Location:". $new_URI);
    exit;
}
session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:./");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="./css/calendar.css">

</head>
<body>
    <?php include($nav_path); ?>
    <?php include("../php/template/footer.php"); ?>
    <script src="./js/date.js"></script>
    <script src="./calendar/calendar.js"></script>
</body>
</html>
