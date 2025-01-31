<?php 

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
    <title>Admin | AttendEase</title>
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
