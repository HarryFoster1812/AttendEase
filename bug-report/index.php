<?php
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

$msg = '';

// Handle form submission if method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Parse the non-file form data

    // Handle the file upload (if any)
    if (isset($_FILES['attachments']) && $_FILES['attachments']['error'] == 0) {
        $uploadsDir = './uploads/';  // Directory where files will be saved
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);  // Create the uploads directory if it doesn't exist
        }

        // Get the uploaded file info
        $fileTmpPath = $_FILES['attachments']['tmp_name'];
        $fileName = $_FILES['attachments']['name'];
        $fileSize = $_FILES['attachments']['size'];
        $fileType = $_FILES['attachments']['type'];

        // Generate a unique filename to avoid collisions
        $fileNewName = time() . '-' . basename($fileName);
        $destination = $uploadsDir . $fileNewName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $destination)) {
            $uploadedFilePath = $destination;
        } else {
            $uploadedFilePath = 'Error uploading file.';
        }
    } else {
        $uploadedFilePath = 'No file uploaded.';
    }

    // Prepare the bug report data
    $timestamp = date("Y-m-d H:i:s");
    $reportData = [
        'timestamp' => $timestamp,
        'description' => $_POST['description'] ?? '',
        'steps' => $_POST['steps'] ?? '',
        'expected_actual' => $_POST['expected-actual'] ?? '',
        'device' => $_POST['device'] ?? '',
        'os' => $_POST['os'] ?? '',
        'app_version' => $_POST['app-version'] ?? '',
        'browser' => $_POST['browser'] ?? '',
        'comments' => $_POST['comments'] ?? '',
        'attachment' => $uploadedFilePath
    ];

    // Log the bug report data to a file
    file_put_contents("./bugs.txt", print_r($reportData, true) . "\n\n", FILE_APPEND | LOCK_EX);

    // Success message for the user
    $msg = '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">Feedback sent successfully! Thank you for your time.<button type="button" class="close" data-dismiss="alert" aria-label="Close">  <span aria-hidden="true">&times;</span></button></div>';
}
?>

<html lang="en">
<head>
    <title>Report a Bug | AttendEase</title>
    <?php 
        include("../php/template/header.php");
    ?>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
     <!-- Display success or error message -->
        <?php if ($msg): ?>
        <?php echo $msg; ?>
        <?php endif; ?>

        <?php 
        include("../php/template/navbar.php");
        ?>

        <div class="container mt-5 formbackground">
            <header class="text-center mb-4">
                <h1>Bug Report</h1>
                <p>We're sorry to hear you encountered a bug! Please provide the details below to help us investigate and resolve the issue.</p>
            </header>

        <main>
            <form action="./" method="POST" enctype="multipart/form-data">
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
                        <label for="browser" class="form-label">Browser</label>
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

