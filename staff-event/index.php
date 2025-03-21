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

$timeSlotInfo = $db->query("SELECT * FROM TimeSlot WHERE timeslot_id=:id", [":id" => $timeSlot_id])[0];
$locations = $db->query("SELECT location_name, location_id FROM Location ORDER BY location_name", []);

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
        TimeSlot.timeslot_id = :id;
    ", [":id" => $timeSlot_id]);
    
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
        <title>Event Edit - ID <?php echo $timeSlot_id; ?> | AttendEase</title>
        <?php include("../php/template/header.php"); ?>
        <link rel="stylesheet" href="../css/calendar.css">
        <link rel="stylesheet" href="../css/attend.css">
        <link rel="stylesheet" href="./staffEvent.css">
        <?php    
        if(isset($_COOKIE["darkMode"])){
            echo '<link rel="stylesheet" id="darkstylesheet" href="../css/staffEvent_dark.css">';
        }

        ?>
    </head>
    <body data-timeslotid="<?php echo $timeSlot_id ?>">

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
            
            <div class="popup flex-column" id="code-popup">
                <button id="close-code-btn" class="btn btn-sm btn-danger" style="position: absolute; top: 20px; right: 20px;"><i class="fa fa-times close-ico"></i></button>
                <h4 class="text-center mt-5 text-primary code-title mb-5">Class Code</h4>
                <div id="class-code" class="text-center my-3 class-code text-black border border-2 rounded">00000000</div>
                <div id="countdown">
                    <div id="countdown-number"></div>
                    <svg>
                        <circle r="18" cx="20" cy="20" id="circle"></circle>
                    </svg>
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

            <div class="popup flex-column w-auto p-4" id="edit-popup">
                <h3 class="text-center text-primary mb-4">Edit Time Slot Information</h3>
                <div class="d-flex justify-content-center align-items-center flex-column text-primary">
                    <div class="d-flex flex-column mb-3">
                        <h4>Start Time</h4>
                        <input class="flex-fill form-control" id="start-time" type="time" value="<?php echo $timeSlotInfo["start_time"]?>" />
                    </div>
                    <div class="d-flex  flex-column mb-3">
                        <h4>End Time</h4>
                        <input class="flex-fill form-control" id="end-time" type="time" value="<?php echo $timeSlotInfo["end_time"]?>" />
                    </div>
                    <div class="d-flex  flex-column mb-3">
                        <h4>Date</h4>
                        <input class="flex-fill form-control" id="date" type="date" value="<?php echo $timeSlotInfo["date"]?>" />
                    </div>
                    <div class="d-flex  flex-column mb-3">
                        <h4>Location</h4>
                        <select id="location_select" class="flex-fill form-select">
                            <?php 
                            for($i=0;$i<sizeof($locations);$i++){
                                $selected = "";
                                $location = $locations[$i];
                                if($timeSlotInfo["location_id"] == $location["location_id"]){
                                    $selected = "selected";
                                }
                                $optionElement = '<option %s value="%s">%s</option>';
                                echo sprintf($optionElement, 
                                    $selected,
                                    $location["location_id"],
                                    $location["location_name"]
                                );
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex  flex-column mb-4">
                        <h4>Type</h4>
                        <input class ="form-control flex-fill" id="type" type="text" value="<?php echo $timeSlotInfo["type"]?>" />
                    </div>
                </div>
                <div class="button-container">
                    <button class="btn btn-danger cancel" >Cancel</button>
                    <button class="btn btn-success" id="editYesBtn">Edit</button>
                </div>
            </div>

        </div>


        <?php include($nav_path); ?>


        <div class="d-flex pb-2 pt-2 px-1 bg-custom sticky-top gap-2">
            <!-- Left-aligned buttons - takes up 1/3 of the width -->
            <div class="col-md-4 d-flex gap-2" role="group">
                <button type="button" class="btn btn-success" id="attend-btn">Mark as Attended</button>
                <button type="button" class="btn btn-danger" id="deselect-btn">Deselect all</button>
                <button type="button" class="btn btn-danger" id="select-btn">Select all</button>
            </div>

            <!-- Center-aligned button - takes up 1/3 of the width -->
            <div class="col-md-4 d-flex justify-content-center" role="group">
                <button type="button" class="btn btn-info" id="codeShow">Show Code</button>
            </div>

            <!-- Right-aligned buttons - takes up 1/3 of the width -->
            <div class="col-md-4 d-flex gap-2 justify-content-end" role="group">
                <button type="button" class="btn btn-warning edit-btn" id="edit-info">Edit Event</button>
            </div>
        </div>


        <div class="d-flex bg-white justify-content-center align-items-center text-primary mt-5 mb-4 selected-count"><h2> Selected Users:&nbsp; <h2 id="selected_count">0</h2></h2></div>

<div class="d-flex justify-content-center align-items-center flex-wrap">
    <?php 
    for($i=0;$i<sizeof($result);$i++){
        if($result[$i]["status"] == "Staff"){
            // We have reached the staff so there are no more students to show
            break;
        }

        // Add user information 
        $temp_div = '
        <div id="userContainer%s" class="card class-block my-4 mx-2" style="width: 18rem; cursor: pointer;" data-user-id="%s">
            <img src="%s" alt="%s" class="card-img-top smallpfp">
            <div class="card-body">
                <h5 class="card-title text-center"><b>%s</b></h5>
                <h6 class="card-subtitle mb-2 text-muted text-center">%s</h6>
                <p class="card-text text-center status">%s</p>
                <div class="btn-list d-flex justify-content-center gap-3">
                     <button id="Attended" title="Mark as on time" class="btn btn-primary"><i class="fa fa-check staff-icons" style="color:#32cd32;" aria-hidden="true"></i></button>
                     <button id="Late" title="Mark as late" class="btn btn-primary"><i class="fa-solid fa-clock staff-icons" style="color:orange;"></i></button>
                     <button id="Missed" title="Mark as absent" class="btn btn-primary"><i class="fa fa-times staff-icons" style="color:red;"></i></button>
                </div>
            </div>
        </div>
        '; 
        echo sprintf($temp_div, 
            $result[$i]["user_id"], 
            $result[$i]["user_id"], 
            $result[$i]["file_loc"], 
            $result[$i]["name"], 
            $result[$i]["name"], 
            ucfirst($result[$i]["email"]), 
            ucfirst($result[$i]["status"]),
            $result[$i]["user_id"], 
            $result[$i]["user_id"], 

        );
    }
    ?>
</div>
        <?php include("../php/template/footer.php"); ?>
        <script src="./staffEvent.js"></script>
    </body>
</html>
