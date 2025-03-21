<?php 
session_start();

require_once "../php/db.php";
require_once '../autoload.php';

// Authenticate the user
if(!isset($_SESSION["user"])){
    // change respose header to 400
    http_response_code(400);
    echo json_encode(["error" => "Could not authenticate user"]);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userData = unserialize($_SESSION["user"]);
    $timeslotManager = new TimeslotManager($db, $userData);

    if($userData->getRoleId() != 2){
        $data = $timeslotManager->getStudentStatistics();
    }
    else{
        $data = $timeslotManager->getStaffStatistics();
    }
    echo json_encode($data);

}
?>
