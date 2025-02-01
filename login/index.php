<?php

require_once "../autoload.php";

UrlHelper::enforceTrailingSlash();

session_start();

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../php/db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = $db->getPdo();

    //get the salt for the database
    $query = 'SELECT * FROM User WHERE username = :username';

    if ($stmt = $pdo->prepare($query)) {
        $stmt->execute([":username" => $username]);
        
        $result = $stmt->fetch();
        
        // check of there is any result
        if ($stmt->rowCount() > 0) {
            
            // get the salt
            $salt = $result["salt"];
            $position = intdiv(strlen($password), 2);
            
            // insert the salt halfway between the password
            $password = substr_replace( $password, $salt, $position, 0 );

            // hash the salted password
            $hashed_password = hash('sha256', $password);
            
            if ($hashed_password == $result["password"]){
                
                $_SESSION['user'] = serialize(new User($result["user_id"], $result["role_id"], $result["email"], $result["location_opt_in"], $result["leaderboard_opt_in"]));
                
                //check if the user is an admin
                if ($result["role_id"] == 3){
                    $_SESSION["navbar"] = "admin_navbar.php";
                }
 
                else{
                    $_SESSION["navbar"] = "navbar.php";
                }

                header("Location:../calendar");
            }
        } 
        
        else {
            $error_msg = "<div class='alert alert-danger' role='alert'>The username or password is incorrect.</div>";
        }
    } 

    else {
            $error_msg = "<div class='alert alert-danger' role='alert'>Database query failed.</div>";
    }
}

?>

<html lang="en">
<head>
    <title>Login | AttendEase</title>
    <?php 
        include("../php/template/header.php");
        ?>
    <link rel="stylesheet" href="./login.css">
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
                                <h1 class="display-6 text-center">Log In To AttendEase</h1>
                            </div>
                            <hr class="my-4 border-3 border-secondary signup-divider">
                            <form action="../login/" method="post">
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter your username..." name="username">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="user_pass" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="user_pass" placeholder="Enter your password..." name="password">
                                        <small></small>
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
                                <div class="row align-self.center">
                                    <div class="mb-4 d-grid col-12 mx-auto">
                                        <button type="submit" class="btn submit border-secondary">Log In</button>
                                        <small></small>
                                    </div>
                                </div>
                            </form>
                            <hr class="my-4 border-3 border-secondary signup-divider">
                            <div class="row my-4">
                                <div class="col-xl-6 my-3">
                                    <div class="col-11 mx-auto d-grid">
                                        <button class="btn misc-buttons border-secondary">Forgot Password</button>
                                    </div>
                                </div>
                                <div class="col-xl-6 my-3">
                                    <div class="col-11 mx-auto d-grid">
                                        <a href="../signup" class="logup d-grid">
                                            <button class="btn misc-buttons border-secondary">Sign Up</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="./login.js"></script>

    <?php include("../php/template/footer.php"); ?>
</body>
</html>

