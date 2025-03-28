<?php 
session_start();

require_once "../autoload.php";
require_once "../php/db.php";

// run SQL queries to deleate all user data

if(!isset($_SESSION["user"])){
    // change respose header to 400
    http_response_code(400);
    echo json_encode(["error" => "Could not authenticate user"]);
    exit();
}

$user = unserialize($_SESSION["user"]);
$queries = ["DELETE FROM User WHERE user_id = :user_id;"];
//try{
    if($user->getRoleId() == 0){
        // it is a student
        array_push($queries, "DELETE FROM Attendance WHERE user_id = :user_id;"); 
    }
    else if($user->getRoleId() == 1){
        // it is a gta
        array_push($queries, "DELETE FROM Attendance WHERE user_id = :user_id;");
        array_push($queries, "DELETE FROM CourseAssignment WHERE lecturer_id = :user_id;");
    }
    else if($user->getRoleId() == 2){
        // it is a lecturer
        array_push($queries, "DELETE FROM CourseAssignment WHERE lecturer_id = :user_id;");
    }

    foreach($queries as $query){
        $db->query($query, [
            ":user_id" => $user->getUserId()
        ]);
    }

    //}
/*
catch(Exception $e){
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}
 */
session_destroy();
header("Location:../");
?>
