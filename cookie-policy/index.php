<?php
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

?>

<html lang="en">
<head>
    <title>Cookie Policy | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        
        ?>
        <style>
        *{
            color:#660099;
        }
        a{
            color:#660099;
        }
    </style>
</head>
<body>
    <?php 
        include("../php/template/navbar.php");
    ?>


<div class="container mt-5">
        <header class="mb-4">
            <h1 class="text-center">Cookies Policy</h1>
        </header>

        <section>
            <p>At <strong>AttendEase</strong>, we use cookies to enhance your browsing experience and improve the functionality of our website. This page explains the types of cookies we use and how they contribute to a better user experience.</p>
        </section>
        
        <section class="mt-4">
            <h2>What Are Cookies?</h2>
            <p>Cookies are small text files that are stored on your device when you visit a website. They help websites remember your preferences, improve performance, and make your interactions with the site more efficient.</p>
        </section>

        <section class="mt-4">
            <h2>Types of Cookies We Use</h2>
            <p>We use the following types of cookies on our website:</p>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Dark Mode Preference Cookie:</strong><br>
                    This cookie remembers whether you have enabled the dark mode on our site, so you don’t have to change it every time you visit. This ensures a consistent experience based on your preferences.
                </li>
                <li class="list-group-item">
                    <strong>Time Format Cookie:</strong><br>
                    This cookie stores your preferred time format, whether you prefer to view the time in the 12-hour or 24-hour format. It ensures that time-related information on our site is presented in the way you prefer.
                </li>
                <li class="list-group-item">
                    <strong>Session Cookies:</strong><br>
                    When you visit our site, a session cookie is created to help identify your session and retain certain temporary information while navigating between pages. These cookies are necessary for basic website functionality, such as logging in or maintaining your session during your visit.
                </li>
            </ul>
        </section>

        <section class="mt-4">
            <h2>Managing Your Cookies</h2>
            <p>You can control how cookies are used on your device. Most web browsers allow you to block or delete cookies through your browser settings. However, please note that some features of our website may not work as intended if cookies are disabled.</p>
        </section>

        <section class="mt-4">
            <h2>Consent</h2>
            <p>By using our website, you consent to our use of cookies as described in this policy. If you choose to disable cookies, certain features of the website may not function properly.</p>
        </section>

        <section class="mt-4">
            <h2>Changes to This Policy</h2>
            <p>We may update our cookies policy from time to time. Any changes will be posted on this page, and the "Last Updated" date will be revised accordingly.</p>
        </section>
    </div>




<?php 
        include("../php/template/footer.php");
    ?>

</body>
</html>

