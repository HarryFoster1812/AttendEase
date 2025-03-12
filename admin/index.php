<?php 
require_once "../autoload.php";
require_once "../php/db.php";

UrlHelper::enforceTrailingSlash();

session_start();

$user = unserialize($_SESSION["user"]);

if($user->getRoleId() == 3){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../access-denied/");
}
?>

<!--
WHAT YOU CAN SEARCH FOR: 

A specific user (Dependent on if they are a staff / Student  (add a course assignment section))
A specific timeslot (opening in the staff-edit page)
A course
A location

Attendance page (for a specific user)


AMBITIOUS: add a todo-list via the request data edit?


Database-Page (add new items / delete items)

-->


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | AttendEase</title>
        <?php include("../php/template/header.php"); ?>
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href="../css/custom.css">
    </head>
    <body>
        <template id="itemTemplate">
            <a href="" style="text-decoration:none" target="_blank" rel="noopener noreferrer" class="">

                <div class="course-container">
                    <h3> COMP11120 - Mathematical Techniques for Computer Science</h3>
                    <button class="btn btn-primary expand-button">
                        <i class="fa-solid fa-up-right-from-square"></i>
                    </button>
                </div>
            </a>

        </template>

        <?php include($nav_path);?>
        <div class="container mt-4">
            <div class="search-filter-container">
                <!-- Search Bar Container -->
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <input id="searchbar" type="text" class="form-control search-input" placeholder="Search...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                <!-- Checkboxes Container -->

            </div>
        </div>

        <div class="container my-5 courseList overflow-scroll accordion ">


            <div id="usersContainers" class="my-4 accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#UserCollapse" aria-expanded="true" aria-controls="UserCollapse">
                        Users 
                    </button>
                </h2>

                <div id="UserCollapse" class="  collapse ">
                </div>      
            </div>


            <div id="timeslotContainer" class="my-4 accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#TimeslotCollapse" aria-expanded="true" aria-controls="UserCollapse">
                        Time Slots 
                    </button>
                </h2>

                <div id="TimeslotCollapse" class=" accordion-collapse collapse ">
                </div>      
            </div>


            <div id="locationContainer" class="my-4 accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#LocationCollapse" aria-expanded="true" aria-controls="UserCollapse">
                        Locations 
                    </button>
                </h2>

                <div id="LocationCollapse" class=" accordion-collapse collapse ">
                </div>      
            </div>

            <div id="courseContainers" class="my-4 accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#CourseCollapse" aria-expanded="true" aria-controls="UserCollapse">
                        Course 
                    </button>
                </h2>

                <div id="CourseCollapse" class=" accordion-collapse collapse ">
                </div>      
            </div>
        </div>

        <?php include("../php/template/footer.php"); ?>
        <script src="./admin.js"></script>
    </body>
</html>
