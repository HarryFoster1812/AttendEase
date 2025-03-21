<?php

require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

$error_msg = "";

if(isset($_SESSION["user"])){
    header("Location:../dashboard/");
}

?>

<html lang="en">
    <head>
        <title>Forgot Password | AttendEase</title>
        <?php 
        include("../php/template/header.php");
        ?>

        <style>
        /* Make sure the entire view height is used */
        .min-vh-100 {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f4f4f9; /* Light background for a clean look */
        }

        /* Center the carousel and set the max width */
        .carousel {
        width: 100%;
        max-width: 600px; /* Restrict max width of the carousel */
        }

        /* Make the carousel items look nice */
        .carousel-item {
        text-align: center;
        padding: 20px;
        }

        .carousel-item h1, .carousel-item h2 {
        margin-bottom: 20px;
        color: #333;
        }

        /* Styling for input and textarea */
        input, textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        }

        /* Improve the look of the button */
        .btn-success {
        width: 100%;
        padding: 10px;
        font-size: 1.1rem;
        margin-top: 10px;
        border-radius: 5px;
        cursor: pointer;
        }

        /* Error message styling */
        .d-none {
        display: none;
        }

        small {
        display: block;
        margin-top: 10px;
        font-size: 0.9rem;
        }

        /* Disable the continue button initially */
        #slide2:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        }

        /* Styling for carousel indicators */
        .carousel-indicators {
        bottom: -30px; /* Adjust position of indicators */
        }
        </style>


    </head>
    <body>
        <?php 
        include("../php/template/navbar.php");
        ?>

        <div class="min-vh-100 w-100">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h1>Please enter your email or username</h1>
                        <input placeholder="Enter Here" id="inputEmail" type="text">
                        <small id="errorMessage" style="color:red;" class="d-none">No user found. Please check the information entered</small>
                        <button class="btn btn-success" type="button" id="slide1"  disabled> Continue </button>
                    </div>
                    <div class="carousel-item">
                        <h2>Please tell us some information so we can confirm your identity</h2>
                        <textarea placeholder="Enter Here" id="inputInfo"></textarea>
                        <button class="btn btn-success" type="button" id="slide2" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" disabled> Continue </button>
                    </div>
                    <div class="carousel-item">
                        <h1>Request Sent!</h1>
                        <h2>We have sent your password reset request to your local administrator.</h2>
                    </div>
                </div>
            </div>
        </div>

        <?php include("../php/template/footer.php"); ?>
        <script src="./script.js"></script>
    </body>
</html>

