<?php 
require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

if(isset($_SESSION["navbar"])){
    $nav_path = "../php/template/" . $_SESSION["navbar"];
}

else{
    header("Location:../");
}

$user = unserialize($_SESSION["user"]);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Settings | AttendEase</title>
        <?php include("../php/template/header.php"); ?>
        <link rel="stylesheet" href="./settings.css">
        <link rel="stylesheet" id="darkStyleSheet" href="../css/settings_dark.css">
        <link rel="stylesheet" href="../node_modules/cropme/dist/cropme.css"> </head>
    <body>

        <div id="overlay" class="overlay hidden">
            <div class="popup" id="popup">
                <div id="cropContainer"></div>
                <div class="button-container">
                    <button class="cancel" id="cancelBtn">Cancel</button>
                    <button class="crop" id="cropBtn">Crop</button>
                </div>
            </div>

            <div class="popup" id="deletepopup">
                <p>Are you sure that you want to delete your account?</p>
                <div class="button-container">
                    <button class="cancel" id="noBtn">Cancel</button>
                    <button class="crop" id="yesBtn">Delete</button>
                </div>
            </div>

            <div class="popup w-50 h-50 flex-column" id="requestChange">
                <p>Send a change request to your administrator</p>
                <textarea id="message" class="h-100" placeholder="Add the details of your request, describe what you want changing and the new value"></textarea>
                <div class="button-container">
                    <button class="cancel" id="cancel">Cancel</button>
                    <button class="crop" id="request">Send</button>
                </div>
            </div>
        </div>

        <?php include($nav_path); ?>
        <!-- Sidebar -->
        <div class="sidebar-container collapse show" id="sidebarCollapse">
            <div class="pills-container">
                <div class="d-flex align-items-start bg-primary">
                    <div class="nav flex-column nav-pills sidebar-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                            <span class="ms-3">Profile</span>
                        </button>
                        <button class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false">
                            <span class="ms-3">Account</span>
                        </button>
                        <button class="nav-link" id="v-pills-preferences-tab" data-bs-toggle="pill" data-bs-target="#v-pills-preferences" type="button" role="tab" aria-controls="v-pills-preferences" aria-selected="false">
                            <span class="ms-3">Preferences</span>
                        </button>
                        <button class="nav-link" id="v-pills-privacy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                            <span class="ms-3">Privacy and Security</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- -------------------------------------PROFILE PAGE---------------------------------------------- -->
        <!-- ----------------------------------------Main Content-------------------------------------------------- -->
        <!-- Main Content -->
        <div class="main-content" id="profile-content">
            <h2 class="heading">User Settings</h2>

            <!-- Profile Picture & Upload Section -->
            <div class="profile-section d-flex flex-column flex-md-row align-items-md-center gap-3">
                <img src="<?php echo $user->getPfpPath();?>" alt="Profile Picture" 
                    class="img-fluid align-self-start"
                    style="width: 100px; height: 100px;" id="profileImage">

                <div class="upload-section w-60 col-10 col-sm-9 col-md-7 col-xl-6 col-xxl-5">
                    <h3 class="text-start">Upload New Profile Picture</h3>
                    <input type="file" 
                        id="fileUpload" 
                        class="form-control border-primary mw-100 w-100" 
                        accept=".jpeg, .jpg, .png, .tif,.webp">
                    <small id="errormsg" style="color:red"></small>
                </div>
                <button id="uploadBtn" class="btn btn-light border-dark px-3">Upload</button> 
            </div>

            <!-- Divider -->
            <hr class="divider">

            <!-- Profile Details -->
            <div class="container-fluid mt-5">
                <h3 class="mb-3">Profile Details</h3>

                <!-- Added Bootstrap grid wrapper -->
                <div class="row">
                    <div class="col-10 col-sm-9 col-md-8 col-xl-7 col-xxl-6">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input class="form-control border-primary" value="<?php echo $user->getName(); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input id="usernameInput" type="text" class="form-control border-primary" value="<?php echo $user->getUsername() ?>" disabled>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Pronouns</label>
                            <select id="pronounSelect" class="form-select border-primary">
                                <option <?php if($user->getPronouns()){ echo "selected";}?> >He/Him</option>
                                <option <?php if($user->getPronouns() == "She/Her"){ echo "selected";}?>>She/Her</option>
                                <option <?php if($user->getPronouns() == "They/Them"){ echo "selected";}?>>They/Them</option>
                                <option <?php if($user->getPronouns()== "Other"){ echo "selected";}?>>Other</option>
                                <option <?php if($user->getPronouns() == "Not Set"){ echo "selected";}?>>Not Set</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control border-primary" value="<?php echo $user->getEmail(); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">University ID</label>
                            <input type="text" class="form-control border-primary" value="<?php echo $user->getUserId(); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Academic Affiliation</label>
                            <input type="text" class="form-control border-primary" value="<?php echo $user->getAcademic(); ?>" disabled>
                        </div>
                        
                        <button id="saveChangesProfile" class="btn btn-success">Save Changes</button> 
                    </div>
                </div>
                <button id="requestAdminChange" class="btn btn-warning my-2">Request Changes</button> 
            </div>
        </div>
        <!-- ----------------------------------------Main Content-------------------------------------------------- -->
        <!-- -------------------------------------ACCOUNT PAGE---------------------------------------------- -->
        <div class="main-content d-none" id="account-content">
            <h2 class="heading">Account Settings</h2>

            <!-- Add Delete Account and Log Out buttons -->
            <div class="mt-5 container-fluid pe-5">
                <h3 class="mb-3">Delete Account</h3>
                <p class="mb-4 settings-text">Deleting your account would lead to you not having access to your account and your attendance data. Kindly proceed with caution as your account can not be recovered upon deleting your account!</p>
                <div class="mt-4 d-flex justify-content-end">
                    <button id="deleteAccount" class="btn btn-danger btn-lg">Delete Account</button>
                </div>
            </div>
            <hr class="divider">
            <div class="mt-5 container-fluid pe-5">
                <h3 class="mb-3">Sign Out</h3>
                <p class="mb-4 settings-text">Sign out from your account.</p>
                <div class="mt-4 d-flex justify-content-end">
                    <button id="signOutBtn" class="btn btn-success btn-lg">Sign out</button>
                </div>
            </div>
            <hr class="divider">
        </div>
        <!-- ----------------------------------------Main Content-------------------------------------------------- -->
        <!-- -------------------------------------PREFERENCES PAGE---------------------------------------------- -->
        <div class="main-content d-none" id="preferences-content">
            <h2 class="heading">Preferences</h2>
            <!-- Add your preferences content here -->
            <div class="mt-5 container-fluid pe-5">
                <h3 class="mb-4">Dark Mode</h3>
                <div class="d-flex justify-content-between">
                    <p>Enable Dark Mode?</p>
                    <label class="switch">
                        <input id="darkModeInput" type="checkbox" <?php if(isset($_COOKIE["darkMode"])){echo 'checked';}?> >
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
            <hr class="divider">
            <div class="mt-5 container-fluid pe-5">
                <h3 class="mb-4">Time Settings</h3>
                <div class="row">
                    <div class="col-xl-6">
                        <p>Please select one of the time settings from the dropdown</p>
                    </div>
                    <div class="col-xl-6">
                        <select id="timeSelect" class="form-select border-primary time-select">
                            <option <?php if(isset($_COOKIE["time"]) && $_COOKIE["time"] == "24 Hour"){echo "selected";} ?> >24 Hour</option>
                            <option <?php if(isset($_COOKIE["time"]) && $_COOKIE["time"] == "12 Hour AM/PM"){echo "selected";} ?> >12 Hour AM/PM</option>
                        </select>
                    </div>
                </div>


            </div>
        </div>
        </div>
        <!-- ----------------------------------------Main Content-------------------------------------------------- -->
        <!-- -------------------------------------PRIVACY PAGE---------------------------------------------- -->
        <div class="main-content d-none" id="privacy-content">
            <h2 class="heading">Privacy and Security</h2>
            <!-- Add your privacy and security content here -->
            <div class="mt-5 container-fluid pe-5">
                <h3 class="mb-4">Monitor Location Data</h3>
                <div class="row">
                    <div class="col-9">
                        <p>Enabling this setting will allow us to monitor your location data in order to verify your attendance. Gathered location data will not be used for any other purpose. Disabling this setting will prevent you from marking your attendance by using your location, and thus may break your institution's code of conduct.</p>
                    </div>
                    <div class="col-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <label class="switch">
                                <input id="locationToggle" type="checkbox" <?php if($user->isLocationOpt()){echo "checked";} ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="mb-4">Allow data to be used in the leaderboard</h3>
                <div class="row">
                    <div class="col-9">
                        <p> By enabling this setting, you are agreeing to allow us to use your attendance data for leaderboard purposes. Your personal details and attendance statistics will be visible to all users of the site or university. This data will be displayed on the public leaderboard and updated regularly. Please be aware that by opting in, your participation will be visible to others, and your personal statistics will be shared accordingly. </p> 
                    </div>
                    <div class="col-3">
                        <div class="d-flex align-items-center justify-content-end">
                            <label class="switch">
                                <input id="leaderboardToggle" type="checkbox" <?php if($user->isLeaderboardOpt()){echo "checked";} ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <button id="privacySubmit" class="btn btn-success">Save Changes</button>
                </div>

                <hr class="divider">
                <div class="row mt-5">
                    <h3 class="mb-4">Change Password</h3>
                    <div class="col-10 col-sm-9 col-md-8 col-xl-7 col-xxl-6">
                        <div class="mb-3">
                            <label class="form-label">Enter Current Password</label>
                            <input id="oldpass" type="password" class="form-control border-primary" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter New Password</label>
                            <input id="newpass" type="password" class="form-control border-primary" value="">
                            <small id="newerror" style="color:red" ></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter New Password Again</label>
                            <input id="renewpass" type="password" class="form-control border-primary" value="">
                            <small id="renewerror" style="color:red"></small>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-start">
                        <button id="changePassBtn" class="btn btn-danger btn-lg">Change Password</button>
                    </div>
                </div>
            </div>
            <hr class="divider">
        </div>
        <!-- ----------------------------------------Main Content-------------------------------------------------- -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="../bootstrap/dist/js/bootstrap.js"></script>
        <script src="../bootstrap/js/dist/util/index.js"></script>
        <script src="../node_modules/cropme/dist/cropme.js"></script>
        <script src="../node_modules/js-cookie/dist/js.cookie.min.js"></script>

        <script src="../php/debugging-tools/debug.js"></script>

        <script src="./settings.js"></script>
        <script src="./backend.js"></script>
    </body>
</html>
