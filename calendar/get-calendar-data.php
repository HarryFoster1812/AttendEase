<?php

session_start();

require_once "../php/db.php";
require_once "../php/classes/TimeslotManager.php";

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
    $userData = $_SESSION["user"];

        $timeslotManager = new TimeslotManager($pdo, $user);

        $data = $timeslotManager->getTimeslots($start_date, $end_date);
        echo json_encode($data);

    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

?>