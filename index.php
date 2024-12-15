<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'php/db.php';
    

    $username = $_POST['username'];
    $password = $_POST['password'];

    //get the salt for the use
    $query = 'SELECT * FROM User WHERE username = :username';

    if ($stmt = $pdo->prepare($query)) {
        $stmt->execute([":username" => $username]);
        $result = $stmt->fetch();
        if ($result) {
            
            $salt = $result["salt"];
            $position = intdiv(strlen($password), 2);

            $password = substr_replace( $password, $salt, $position, 0 );

            $hashed_password = hash('sha256', $password);
            
            if ($hashed_password == $result["password"]){

                $_SESSION["username"] = $username;
                $_SESSION["userid"] = $result["userid"];
                
                //check if the user is an admin
                if ($result["role_id"] == 3){
                    $_SESSION["navbar"] = "admin_navbar.php";
                }

                else{
                    $_SESSION["navbar"] = "navbar.php";
                }

                header("Location:/calendar");
            }
            

        } else {
            echo 'The username or password is incorrect.';
        }
    } else {
        echo 'Database query failed.';
        exit;
    }
}

?>

<html lang="en">
<head>
    <title>Login | AttendEase</title>
    <?php 
        include("php/template/header.php");
        
        ?>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <?php 
        include("php/template/navbar.php");
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
                            <form action="" method="post">
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter your username..." name="username">
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
                                <div class="row align-self.center">
                                    <div class="mb-4 d-grid col-12 mx-auto">
                                        <button type="submit" class="btn submit border-secondary">Log In</button>
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
                                        <a href="/signup" class="logup d-grid">
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

</body>
</html>

