<?php

session_start();

require_once "../php/db.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    //echo $start_date;
    //echo $end_date;
    //echo $_SESSION["username"];

    $data = [];

    // there are two status eg student and GTA/Lecturer

    // check if the user is a student or GTA
    if ($_SESSION["role_id"] == 0 || $_SESSION["role_id"] == 1){
        $result = get_student_timeslots($pdo, $start_date, $end_date);
        array_push($data, $result);
    }

    if ($_SESSION["role_id"] == 1 || $_SESSION["role_id"] == 2){
        $result = get_staff_timeslots($pdo, $start_date, $end_date);
        array_push($data, $result);
    }

    elseif($_SESSION["role_id"] == 3){
        $result = get_student_timeslots($pdo, $start_date, $end_date);
        array_push($data, $result);
        $result = get_staff_timeslots($pdo, $start_date, $end_date);
        array_push($data, $result);
    }

    echo json_encode($data);

}

function get_student_timeslots($pdo, $start_date, $end_date){
    // this is the student query (gets all of the timeslots that records a persons attendance)
    $query = "SELECT status, start_time, end_time, date, location_name, name FROM Attendance INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id INNER JOIN Locations ON TimeSlot.location_id = Locations.location_id INNER JOIN CourseEnrolement ON TimeSlot.course_id = CourseEnrolement.course_id INNER JOIN User ON CourseEnrolement.lecturer_id = User.user_id WHERE Attendance.user_id = :user_id AND TimeSlot.Date <= :end_date AND TimeSlot.Date  >= :start_date";

    if ($stmt = $pdo->prepare($query)){
        $stmt->execute([":user_id"=> $_SESSION["user_id"], ":end_date" => $end_date, ":start_date" => $start_date]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    else{
        trigger_error("Database Query Failed");
    }
}

function get_staff_timeslots($pdo, $start_date, $end_date){
    // this is the student query (gets all of the timeslots that records a persons attendance)
    $query = "SELECT start_time, end_time, date, location_name FROM TimeSlot INNER JOIN Locations ON TimeSlot.location_id = Locations.location_id INNER JOIN CourseEnrolement ON TimeSlot.course_id = CourseEnrolement.course_id INNER JOIN User ON CourseEnrolement.lecturer_id = User.user_id WHERE CourseEnrolement.lecturer_id = :user_id AND TimeSlot.Date <= :end_date AND TimeSlot.Date  >= :start_date";

    if ($stmt = $pdo->prepare($query)){
        $stmt->execute([":user_id"=> $_SESSION["user_id"], ":end_date" => $end_date, ":start_date" => $start_date]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    else{
        trigger_error("Database Query Failed");
    }
}

?>