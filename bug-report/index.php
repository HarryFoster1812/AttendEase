<?php
$URI = $_SERVER["REQUEST_URI"];

if(substr($URI, -1) == "/"){
    $new_URI = rtrim($URI, "/");
    header("Location:". $new_URI);
    exit;
}
session_start();

?>

<html lang="en">
<head>
    <title>Report a Bug | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        
        ?>
    <link rel="stylesheet" href="./bug-report/styles.css">
</head>
<body>
    <?php 
        include("../php/template/navbar.php");
    ?>

    <div class="container mt-5 formbackground">
        <header class="text-center mb-4">
            <h1>Bug Report</h1>
            <p>We're sorry to hear you encountered a bug! Please provide the details below to help us investigate and resolve the issue.</p>
        </header>

        <main>
            <form action="submit-bug-report.php" method="POST" enctype="multipart/form-data">
                <!-- Bug Description -->
                <div class="mb-4">
                    <h4>Description of the Issue</h4>
                    <textarea class="form-control" name="description" rows="4" placeholder="Describe the problem you encountered..." required></textarea>
                </div>

                <!-- Steps to Reproduce -->
                <div class="mb-4">
                    <h4>Steps to Reproduce</h4>
                    <textarea class="form-control" name="steps" rows="4" placeholder="List the steps to reproduce the bug..." required></textarea>
                </div>

                <!-- Expected vs. Actual Behavior -->
                <div class="mb-4">
                    <h4>Expected vs. Actual Behavior</h4>
                    <textarea class="form-control" name="expected-actual" rows="4" placeholder="What did you expect to happen? What happened instead?" required></textarea>
                </div>

                <!-- Device and Environment Details -->
                <div class="mb-4">
                    <h4>Device and Environment Details</h4>
                    <div class="mb-3">
                        <label for="device" class="form-label">Device</label>
                        <input type="text" class="form-control" id="device" name="device" placeholder="e.g., iPhone 13, Samsung Galaxy S21" required>
                    </div>
                    <div class="mb-3">
                        <label for="os" class="form-label">Operating System</label>
                        <input type="text" class="form-control" id="os" name="os" placeholder="e.g., iOS 16, Android 13" required>
                    </div>
                    <div class="mb-3">
                        <label for="app-version" class="form-label">App Version</label>
                        <input type="text" class="form-control" id="app-version" name="app-version" placeholder="e.g., v1.2.3" required>
                    </div>
                    <div class="mb-3">
                        <label for="browser" class="form-label">Browser (if using web app)</label>
                        <input type="text" class="form-control" id="browser" name="browser" placeholder="e.g., Chrome 117, Safari 16">
                    </div>
                </div>

                <!-- Screenshots or Videos -->
                <div class="mb-4">
                    <h4>Screenshots or Videos</h4>
                    <input type="file" class="form-control" name="attachments" accept="image/*,video/*">
                    <small class="form-text text-muted">Attach any screenshots or videos that illustrate the bug (optional).</small>
                </div>

                <!-- Additional Comments -->
                <div class="mb-4">
                    <h4>Additional Comments</h4>
                    <textarea class="form-control" name="comments" rows="4" placeholder="Anything else we should know?"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Bug Report</button>
                </div>
            </form>
        </main>

        <footer class="text-center mt-4">
            <p>Thank you for reporting this issue! We appreciate your help in making AttendEase better.</p>
        </footer>
    </div>


<?php 
        include("../php/template/footer.php");
    ?>

</body>
</html>