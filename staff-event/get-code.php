<?php 
require_once "../autoload.php";
require_once "../php/db.php";

session_start();

if(!isset($_SESSION["user"])){
    // change respose header to 400
    ErrorHelper::createError("Could not authenticate user");  
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user = unserialize($_SESSION["user"]);

    if($user->getRoleId() !== 0){
    }

    else{
        ErrorHelper::createError("Access denied");  
    }

    // check if the lecturer acctually should be able to access the page

   $timeSlot_id = $_POST["id"]; 

    $result = $db->query("
        SELECT 
        Staff.user_id,
        start_time,
        end_time,
        date
        FROM 
        CourseAssignment
        INNER JOIN 
        TimeSlot ON CourseAssignment.course_id = TimeSlot.course_id
        INNER JOIN 
        User AS Staff ON CourseAssignment.lecturer_id = Staff.user_id
        WHERE 
        TimeSlot.timeslot_id = :id;
        ", [":id" => $timeSlot_id]);

    // authenticate the staff member
    // decrement since staff members are at the back

    for($i=0; $i < sizeof($result); $i++){
        $record = $result[$i];

        if((int)$record["user_id"] == $user->getUserId()){
            // we have found the user;
            $found = true;
            break;
        }
    }

    if(!isset($found)){
        ErrorHelper::createError("Did not find user_id in list of valid users");
    }


    // make sure that the time is valid

    $st_time    =   strtotime($result[0]["start_time"]);
    $end_time   =   strtotime($result[0]["end_time"]);
    $cur_time   =   strtotime("now");

    if($st_time <= $cur_time && $end_time >= $cur_time && date("Y-m-d") == $result[0]["date"])
    {
        echo CodeGenerator::generate($timeSlot_id);
    }
    else{
        ErrorHelper::createError("The event you are trying to attend is over.");
    }


}

?>
