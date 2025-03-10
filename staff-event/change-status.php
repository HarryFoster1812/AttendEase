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
    $user_list = json_decode($_POST["users"]);
    $new_status = $_POST["new_status"];

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


    $userList = "";
    for($i=0;$i<sizeof($user_list);$i++){
        $userList .= $user_list[$i] . ",";
    }

    $userList = rtrim($userList, ',');

    try{
        $db->query(
            "UPDATE Attendance set status=:status WHERE user_id IN (:values) AND timeslot_id=:id", 
            [":status"=>$new_status, ":values"=>$userList, ":id"=>$timeSlot_id]
        );
        echo "Success";
    }
    catch(Exception $e){
        ErrorHelper::createError($e->getMessage());
    }
}

?>
