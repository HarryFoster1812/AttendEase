<?php 
session_start();

require_once "../php/db.php";
require_once '../autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $message = urldecode($_POST["message"]);
    try{
        $response = $db->query("SELECT user_id FROM User WHERE username = :message OR email = :message", [":message"=>$message]);
        if (sizeof($response) != 1){
            ErrorHelper::createError("Could not find the user");
        }
        echo $response[0]["user_id"];
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}
?>
