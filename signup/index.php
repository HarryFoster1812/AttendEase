<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../php/db.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //  check is the username or email is already taken
    $is_duplicate = False;
    $error_msg = "";
    $duplicate = 'SELECT * FROM User WHERE username =:username OR email=:email';
    if ($stmt = $pdo->prepare($duplicate)) {
        $stmt->execute([":username" => $username, ":email" => $email]);
        if ($stmt->rowCount() > 0) {
            $error_msg = "<div class='alert alert-danger' role='alert'>Username or email already associated with an account.</div>";
            $is_duplicate = True;
        }
    }
    else{

        $error_msg = "Something went wrong trying to connect to the database";
        $is_duplicate = True;
    }

    if(!$is_duplicate){

        // generate the salt
        $salt = bin2hex(random_bytes(32));

        $half_position = intdiv(strlen($password), 2);

        $password = substr_replace( $password, $salt, $half_position, 0 );

        $hashed_password = hash("sha256", $password);

        // find the highest userid and add one

        $userid = get_user_id($pdo)["max_user_id"];

        $userid = $userid + 1;

        $query = 'INSERT INTO User VALUES (:userid, :username, :password, :salt, :email, 0, 1, 1)';
        // VALUES for the User table are (UserId, Username, Password, Salt, Email, Role, Location  opt in, leaderboard opt in)

        if ($stmt = $pdo->prepare($query)) {
            $stmt->execute([":userid" => $userid, ":username" => $username, ":password" => $hashed_password, ":salt" => $salt,":email" => $email]);
            $result = $stmt->fetch();
            if ($result->num_rows > 0) {
                $_SESSION['logged_in'] = TRUE;
                $_SESSION['username'] = $username;
            // header('Location: user_dashboard.php'); // redirect the user to the dashboard
                exit();
            } else {
                echo 'Something went wrong.';
            }
        } else {
            echo 'Database query failed.';
        }
    }
}


function get_user_id ($pdo){
    $query = "SELECT MAX(user_id) AS max_user_id FROM User;";
    if ($stmt = $pdo->prepare($query)){
        
        $stmt->execute();
        
        return $stmt->fetch();
    }

    else{
        echo "Failed to get the user id";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up | AttendEase</title>
    <?php 
        include("../php/template/header.php");
    ?>
    <link rel="stylesheet" href="/signup/signup.css">
</head>
<body>
    <?php 
        echo $error_msg;
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
                            <form action="" method="post">
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter your username..." name="username">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Email Address <span class="email-small">(University Email)</span></label>
                                        <input type="email" class="form-control" id="username" placeholder="Enter your university email..." name="email">
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

                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="terms_and_conditions">
                                            <label for="toggle_pass" class="form-label">I have read and agree to our <a href="/terms-and-conditions">Terms and Conditions</a> and <a href="/privacy-notice">Privacy Policy</a></label>
                                            <small></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-self-center">
                                    <div class="mb-4 d-grid col-12 mx-auto">
                                        <button class="btn submit border-secondary" type="submit">Register</button>
                                    </div>
                                </div>
                            </form>
                            <hr class="my-4 border-3 border-secondary signup-divider">
                            <div class="row my-4">
                                <div class="col-8 mx-auto d-grid mt-3">
                                    <a href="../index.php" class="logup d-grid">
                                        <button class="btn misc-buttons border-secondary">Log In</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php 
    include("../php/template/footer.php"); 
    ?>
    
    <script src="/signup/signup.js"></script>
    
</body>
</html>