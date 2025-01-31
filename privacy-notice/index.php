<?php

session_start();

?>

<html lang="en">
<head>
    <title>Privacy Policy | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        
        ?>

    <link rel="stylesheet" href="../signup/signup.css">
    
</head>
<body>
<?php 
    include("../php/template/navbar.php"); 
    ?>
    <section class="signup-form">
        <div class="overlay d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-xl-6 mx-auto sign-up-box p-4">
                        <div class="container">
                            <div class="row mt-4">
                                <h1 class="display-6 text-center">Sign Up For AttendEase</h1>
                            </div>
                            <hr class="my-4 border-3 border-secondary signup-divider">
                            <form action="php/signup.php" method="post">
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter your username..." name="username">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Email Address <span class="email-small">(University Email)</span></label>
                                        <input type="email" class="form-control" id="username" placeholder="Enter your university email..." name="email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="user_pass" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="user_pass" placeholder="Enter your password..." name="password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="toggle_pass" onclick="togglePassword">
                                            <label for="toggle_pass" class="form-label">Show Password</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row align-self-center">
                                <div class="mb-4 d-grid col-12 mx-auto">
                                    <button class="btn submit border-secondary" data-bs-target="#privacy" data-bs-toggle="modal">Register</button>
                                </div>
                            </div>
                            <hr class="my-4 border-3 border-secondary signup-divider">
                            <div class="row my-4">
                                <div class="col-8 mx-auto d-grid mt-3">
                                    <a href="index.html" class="logup d-grid">
                                        <button class="btn misc-buttons border-secondary">Log In</button>
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="privacy" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-3 text-primary">Our Privacy Policy</h1>
                </div>
                <div class="modal-body text-primary">
                    <div class="accordion accordion-flush">
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_1">
                                    1. Introduction
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_1">
                                <div class="accordion-body fs-6">This privacy notice explains how your personal data is collected, used, and stored by AttendEase, a university project designed to verify attendance using location-based checks. By using the app, you agree to the collection and processing of your personal data as described in this notice.</div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_2">
                                    2. Data Collected
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_2">
                                <div class="accordion-body fs-6">
                                    We collect and use the following types of data:
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Geolocation Data: </b></span>At the time of attendance logging, the app collects your geolocation (latitude and longitude) to verify your presence at the correct event location. This data is only used for the purpose of validating attendance and is never stored after the verification process.</li>
                                        <li><span><b>Event Location Data: </b></span>We store the location data for each event (latitude, longitude, and address) in our system. This data is used solely for confirming the location of the event to ensure accurate attendance verification.</li>
                                        <li><span><b>Personal Data: </b></span>We store personal information such as your username, password (hashed and salted), email address, and role within the app (student, lecturer, or admin). This information is used to manage your account and grant appropriate permissions based on your role.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_3">
                                    3. User Eligibility
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_3">
                                <div class="accordion-body fs-6">
                                    The data we collect is used for the following purposes:
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Attendance Verification: </b></span>Your geolocation data is used only at the time of attempting to log attendance, to verify that you are present at the event location.</li>
                                        <li><span><b>Event Location Management: </b></span>We store event location data to ensure that the location used for attendance matches the verified location at the time of the event.</li>
                                        <li><span><b>User Account Management: </b></span>Your personal information (username, email, role) is stored to manage your account and provide access to appropriate features within the app.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_4">
                                    4. Data Storage and Retention
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_4">
                                <div class="accordion-body fs-6">
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Geolocation Data: </b></span>Your geolocation data is never stored. It is only used temporarily at the time of attendance verification and is discarded immediately after validation.</li>
                                        <li><span><b>Event Location Data: </b></span>Event location data is stored in the database, linked to specific courses and timeslots, and used for the purpose of verifying attendance. This data will be retained as long as it is necessary for course management and attendance purposes.</li>
                                        <li><span><b>Personal Data: </b></span>Your account data, including username, password (hashed), and email, is stored securely in our system for as long as your account is active. If you choose to delete your account, this data will be removed as per your request.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_5">
                                    5. Security Measures
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_5">
                                <div class="accordion-body fs-6">
                                    We implement robust security measures to protect your data, including:
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Encryption: </b></span>Personal data and event location data are protected using encryption during transmission (HTTPS).</li>
                                        <li><span><b>Access Control: </b></span>Access to sensitive data, including attendance records and event location information, is restricted to authorized personnel based on user roles (e.g., students, lecturers, administrators).</li>
                                        <li><span><b>Password Security: </b></span>All passwords are securely hashed and salted before being stored, and only authorized users can access their own account information.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_6">
                                    6. User Rights
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_6">
                                <div class="accordion-body fs-6">
                                    Under applicable data protection laws (e.g., GDPR), you have the following rights regarding your personal data:
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Right to Access: </b></span>You have the right to request a copy of the personal data we hold about you, which includes your user account data (username, email) and event location data used for attendance verification.</li>
                                        <li><span><b>Right to Rectification: </b></span>If any of your personal data is inaccurate or incomplete, you have the right to request corrections.</li>
                                        <li><span><b>Right to Deletion: </b></span>You can request the deletion of your account and associated data. Please note that once deleted, your data will no longer be retrievable.</li>
                                        <li><span><b>Right to Restrict Processing: </b></span>You can request that we restrict processing of your personal data, except for the purposes of legal obligations or legitimate interests.</li>
                                    </ul>
                                    If you do not wish to have your geolocation used for attendance verification, please contact your instructor to arrange an alternative method of verifying your attendance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_7">
                                    7. Sharing of Data
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_7">
                                <div class="accordion-body fs-6">We do not share your personal data, including your geolocation data, with third parties. The event location data is only accessible to authorized personnel, such as lecturers and administrators, who manage courses and attendance.</div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_8">
                                    8. Changes to This Privacy Notice
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_8">
                                <div class="accordion-body fs-6">This privacy notice may be updated periodically. Any changes will be communicated to you via the app or through email. We encourage you to review this notice regularly to stay informed about how we are protecting your personal data.</div>
                            </div>
                        </div>
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_9">
                                    9. Contact Information
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_9">
                                <div class="accordion-body fs-6">If you have any questions or concerns about this privacy notice or how your data is handled, please contact:<br><br>
                                    The AttendEase Team<br>
                                    devteam@AttendEase.edu.co.uk</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <?php 
    include("../php/template/footer.php"); 
    ?>
</body>
</html>

