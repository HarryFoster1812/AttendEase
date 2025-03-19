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


$tables = $db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE :dbName ORDER BY TABLE_NAME ;" , [":dbName" => $db->getDbname()]);

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
        <?php    
        if(isset($_COOKIE["darkMode"])){
            echo '<link rel="stylesheet" id="darkstylesheet" href="../css/admin_dark.css">';
        }
    ?>
    </head>
    <body>
        <template id="itemTemplate"><a href="" style="text-decoration:none" target="_blank" rel="noopener noreferrer" class="">
                <div class="course-container">
                    <h3 id="text-shown"> COMP11120 - Mathematical Techniques for Computer Science</h3>
                    <button class="btn btn-primary expand-button">
                        <i class="fa-solid fa-up-right-from-square"></i>
                    </button>
                </div>
            </a></template>

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

        <div class="d-flex flex-column align-items-center justify-content-center mt-5">
            <a class="btn btn-success " href="../database-edit/">Show Database</a>
        </div>

        <div class="container my-5 courseList overflow-scroll accordion border border-4 border-secondary ">

            <?php 
            // NOTE: do not remove the class searchResult from the collapse div. The js needs it
            for($i=0;$i<sizeof($tables);$i++){
            $tableName = $tables[$i]["TABLE_NAME"];
            $content = '
            <div id="'.$tableName.'Containers" class="my-4 accordion-item custom-accordion">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'.$tableName.'Collapse" aria-expanded="false" aria-controls="'.$tableName.'Collapse">
                        '.$tableName.' 
                    </button>
                </h2>

                <div id="'.$tableName.'Collapse" class="collapse searchResult">
                </div>      
            </div>
            ';
            echo $content;
            }

            ?>

            

        </div>

        <div class="d-flex flex-column align-items-center justify-content-center my-5">
            <a class="btn btn-success " href="../database-edit/?table=ChangeRequests">Show Change Requests</a>
        </div>


        <?php include("../php/template/footer.php"); ?>
        <script src="./admin.js"></script>
    </body>
</html>
