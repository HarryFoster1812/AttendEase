<?php 
require_once "../autoload.php";
require_once "../php/db.php";

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

$timeSlot_id  = isset($_GET["id"]) ? $_GET["id"] : null;
if ($timeSlot_id){
    $timeSlot_id = rtrim($_GET["id"], "/"); // i dont know why but the uri is forcing a trailing / which makes the id variable change
}
else{
    // show error
}


$result = $db->query("
    SELECT 
        User.name AS name,
        User.user_id,
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
        TimeSlot.timeslot_id = :id;
    ", [":id" => $timeSlot_id]);
    
// authenticate the staff member
// decrement since staff members are at the back

for($i=sizeof($result)-1; $i > 0; $i--){
    $record = $result[$i];

    if($record["status"] != "Staff"){
        // we have not found the user in the staff section
        // the user authentication has failed
        header("Location:../access-denied/");
    }
    
    if((int)$record["user_id"] == $user->getUserId() && $record["status"] == "Staff"){
        // we have found the user;
        break;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | AttendEase</title>
        <?php include("../php/template/header.php"); ?>
        <link rel="stylesheet" href="../css/calendar.css">
        <link rel="stylesheet" href="./staffEvent.css">

    </head>
    <body>


        <div id="overlay" class="overlay hidden">
            
            <div class="popup" id="code-popup">
                <button id="close-code-btn" class="btn btn-sm btn-danger" style="position: absolute; top: 10px; right: 10px;">&times;</button>
                <h4 class="text-center">Class Code</h4>
                <div id="class-code" class="text-center my-3"></div>
                <div id="countdown">
                    <div id="countdown-number"></div>
                    <svg>
                        <circle r="18" cx="20" cy="20" id="circle"></circle>
                    </svg>
                </div>
            </div>

            <div class="popup" id="code-popup">
                <h4 class="text-center">Class Code</h4>
                <div id="class-code" class="text-center my-3">00000000</div>
                <div id="countdown-timer" class="text-center"></div>
            </div>

            <div class="popup" id="code-popup">
                <h4 class="text-center">Class Code</h4>
                <div id="class-code" class="text-center my-3"></div>
                <div id="countdown-timer" class="text-center"></div>
            </div>


            <div class="popup" id="delete-popup">
                <p>Are you sure that you want to delete the event?</p>
                <div class="button-container">
                    <button class="cancel" id="noBtn">Cancel</button>
                    <button class="crop" id="yesBtn">Delete</button>
                </div>
            </div>
        </div>


        <?php include($nav_path); ?>


        <div class="d-flex pb-2 pt-2 px-1 bg-custom sticky-top">
            <!-- Left-aligned buttons - takes up 1/3 of the width -->
            <div class="col-4 d-flex gap-2" role="group">
                <button type="button" class="btn btn-success" id="attend-btn">Mark as Attended</button>
                <button type="button" class="btn btn-danger" id="remove-btn">Remove User</button>
                <button type="button" class="btn btn-danger" id="deselect-btn">Deselect all users</button>
                <button type="button" class="btn btn-danger" id="select-btn">Select all users</button>
            </div>

            <!-- Center-aligned button - takes up 1/3 of the width -->
            <div class="col-4 d-flex justify-content-center" role="group">
                <button type="button" class="btn btn-info" id="codeShow">Show Code</button>
            </div>

            <!-- Right-aligned buttons - takes up 1/3 of the width -->
            <div class="col-4 d-flex gap-2 justify-content-end" role="group">
                <button type="button" class="btn btn-warning" id="edit-info">Edit Event Information</button>
                <button type="button" class="btn btn-danger" id="del-event">Delete Event</button>
            </div>
        </div>


        <div class="d-flex bg-white justify-content-center align-items-center text-primary mt-2 sticky-top selected-count"><h2> Selected Users:&nbsp; <h2 id="selected_count">0</h2></h2></div>

<div class="d-flex justify-content-center align-items-center flex-wrap">
    <?php 
    for($i=0;$i<sizeof($result);$i++){
        if($result[$i]["status"] == "Staff"){
            // We have reached the staff so there are no more students to show
            break;
        }

        // Add user information 
        $temp_div = '
        <div class="card class-block my-2 mx-2" style="width: 18rem; cursor: pointer;" data-user-id="%s">
            <img src="%s" alt="%s" class="card-img-top smallpfp">
            <div class="card-body">
                <h5 class="card-title text-center"><b>%s</b></h5>
                <h6 class="card-subtitle mb-2 text-muted text-center">%s</h6>
                <p class="card-text text-center">%s</p>
            </div>
        </div>
        '; 
        echo sprintf($temp_div, 
            $result[$i]["user_id"], 
            $result[$i]["file_loc"], 
            $result[$i]["name"], 
            $result[$i]["name"], 
            ucfirst($result[$i]["status"]), 
            ucfirst($result[$i]["status"])
        );
    }
    ?>
</div>
        <?php include("../php/template/footer.php"); ?>
        <script src="./staffEvent.js"></script>
    </body>
</html>
