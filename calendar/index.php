<?php 

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
    <title>AttendEase | Calendar</title>
    <?php include("../php/template/header.php"); ?>
    <link rel="stylesheet" href="css/calendar.css">

</head>
<body>
    
    <?php 
        echo $error;
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
                            <td></td>
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
                <table class="table table-default align-middle table-fixed" id="timetable">

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
        </div>
    </section>

    <?php include("../php/template/footer.php"); ?>
    <script src="/js/date.js"></script>
    <script src="/calendar/calendar.js"></script>

</body>
</html>