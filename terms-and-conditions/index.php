<?php

require_once "autoload.php";

UrlHelper::enforceTrailingSlash();


session_start();

?>

<html lang="en">
<head>
    <title>Terms and Conditions | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        
        ?>

    <link rel="stylesheet" href="../signup/signup.css">
    
</head>
<body>

    <?php 
        include("../php/template/navbar.php");
    ?>

    <br>

    <div id="privacy" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-3 text-primary">Terms and Conditions for AttendEase</h6>
                </div>
                <div class="modal-body text-primary">
                    <div class="accordion accordion-flush">
                        
                        <div class="accordion-item text-primary show">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_1">
                                    1. Introduction
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_1">
                                <div class="accordion-body fs-6">Welcome to AttendEase, an attendance tracking app designed for use at the University of Manchester. By using AttendEase, you agree to the following Terms and Conditions. Please read them carefully. If you do not agree to these terms, you may not use the app.</div>
                            </div>
                        </div>
                        
                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_2">
                                    2. Purpose and Scope
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_2">
                                <div class="accordion-body fs-6">
                                AttendEase is intended to:
                                <ul class="accordion-bullets my-3">
                                        <li>Facilitate attendance tracking for students, lecturers, and administrators.</li>
                                        <li>Improve academic record management by providing an efficient and transparent attendance logging system.</li>
                                </ul>
                                AttendEase is for university-related activities only and must not be used for any commercial or non-academic purposes.
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
                                AttendEase is available to:
                                    <ul class="accordion-bullets my-3">
                                        <li>Students enrolled at the University of Manchester.</li>
                                        <li>Lecturers and staff affiliated with the university.</li>
                                        <li>Administrators authorized to manage attendance records.</li>
                                    </ul>
                                    Users must be provided with unique credentials to access the app. Sharing or misusing credentials is strictly prohibited.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_4">
                                    4. User Obligations
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_4">
                                <div class="accordion-body fs-6">
                                By using AttendEase, you agree to:
                                    <ol type="I">
                                        <li>
                                            Provide Accurate Information:
                                            <ul class="accordion-bullets my-3">
                                                <li>Users must ensure that all attendance logs reflect their actual presence at the required location.</li>
                                                <li>Falsifying attendance records, attempting to log attendance for others, or tampering with app features is strictly forbidden.</li>
                                            </ul>
                                        </li>

                                        <li>
                                            Maintain Account Security:
                                            <ul class="accordion-bullets my-3">
                                                <li>Users are responsible for safeguarding their account credentials.</li>
                                                <li>Any unauthorized access must be reported immediately to the university IT team.</li>
                                            </ul>
                                        </li>

                                        <li>
                                            Abide by University Policies and Laws:
                                            <ul class="accordion-bullets my-3">
                                                <li>Usage must comply with university guidelines and relevant laws, including the UK General Data Protection Regulation (UK GDPR).</li>
                                            </ul>
                                        </li>

                                        <li>
                                            Respect System Integrity:
                                            <ul class="accordion-bullets my-3">
                                                <li>Users may not interfere with or disrupt the app’s normal functionality.<li>
                                            </ul>
                                        </li>
                                    </ol>

                                    Users must be provided with unique credentials to access the app. Sharing or misusing credentials is strictly prohibited.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_5">
                                    5. Geolocation Feature
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_5">
                                <div class="accordion-body fs-6">
                                AttendEase uses geolocation technology to validate attendance. The following terms apply:
                                    <ul class="accordion-bullets my-3">
                                        <li><span><b>Purpose of Geolocation:</b></span> Geolocation data is used solely to confirm a user’s physical presence at the designated event location at the time of logging attendance.</li>
                                        <li><span><b>Data Usage:</b></span> Geolocation data is processed in real time and is not stored in the app’s database.</li>
                                        <li><span><b>Opt-Out Option:</b></span> Users may opt out of using geolocation services via their app settings. However, opting out may result in limited functionality, including the inability to log attendance through AttendEase.</li>
                                        <li><span><b>User Consent:</b></span>By using the app’s geolocation feature, you consent to the temporary processing of your location data for attendance validation purposes.</li>
                                    </ul>
                                    Users must be provided with unique credentials to access the app. Sharing or misusing credentials is strictly prohibited.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_6">
                                    6. Data Collection and Privacy
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_6">
                                <div class="accordion-body fs-6">
                                    AttendEase is committed to protecting user data.
                                    <ol type="I">
                                        <li>
                                            What Data is Collected:
                                            <ul class="accordion-bullets my-3">
                                                <li>User details: username, email, role (e.g., student, lecturer).</li>
                                                <li>Attendance records: attendance status, associated courses, times, and dates.</li>
                                                <li>Event details: location names, dates, and times.</li>
                                            </ul>
                                        </li>

                                        <li>
                                            How Data is Used:
                                            <ul class="accordion-bullets my-3">
                                                <li>For academic record-keeping and attendance verification.</li>
                                                <li>To generate anonymized statistical insights (e.g., attendance trends).</li>
                                            </ul>
                                        </li>

                                        <li>
                                        Data Retention::
                                            <ul class="accordion-bullets my-3">
                                                <li>Attendance data is retained only for the duration required by the university’s academic policies.</li>
                                                <li>User accounts and associated data are deleted upon graduation, withdrawal, or account termination.</li>
                                            </ul>
                                        </li>

                                        <li>
                                            Privacy Notice:
                                            <ul class="accordion-bullets my-3">
                                                <li>For detailed information on data handling, refer to the <a href="/privacy-notice">Privacy Policy</a>.</li>
                                            </ul>
                                        </li>

                                        
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_7">
                                    7. Acceptable Use Policy
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_7">
                                <div class="accordion-body fs-6">
                                AttendEase users must:
                                    <ul class="accordion-bullets my-3">
                                        <li>Refrain from engaging in unauthorized activities, such as hacking, data scraping, or tampering with app features.</li>
                                        <li>Use the app responsibly and ethically.</li>
                                        <li>Avoid actions that compromise the app’s security or the privacy of other users.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_8">
                                    8. Account Suspension or Termination
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_8">
                                <div class="accordion-body fs-6">
                                AttendEase reserves the right to suspend or terminate accounts for the following reasons:
                                    <ul class="accordion-bullets my-3">
                                        <li>Violation of these Terms and Conditions.</li>
                                        <li>Attempts to bypass or manipulate attendance validation mechanisms.</li>
                                        <li>Unauthorized access to or misuse of the app’s features.</li>
                                    </ul>
                                    Suspensions or terminations will be communicated via email or in-app notifications. Appeals may be directed to the university IT department.
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_9">
                                    9. Intellectual Property
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_9">
                                <div class="accordion-body fs-6">
                                    <ul class="accordion-bullets my-3">
                                        <li>AttendEase, including its name, logo, design, and code, is the intellectual property of the University of Manchester.</li>
                                        <li>Users are prohibited from copying, modifying, or distributing the app’s content without explicit written permission.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_10">
                                    10. Limitation of Liability
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_10">
                                <div class="accordion-body fs-6">
                                    <ul class="accordion-bullets my-3">
                                        <li>AttendEase is provided “as is” and may be subject to occasional technical interruptions or inaccuracies.</li>
                                        <li>
                                        <ul>The University of Manchester is not liable for:
                                            <li>Missed attendance logs due to user errors, connectivity issues, or device malfunctions.</li>
                                            <li>Indirect or consequential damages arising from the use of AttendEase.</li>
                                        </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_11">
                                    11. Updates to Terms
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_11">
                                <div class="accordion-body fs-6">
                                    <ul class="accordion-bullets my-3">
                                        <li>AttendEase reserves the right to update these Terms and Conditions at any time.</li>
                                        <li>Users will be notified of changes through in-app notifications or email.</li>
                                        <li>Continued use of the app signifies acceptance of the updated terms.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_12">
                                    12. Governing Law
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_12">
                                <div class="accordion-body fs-6">
                                    <ul class="accordion-bullets my-3">
                                        <li>These Terms and Conditions are governed by and construed in accordance with the laws of England and Wales.</li>
                                        <li>Any disputes will be resolved through the University of Manchester’s grievance procedures or the courts of England and Wales.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_13">
                                    13. Feedback and Suggestions
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_13">
                                <div class="accordion-body fs-6">
                                Users may submit feedback or suggestions for improving AttendEase. By doing so, you agree that the university has the right to use your submissions without compensation.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item text-primary">
                            <h2 class="accordion-header fs-1">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accpoint_14">
                                    14. Contact Information
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="accpoint_14">
                                <div class="accordion-body fs-6">
                                For questions, concerns, or support regarding these Terms and Conditions, please contact:
                                    <ul class="accordion-bullets my-3">
                                        <li>Email: <a href="mailto:definately.a.real.email.adress@attendease.com">Contact Us</a></li>
                                    </ul>
                                </div>
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