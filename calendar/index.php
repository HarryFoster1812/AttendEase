<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calendar | AttendEase</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="../css/calendar.css">
<?php    
if(isset($_COOKIE["darkMode"])){
    echo '<link rel="stylesheet" id="darkstylesheet" href="../css/calendar_dark.css">';
}

?>
</head>
<body>
    <template id="class-ui">
        <div class="class-block my-2">
            <div class="class-head">
                <div class="class-time-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="class-time">
                    <h6 class="class-time-text"><b>09:00-10:00</b></h6>
                </div>
            </div>
            <div class="class-body">
                <h5 class="class-title">COMP10120 Tutorial</h5>
                <h5 class="class-loc">IT-407 Kilburn</h5>
            </div>
        </div>
    </template>
    <template id="nav-fail">
        <div class="nav-box-fail p-2 m-1 border border-2 border-danger rounded-3">
            <h5 class="text-danger fw-bold">Could not mark your attendance, please try again!</h4>
            <p class="text-danger">We could not mark your attendance. This is because either you are not in the assigned room or our geoloction detector has failed its purpose. If this issue persists, please contact AttendEase.</p>
        </div>
     </template>
     <template id="nav-success">
        <div class="nav-box-success p-2 m-1 border border-2 border-success rounded-3">
            <h5 class="text-success fw-bold">Marked your attendance!</h4>
            <p class="text-success">Your attendance for this class has been successfully marked!</p>
        </div>
     </template>
     <div class="attend-backdrop d-none justify-content-center align-items-center">
        <div class="attend-popup">
            <div class="container px-5 py-4">
                <div class="d-flex justify-content-end mb-2">
                    <div class="attend-close-icon">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="d-flex mb-3 justify-content-center">
                    <div class="">
                        <h2>Mark Your Attendance!</h2>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group rounded-pill">
                        <button class="btn btn-secondary" id="loc-button">Location</button>
                        <button class="btn btn-light" id="code-button">Enter Code</button>
                    </div>
                </div>      
                    
                <div class="d-flex justify-content-center attend-image mb-4" id="attend-image">
                    <img src="../images/map.png" alt="">
                </div>
                <div class="row attend-code-block mb-4 d-none" id="code-block">
                    <form action="">
                        <input type="text" class="form-control form-control-lg attend-code" placeholder="Enter Class Code..." id="attend-code">
                    </form>
                </div>
                <div class="row mt-5 pt-3">
                    <div class="col-lg-6 mb-3 attend-class-code">
                        <h3 class="attend-details-title">Class</h3>
                        <h4 class="attend-details-content">COMP10120</h4>
                    </div>
                    <div class="col-lg-6 mb-3 attend-class-time">
                        <h3 class="attend-details-title">Time</h3>
                        <h4 class="attend-details-content">10:00 - 11:00</h4>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3 attend-class-loc">
                        <h3 class="attend-details-title">Location</h3>
                        <h4 class="attend-details-content">Kilburn TH 1.1</h4>
                    </div>
                    <div class="col-lg-6 mb-3 attend-class-instructor">
                        <h3 class="attend-details-title">Instructor</h3>
                        <h4 class="attend-details-content">Mr. Walter White</h4>
                    </div>
                </div>
                <div class="attendance-control d-flex justify-content-end gap-3 mt-5">
                    <button class="btn btn-light">Cancel</button>
                    <button class="btn btn-success">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        include($nav_path);
    ?>
    <section id="calendar-header">
        <div class="custom-container">
            <div class="row mt-5 pt-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center justify-content-lg-start mb-4">
                    <div class="btn-group rounded-pill time-select" role="group">
                        <input class="btn btn-secondary border-dark rounded-start-pill px-3" type="date" id="datepicker"/>
                        <button class="btn btn-light border-dark px-3" id="date_back"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="btn btn-light border-dark rounded-end-circle px-3" id="date_forward"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex justify-content-center mb-4">
                    <h2 class="fs-2 text-center text-primary" id="date">19-25 Sep 2024</h2>
                </div>
                <div class="col-12 col-lg-4 d-flex justify-content-center justify-content-lg-end mb-4">
                    <div class="btn-group rounded-pill time-select" role="group">
                        <button class="btn btn-secondary border-dark px-3 time-button" onclick="switchTable('day')" id="button-day">Day</button>
                        <button class="btn btn-light border-dark px-3 time-button" onclick="switchTable('week')" id="button-week">Week</button>
                        <button class="btn btn-light border-dark px-3 time-button" onclick="switchTable('month')" id="button-month">Month</button>
                    </div>
                </div>
            </div>
            <hr class="border-primary my-4 border-3 calendar-divider">
        </div>

    </section>
    <section class="timetable mt-4">
        <div class="custom-container">
            <div class="d-flex justify-content-end my-4">
                <h2 class="fs-3 me-3 text-primary">Default</h2>
                <label class="switch">
                    <input type="checkbox" id="table_slider" onclick="switchBackground()">
                    <span class="slider"></span>
                  </label>
                <h2 class="fs-3 ms-3 text-primary">Dynamic</h2>
            </div>
            <div class="table-responsive-lg d-none" id="timetable-week">
                <table class="table table-default align-middle table-fixed">

                    <thead class="table-header">
                        <tr>
                            <th scope="col" class="text-center fs-2 table-title"></th>
                            <th scope="col" class="text-center fs-2">Mon<br>19</th>
                            <th scope="col" class="text-center fs-2">Tue<br>20</th>
                            <th scope="col" class="text-center fs-2">Wed<br>21</th>
                            <th scope="col" class="text-center fs-2">Thu<br>22</th>
                            <th scope="col" class="text-center fs-2">Fri<br>23</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="fs-2 px-3">08:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">09:00</th>
                            <td>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">10:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">11:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">12:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">13:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">14:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">15:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">16:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">17:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">18:00</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody> 
                </table>
            </div>
            <div class="table-responsive-lg" id="timetable-day">
                <table class="table table-default align-middle table-fixed">

                    <thead class="table-header">
                        <tr>
                            <th scope="col" class="text-center fs-2 table-title"></th>
                            <th scope="col" class="text-center fs-2">Mon<br>19</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="fs-2 px-3">08:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">09:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">10:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">11:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">12:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">13:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">14:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">15:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">16:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">17:00</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" class="fs-2 px-3">18:00</th>
                            <td></td>
                        </tr>
                    </tbody> 
                </table>
            </div>
            <div class="table-responsive-lg d-none" id="timetable-month">
                <table class="table table-default table-fixed">

                    <thead class="table-header">
                        <tr>
                            <th scope="col" class="text-center fs-2">Monday</th>
                            <th scope="col" class="text-center fs-2">Tuesday</th>
                            <th scope="col" class="text-center fs-2">Wednesday</th>
                            <th scope="col" class="text-center fs-2">Thursday</th>
                            <th scope="col" class="text-center fs-2">Friday</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                            <td>
                                <div class="calendar-date"></div>
                                <div class="calendar-content"></div>
                            </td>
                        </tr>

                    </tbody> 
                </table>
            </div>
        </div>
    </section>

    <?php include("../php/template/footer.php"); ?>
    <script src="../js/date.js"></script>
    <script src="./calendar.js"></script>
    <script src="../js/attend.js"></script>

</body>
</html>
