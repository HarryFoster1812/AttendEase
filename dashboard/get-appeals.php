<?php
require_once "../php/db.php";
require_once '../autoload.php';

if(!isset($_SESSION["user"])){
    ErrorHelper::createError("Could not authenticate user");
}

$userData = unserialize($_SESSION["user"]);

if($userData->getRoleId() != 2 || $userData->getRoleId() != 3){
    ErrorHelper::createError("Access Denied");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        $timeslotManager = new TimeslotManager($db, $userData);
        $timeslotManager->getAppeals(); 
        echo json_encode($data);

    } catch (Exception $e) {
        ErrorHelper::createError($e->getMessage());
    }
}
?>

