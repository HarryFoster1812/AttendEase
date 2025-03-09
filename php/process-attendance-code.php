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

$attendance_options = ["Attended", "Late"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $code = $_POST["code"];
    $user = unserialize($_SESSION["user"]);
    $timeSlotId = (int) $_POST["timeslot_id"];

    $generatedCode = CodeGenerator::generate($timeSlotId); 
    // compare to the user code

    $time_slot_information = $db->query(
        "SELECT * FROM TimeSlot WHERE timeslot_id=:id", 
        [":id" => $timeSlotId]
    );
    
    if(sizeof($time_slot_information)>0){
        $time_slot_information = $time_slot_information[0];
    }   
    else{
        http_response_code(400);
        echo json_encode(["error" => "No TimeSlot could be found with the given ID"]);
        exit();
    }

    if((string) $generatedCode == $code){
        // change timeslot
        $st_time    =   strtotime($time_slot_information["start_time"]);
        $end_time   =   strtotime($time_slot_information["end_time"]);
        $quarterTime =   $st_time + ($end_time-$st_time)/4;
        $cur_time   =   strtotime("now");

        if($st_time < $cur_time && $end_time > $cur_time)
        {
            if($cur_time > $quarterTime){
                $status = $attendance_options[1];
            }
            else{
                $status = $attendance_options[0];
            }
        }
        else{
            http_response_code(400);
            echo json_encode(["error" => "The event you are trying to attend has either not started or has ended."]);
            exit();
        }

        $rowsAffected = $db->query(
            "UPDATE Attendance SET status = :status WHERE user_id = :userID AND timeslot_id = :timeslotID",
            [":status" => $status, ":userID" => $user->getUserId(), ":timeslotID" => $timeSlotId]
        );

        echo "Success";
    }

    else{
        http_response_code(400);
        echo json_encode(["error" => "The code entered is incorrect"]);
        exit();
    }
}
?>
