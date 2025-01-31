<?php

session_start();

$URI = $_SERVER["REQUEST_URI"];

if(substr($URI, -1) != "/"){
    header("Location:". $URI . "/");
    exit;
}

if (!isset($_SERVER["user"])){
    header("Location:login");
}
else{
    header("Location:dashboard");
}

?>