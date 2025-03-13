<?php 
// before you mention it, yes, i know that this is the most unsafe (vulnerable) piece of code ive ever knowingly written
// My thought process was that if admins can do anything and have unfiltered access to the databse anyway, do i really need to be safe?.
// my conclusion was no. no i do not. 

require_once "../autoload.php";
require_once "../php/db.php";

UrlHelper::enforceTrailingSlash();

session_start();

$user = unserialize($_SESSION["user"]);

if($user->getRoleId() == 3){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../access-denied/");
}

$table = $_GET["table"];
$filter = $_GET["filter"];
$id = $_GET["id"];
$multifilter = $_GET["multi"];

// there will be three pages in this one. One that will show all of the tables
// one that will show all of the records within a table (you can only add/remove records or go to the edit record page)
// one that will show all of the properties of a  record and allow editing


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Database Edit | AttendEase</title>
        <?php include("../php/template/header.php"); ?>

    </head>
    <body>

        <?php include($nav_path); ?>

        <?php 
        if(isset($table)){
            if(isset($filter)){
                include("record_page.php");
                echo '<script src="./record_page.js"></script>';
            }

            else{
                include("table_page.php");
                echo '<script src="./table_page.js"></script>';
            }
        }

        else{
            include("database_page.php");
                echo '<script src="./database_page.js"></script>';
        }

        ?>


        <?php include("../php/template/footer.php"); ?>

    </body>
</html>
