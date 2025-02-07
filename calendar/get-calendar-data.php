<?php

session_start();

require_once "../php/db.php";
require_once '../autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    //echo $start_date;
    //echo $end_date;
    //echo $_SESSION["username"];

    if (!isset($_SESSION["user"])){
        echo "ERROR NO SESSION DATA";
        exit;
    }

    try {
        $userData = unserialize($_SESSION["user"]);
        $timeslotManager = new TimeslotManager($db, $userData);

        $data = $timeslotManager->getTimeslots($start_date, $end_date);
        echo json_encode($data);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
    }
}

?>
