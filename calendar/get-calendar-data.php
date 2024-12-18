<?php

session_start();

require_once "../php/db.php";

$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];

$query = "SELECT status, start_time, end_time, date, location_name, name FROM Attendance INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id INNER JOIN Locations ON TimeSlot.location_id = Locations.location_id INNER JOIN CourseEnrolement ON TimeSlot.course_id = CourseEnrolement.course_id INNER JOIN User ON CourseEnrolement.lecturer_id = User.user_id WHERE Attendance.user_id = :user_id AND TimeSlot.Date <= :end_date AND TimeSlot.Date  >= :start_date";

if ($stmt = $pdo->prepare($query)){
    $stmt->execute([":user_id"=> $_SESSION["user_id"], ":end_date" => $end_date, ":start_date" => $start_date]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
else{
    $error = "Something went wrong";
    echo $error;
}

?>