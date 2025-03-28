<?php  

require_once "../autoload.php";
require_once "../php/db.php";
session_start();

$user = unserialize($_SESSION["user"]);

if($user->getRoleId() != 3){
    ErrorHelper::createError("Access Denied");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $query = $_POST["query"];
    $parameters = json_decode($_POST["params"], true);
    
    try{
        $response = $db->query($query, $parameters);
        echo json_encode(["response"=>$response]);
    }
    catch (Exception $e){
        echo json_encode(["response"=>0, "message"=>$e->getMessage()]);
    }
}

?>
