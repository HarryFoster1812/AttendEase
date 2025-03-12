<?php  

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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $query = $_POST["query"];
}
?>
