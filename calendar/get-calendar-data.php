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

<<<<<<< HEAD
    $data = [];

    // there are two status eg student and GTA/Lecturer

    // check if the user is a student or GTA
    //echo $_SESSION["role_id"];
    if ($_SESSION["role_id"] == 0 || $_SESSION["role_id"] == 1){
        $result = get_student_timeslots($pdo, $start_date, $end_date);
        array_push($data, $result);
=======
    if (!isset($_SESSION["user"])){
        echo "ERROR NO SESSION DATA";
        exit;
>>>>>>> template_testing
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