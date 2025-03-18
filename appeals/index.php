<?php
require_once "../autoload.php";
require_once '../php/db.php'; // Import Database instance

UrlHelper::enforceTrailingSlash();

session_start();
$user = unserialize($_SESSION["user"]);

if($user->getRoleId() !== 0){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../access-denied/");
}

// check if the lecturer acctually should be able to access the page

$user_id  = isset($_GET["id"]) ? $_GET["id"] : null;
if ($user_id){
    $user_id = rtrim($_GET["id"], "/"); // i dont know why but the uri is forcing a trailing / which makes the id variable change
}
else{
    // show error
}

$appeals = $db->query("SELECT
                User.file_loc,
                User.name,
                TimeSlot.timeslot_id,
                TimeSlot.start_time,
                TimeSlot.end_time,
                TimeSlot.date,
                Course.course_title,
                Attendance.status,
                Attendance.appeal,
                Attendance.appeal_message,
                Attendance.user_id
            FROM
                Attendance
            INNER JOIN
                User ON Attendance.user_id = User.user_id
            INNER JOIN
                TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id
            INNER JOIN
                Course ON TimeSlot.course_id = Course.course_id
            INNER JOIN
                CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id
            WHERE
                CourseAssignment.lecturer_id = :id -- Replace [your_lecturer_id] with the actual lecturer ID
                AND Attendance.appeal = 1;
            ", [":id" => (int) $user_id]);

$result = $db->query("
    SELECT 
        User.name AS name,
        User.user_id,
        User.email,
        Attendance.status AS status,  -- Corrected column alias for status
        User.role_id,
        User.file_loc
    FROM 
        Attendance
    INNER JOIN 
        TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id
    INNER JOIN 
        CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id
    INNER JOIN 
        User ON Attendance.user_id = User.user_id
    WHERE 
        TimeSlot.timeslot_id = :id

    UNION ALL

    SELECT 
        Staff.name AS name,
        Staff.user_id,
        Staff.email,
        'Staff' AS status,  -- Corrected static status for staff
        Staff.role_id,
        Staff.file_loc
    FROM 
        CourseAssignment
    INNER JOIN 
        TimeSlot ON CourseAssignment.course_id = TimeSlot.course_id
    INNER JOIN 
        User AS Staff ON CourseAssignment.lecturer_id = Staff.user_id
    WHERE 
        Staff.user_id = :id;
    ", [":id" => $user_id]);
    
// authenticate the staff member
// decrement since staff members are at the back
for($i=sizeof($result)-1; $i >= 0; $i--){
    $record = $result[$i];
    if($record["status"] != "Staff"){
        // we have not found the user in the staff section
        // the user authentication has failed
        header("Location:../access-denied/");
    }
    
    if((int)$record["user_id"] == $user->getUserId() && $record["status"] == "Staff"){
        // we have found the user;
        $found = true;
        break;
    }
}

if(!isset($found)){
    // we could not find them since there are no students or the id does not exists
    header("Location:../access-denied/");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Appeals - ID <?php echo $user_id; ?> | AttendEase</title>
        <?php include("../php/template/header.php"); ?>
        <link rel="stylesheet" href="../css/calendar.css">
        <link rel="stylesheet" href="../css/attend.css">
        <link rel="stylesheet" href="../staff-event/staffEvent.css">

    </head>
    <body data-user-id="<?php echo $user_id ?>">
    <template id="nav-fail">
            <div class="nav-box-fail p-2 m-1 border border-2 border-danger rounded-3">
                <h5 class="text-danger fw-bold" id="title">Could not mark your attendance, please try again!</h5>
                    <p class="text-danger" id="message">We could not mark your attendance. This is because either you are not in the assigned room or our geoloction detector has failed its purpose. If this issue persists, please contact AttendEase.</p>
            </div>
        </template>
        <template id="nav-success">
            <div class="nav-box-success p-2 m-1 border border-2 border-success rounded-3">
                <h5 class="text-success fw-bold">Marked your attendance!</h4>
                    <p class="text-success">Your attendance for this class has been successfully marked!</p>
            </div>
        </template>
    <div id="overlay" class="overlay hidden"> 
        <div class="popup flex-column" id="message-popup">
                <h4 class="text-center mt-3 text-black code-title mb-4 border-bottom border-2 pb-2">Appeal Message</h4>
                <h5 class="text-black pb-3 text-start" id="message-content">You will not be able to check in to your session if you do attend. If you do attend this session, either contact your lecturer directly or make an appeal after the session.</h5>
                <div class="d-flex justify-content-end border-top border-2 mt-4 gap-2 pt-3">
                    <button class="btn btn-danger" onclick="hidePopup()">Close</button>
                </div>
            </div>
        </div>
        <div class="popup flex-column" id="warning-popup">
                <h4 class="text-center mt-3 text-black code-title mb-4 border-bottom border-2 pb-2">Marking Confirmation</h4>
                <h5 class="text-black pb-3 text-start" id="warning-content">Are you sure that you want to mark this user as <b id="warning-status">Test</b> for this session?</h5>
                <div class="d-flex justify-content-end border-top border-2 mt-4 gap-2 pt-3">
                    <button class="btn btn-danger" onclick="hidePopup()">Close</button>
                    <button class="btn btn-success" onclick="hidePopup()">Proceed</button>
                </div>
            </div>
        </div>
        <div class="popup flex-column" id="attendance-popup">
                <h4 class="text-center text-primary mb-4">Change Attendance Status</h4>
                <select id="TypeDropdown" class="form-select w-auto">
                    <option selected>Attended</option>
                    <option>Late</option>
                    <option>Missed</option>
                </select>
                <div class="button-container mt-4">
                    <button class="btn btn-danger cancel" >Cancel</button>
                    <button class="btn btn-success" id="attendYesBtn">Change</button>
                </div>
            </div>
        <?php include($nav_path); ?>


        <div class="d-flex pb-2 pt-2 px-1 bg-custom sticky-top gap-2 justify-content-around">
            <!-- Left-aligned buttons - takes up 1/3 of the width -->
                <button type="button" class="btn btn-success" id="attend-btn">Mark as Attended</button>
                <button type="button" class="btn btn-danger" id="deselect-btn">Deselect all</button>
                <button type="button" class="btn btn-danger" id="select-btn">Select all</button>
        </div>


        <div class="d-flex bg-white justify-content-center align-items-center text-primary mt-5 mb-4 selected-count"><h2> Selected Users:&nbsp; <h2 id="selected_count">0</h2></h2></div>

<div class="d-flex justify-content-center align-items-center flex-wrap">
    <?php 
    for($i=0;$i<sizeof($appeals);$i++){
        if($appeals[$i]["status"] == "Staff"){
            // We have reached the staff so there are no more students to show
            break;
        }

        // Add user information 
        $temp_div = '
        <div id="userContainer%s" class="card class-block my-4 mx-2" style="width: 20rem; cursor: pointer;" data-user-id="%s" data-ts-id="%s">
            <img src="%s" alt="%s" class="card-img-top smallpfp">
            <div class="card-body">
                <h4 class="card-title text-center mb-3"><b>%s</b></h5>
                <h5 class="card-subtitle mb-3 text-muted text-center">%s</h6>
                <h5 class="card-subtitle mb-3 text-muted text-center">%s</h6>
                <h5 class="card-subtitle mb-3 text-muted text-center">%s-%s</h6>
                <p class="card-text text-center status">%s</p>
                <div class="d-flex justify-content-center mb-3">
                    <button class="btn btn-primary btn-lg reason-check">Check Reason</button>
                </div>
                <div class="btn-list d-flex justify-content-center gap-3">
                     <button id="Attended" title="Mark as on time" class="btn btn-primary"><i class="fa fa-check staff-icons" style="color:#32cd32;" aria-hidden="true"></i></button>
                     <button id="Late" title="Mark as late" class="btn btn-primary"><i class="fa-solid fa-clock staff-icons" style="color:orange;"></i></button>
                     <button id="Missed" title="Mark as absent" class="btn btn-primary"><i class="fa fa-times staff-icons" style="color:red;"></i></button>
                </div>
            </div>
        </div>
        '; 
        echo sprintf($temp_div, 
            $i, 
            $appeals[$i]["user_id"], 
            $appeals[$i]["timeslot_id"], 
            $appeals[$i]["file_loc"], 
            $appeals[$i]["name"], 
            $appeals[$i]["name"], 
            ucfirst($appeals[$i]["course_title"]), 
            (new DateTime($appeals[$i]["date"]))->format('d-m-Y'), 
            (new DateTime($appeals[$i]["start_time"]))->format('H:i'),
            (new DateTime($appeals[$i]["end_time"]))->format('H:i'),
            $appeals[$i]["status"]

        );
    }
    ?>
</div>

        <?php include("../php/template/footer.php"); ?>
        <script src="../staff-event/staffEvent.js"></script>
        <script>const appeals = <?php echo json_encode($appeals); ?>;</script>
        <script src="appeals.js"></script>
    </body>
</html>