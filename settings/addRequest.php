<?php 
session_start();

require_once "../php/db.php";
require_once '../autoload.php';

// Authenticate the user
if(!isset($_SESSION["user"])){
    ErrorHelper::createError("Could not authenticate user");
}

$user = unserialize($_SESSION["user"]);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $message = urldecode($_POST["message"]);
    try{
        $response = $db->query("INSERT INTO ChangeRequests (user_id, request_message, request_timestamp) VALUES (:userid, :message, CURRENT_TIMESTAMP())", [":userid"=>$user->getUserId(), ":message"=>$message]);
        echo $response;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}


?>
