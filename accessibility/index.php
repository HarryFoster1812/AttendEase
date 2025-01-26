<?php

session_start();

?>

<html lang="en">
<head>
    <title>Accessibility | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        
        ?>
</head>
<body>
    <?php 
        include("../php/template/navbar.php");
    ?>

<div class="container my-5">
        <h1 class="text-center mb-4">Accessibility Statement</h1>
        <p>
            At AttendEase, we are committed to making our application accessible to all users, including those with disabilities. We strive to ensure that our platform meets high accessibility standards and provides an inclusive experience for everyone.
        </p>

        <h2 class="mt-4">Our Accessibility Standards</h2>
        <p>
            We aim to comply with the <strong>Web Content Accessibility Guidelines (WCAG) 2.1</strong> at the <strong>AA level</strong>, which serves as the global standard for web accessibility. These guidelines ensure that our application is:
        </p>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><strong>Perceivable:</strong> Information and user interface components are presented in ways that users can perceive, including alternatives for auditory and visual content.</li>
            <li class="list-group-item"><strong>Operable:</strong> The interface is easy to navigate, even with a keyboard or assistive technologies.</li>
            <li class="list-group-item"><strong>Understandable:</strong> Information and operation of the user interface are clear and intuitive.</li>
            <li class="list-group-item"><strong>Robust:</strong> The app supports a wide range of assistive technologies.</li>
        </ul>

        <h2 class="mt-4">Evaluation Tools and Processes</h2>
        <p>
            To ensure our app meets these standards, we have used the <strong>WAVE Web Accessibility Evaluation Tool</strong> to analyze and identify potential accessibility issues. WAVE is an industry-recognized tool that provides automated insights and highlights areas where improvements can be made.
        </p>
        <p>
            We use this tool throughout the development process to:
        </p>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item">Identify missing or inadequate labels, ARIA roles, and landmarks.</li>
            <li class="list-group-item">Evaluate color contrast for readability.</li>
            <li class="list-group-item">Ensure proper semantic structure for screen readers.</li>
            <li class="list-group-item">Verify keyboard navigability and focus management.</li>
        </ul>

        <h2 class="mt-4">Accessibility Features</h2>
        <p>Some of the accessibility features we’ve implemented include:</p>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><strong>Keyboard Navigation:</strong> All interactive elements can be accessed and used with a keyboard.</li>
            <li class="list-group-item"><strong>Screen Reader Support:</strong> Our app is compatible with screen readers, providing descriptive text for key elements.</li>
            <li class="list-group-item"><strong>High Contrast Mode:</strong> We ensure adequate color contrast for text and interface components to enhance readability.</li>
            <li class="list-group-item"><strong>Responsive Design:</strong> Our app adjusts to different screen sizes, making it accessible on a range of devices.</li>
        </ul>

        <h2 class="mt-4">Ongoing Efforts</h2>
        <p>
            Accessibility is an ongoing effort, and we are continuously working to improve the user experience. Regular reviews, user feedback, and accessibility testing help us to identify and address potential barriers.
        </p>

        <h2 class="mt-4">Feedback and Support</h2>
        <p>
            If you encounter any accessibility issues while using AttendEase or have suggestions on how we can improve, <a href="/feedback">please provide feedback.</a> We value your input and are committed to addressing accessibility concerns promptly.
        </p>

        <h2 class="mt-4">Resources</h2>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="https://www.w3.org/WAI/standards-guidelines/wcag/" target="_blank">Learn more about WCAG guidelines</a>
            </li>
            <li class="list-group-item">
                <a href="https://wave.webaim.org/" target="_blank">Explore the WAVE Web Accessibility Tool</a>
            </li>
        </ul>
    </div>

<?php 
        include("../php/template/footer.php");
    ?>

</body>
</html>