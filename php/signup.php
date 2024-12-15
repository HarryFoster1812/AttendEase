<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db.php';

    print_r($_POST);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // generate the salt
    $salt = bin2hex(random_bytes(32));

    $half_position = intdiv(strlen($password), 2);

    $password = substr_replace( $password, $salt, $half_position, 0 );

    $hashed_password = hash("sha256", $password);

    // find the highest userid and add one

    $userid = get_user_id($pdo)["max_user_id"];

    print_r($userid);

    $userid = $userid + 1;

    $query = 'INSERT INTO User VALUES (:userid, :username, :password, :salt, :email, 0, 1, 1)';
    // VALUES for the User table are (UserId, Username, Password, Salt, Email, Role, Location  opt in, leaderboard opt in)

    if ($stmt = $pdo->prepare($query)) {
        $stmt->execute([":userid" => $userid, ":username" => $username, ":password" => $hashed_password, ":salt" => $salt,":email" => $email]);
       
        echo $result;
        if ($result->num_rows > 0) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['username'] = $username;
           // header('Location: user_dashboard.php'); // redirect the user to the dashboard
            exit;
        } else {
            echo 'Something went wrong.';
        }
    } else {
        echo 'Database query failed.';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    print_r($_POST);
    ?>
</body>
</html>