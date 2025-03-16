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
    <link rel="stylesheet" href="../css/attend.css">
    <link rel="stylesheet" href="../staff-event/staffEvent.css">
<?php    
if(isset($_COOKIE["darkMode"])){
    echo '<link rel="stylesheet" id="darkstylesheet" href="../css/calendar_dark.css">';
}

?>
</head>
<body>
    <template id="class-ui">
        <div class="class-block my-2" data-bs-toggle="popover">
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
    <template id="request-fail">
            <div class="nav-box-fail p-2 m-1 border border-2 border-danger rounded-3">
                <h5 class="text-danger fw-bold" id="title">Can not make an absence request!</h5>
                    <p class="text-danger" id="message">Unable to create an absence request. This is because you have already marked your attendance for this session.</p>
            </div>
        </template>
    <template id="request-success">
        <div class="nav-box-success p-2 m-1 border border-2 border-success rounded-3">
            <h5 class="text-success fw-bold">Succesfully created an absence request!</h4>
                <p class="text-success">You have been marked as absent for this session. If you do attend this session, please contact your lecturer!</p>
        </div>
    </template>

    <div id="overlay" class="overlay hidden">
            
            <div class="popup flex-column" id="absence-popup">
                <h4 class="text-center mt-3 text-black code-title mb-4 border-bottom border-2 pb-2">Confirm absence request?</h4>
                <h5 class="text-black pb-3 text-start"><b class="text-danger">Warning:</b> You will not be able to check in to your session if you do attend. If you do attend this session, either contact your lecturer directly or make an appeal after the session.</h5>
                <div class="d-flex justify-content-end border-top border-2 mt-4 gap-2 pt-3">
                    <button class="btn btn-danger" onclick="hidePopup()">Cancel</button>
                    <button class="btn btn-success" onclick="publishAbsence()">Proceed</button>
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
        </div>

    <?php
        include($nav_path);
    ?>

    <?php include("../php/template/popup.php"); ?>
    <section id="calendar-header">
        <div class="custom-container">
            <div class="row mt-5 pt-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center justify-content-lg-start mb-4">
                    <div class="btn-group rounded-pill time-select" role="group">
                        <input class="btn btn-secondary border-dark rounded-start-pill px-3 text-primary" type="date" id="datepicker"/>
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
    <script src="../staff-event/staffEvent.js"></script>

</body>
</html>
