<?php 
session_start();

require_once "../php/db.php";
require_once '../autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $message = urldecode($_POST["message"]);
    $userId = $_POST["id"];
    try{
        $response = $db->query("INSERT INTO ChangeRequests (user_id, request_message, request_timestamp) VALUES (:userid, :message, CURRENT_TIMESTAMP())", [":userid"=>$userId, ":message"=>"PASSWORD RESET REQUEST: ".$message]);
        echo $response;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}


?>
