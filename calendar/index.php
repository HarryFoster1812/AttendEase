<?php 

session_start();

if(isset($_SESSION["navbar"])){
    $header_path = "../php/template" . $_SESSION["navbar"];
}

else{
    header("Location:../");
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>AttendEase | Calendar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Convergence&display=swap" rel="stylesheet">

</head>
<body>
    <nav class="p-3 navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand mb-0 text-secondary">AttendEase</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#attendnav">
            <span class="navbar-toggler-icon text-secondary"></span>
        </button>
        <div class="collapse navbar-collapse" id="attendnav">
            <ul class="navbar-nav ms-auto text-secondary">
                <li class="nav-item active px-1">
                    <a href="#" class="nav-link">Admin</a>
                </li>
                <li class="nav-item px-1">
                    <a href="#" class="nav-link">Settings</a>
                </li>
                <li class="nav-item px-1">
                    <a href="#" class="nav-link">Statistics</a>
                </li>
                <li class="nav-item px-1">
                    <a href="#" class="nav-link">Leaderboards</a>
                </li>
                <li class="nav-item px-1">
                    <a href="#" class="nav-link">Calendar</a>
                </li>
                <li class="nav-item px-1">
                    <a href="#" class="nav-link">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>
    <section id="calendar-header">
        <div class="custom-container">
            <div class="row mt-5 pt-4">
                <div class="col-12 col-lg-4 d-flex justify-content-center justify-content-lg-start mb-4">
                    <div class="btn-group rounded-pill time-select" role="group">
                        <button class="btn btn-secondary border-dark rounded-start-pill px-3">Today</button>
                        <button class="btn btn-light border-dark px-3"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="btn btn-light border-dark rounded-end-circle px-3"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-flex justify-content-center mb-4">
                    <h2 class="fs-2 text-center text-primary">19-25 Sep 2024</h2>
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

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="bootstrap/dist/js/bootstrap.js"></script>
    <script src="js/calendar.js"></script>

</body>
</html>