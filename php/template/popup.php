<?php 
$user = unserialize($_SESSION["user"]);
?>


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
<div id="attend-popup" class="attend-popup" >
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
                    <?php if(!$user->isLocationOpt()):?>
                    <div class="d-inline-block" tabindex="0" data-toggle="tooltip" 
                        data-placement="bottom" title="You have disabled location monitoring in settings." style="cursor: help;">
                        <button type="button" id="loc-button" class="btn btn-warning" 
                            style="pointer-events: none;" disabled="true">
                            Location
                        </button>
                    </div>
                    <script>
                    $(document).ready(function() {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                    </script>

                    <?php else: ?>
                        <button class="btn btn-secondary" id="loc-button" >Location</button>
                    <?php endif ?>
                    <button class="btn btn-light" id="code-button">Enter Code</button>
                </div>
            </div>      

            <div class="d-flex justify-content-center attend-image mb-4" id="attend-image">
                <img src="../images/map.png" alt="">
            </div>
            <div class="row attend-code-block mb-4 d-none" id="code-block">
                <input type="number" class="form-control form-control-lg attend-code" placeholder="Enter Class Code..." id="attendCode">
            </div>
            <div class="row mt-5 pt-3">
                <div class="col-lg-6 mb-3 attend-class-code d-flex flex-column align-items-center justify-content-center">
                    <h3 class="attend-details-title">Class</h3>
                    <h4 class="attend-details-content">COMP10120</h4>
                </div>
                <div class="col-lg-6 mb-3 attend-class-time d-flex flex-column align-items-center justify-content-center">
                    <h3 class="attend-details-title">Time</h3>
                    <h4 class="attend-details-content">10:00 - 11:00</h4>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-6 mb-3 attend-class-loc d-flex flex-column align-items-center justify-content-center">
                    <h3 class="attend-details-title">Location</h3>
                    <h4 class="attend-details-content">Kilburn TH 1.1</h4>
                </div>
                <div class="col-lg-6 mb-3 attend-class-instructor d-flex flex-column align-items-center justify-content-center">
                    <h3 class="attend-details-title">Instructor</h3>
                    <h4 class="attend-details-content">Mr. Walter White</h4>
                </div>
            </div>
            <div class="attendance-control d-flex align-items-center justify-content-center gap-3 mt-5">
                <button class="btn btn-danger" id="cancel">Cancel</button>
                <button class="btn btn-success">Proceed</button>
            </div>
        </div>
    </div>
</div>
