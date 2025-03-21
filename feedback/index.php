<?php
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = (string) file_get_contents("php://input");
    parse_str($data, $parsedData);
    file_put_contents("./feedback.txt", date("Y-m-d H:i:s")."\n".print_r($parsedData, true)."\n\n", FILE_APPEND | LOCK_EX);
    $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">Feedback sent successfully! Thank you for your time.<button type="button" class="close" data-dismiss="alert" aria-label="Close">  <span aria-hidden="true">&times;</span></button></div>';
}

?>

<html lang="en">
<head>
    <title>Feedback | AttendEase</title>
    <link rel="stylesheet" href="./feedback.css">
    <?php 
        include("../php/template/header.php");
        
        ?>
</head>
<body>
    <?php 
        echo $msg;
        include("../php/template/navbar.php");
    ?>

<div class="container mt-5 formbackground">
        <header class="text-center mb-4">
            <h1>Feedback</h1>
            <p>Thank you for using AttendEase! Your feedback helps us improve the app to better meet your needs.</p>
        </header>

        <hr>

        <main>
            <form action="" method="POST">
                <!-- Rating Section -->
                <div class="mb-4">
                    <h4>How was your experience?</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" id="rating-excellent" value="Excellent">
                        <label class="form-check-label" for="rating-excellent">Excellent</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" id="rating-good" value="Good">
                        <label class="form-check-label" for="rating-good">Good</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" id="rating-average" value="Average">
                        <label class="form-check-label" for="rating-average">Average</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" id="rating-poor" value="Poor">
                        <label class="form-check-label" for="rating-poor">Poor</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rating" id="rating-very-poor" value="Very Poor">
                        <label class="form-check-label" for="rating-very-poor">Very Poor</label>
                    </div>
                </div>

                <!-- Liked Most Section -->
                <div class="mb-4">
                    <h4>What did you like most about AttendEase?</h4>
                    <textarea class="form-control" name="liked-most" rows="4" placeholder="Please share what worked well for you."></textarea>
                </div>

                <!-- Improvements Section -->
                <div class="mb-4">
                    <h4>What could be improved?</h4>
                    <textarea class="form-control" name="improvement-suggestions" rows="4" placeholder="Please share any suggestions for improvement."></textarea>
                </div>

                <!-- Issues Section -->
                <div class="mb-4">
                    <h4>Did you encounter any issues?</h4>
                    <textarea class="form-control" name="issues-encountered" rows="4" placeholder="Please describe any issues you encountered."></textarea>
                </div>

                <!-- Assistance Section -->
                <div class="mb-4">
                    <h4>How can we assist you further?</h4>
                    <textarea class="form-control" name="assistance-request" rows="4" placeholder="Feel free to let us know if you need support."></textarea>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </form>
        </main>

        <footer class="text-center mt-4">
            <p>Thank you for your feedback! Your responses will help us improve AttendEase.</p>
        </footer>
    </div>


<?php 
        include("../php/template/footer.php");
    ?>

</body>
</html>
