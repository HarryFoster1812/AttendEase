<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connection.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // generate the salt
    $salt = random_bytes(32);
    // find the highest userid and add one

    $userid = 1;

    $query = 'INSERT INTO User VALUES (?, ?, ?, ?, ?, 0, 1, 1)';

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sssss', $userid, $username, $hashed_password, $salt, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        echo $result;
        if ($result->num_rows > 0) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['username'] = $username;
            header('Location: user_dashboard.php');
            exit;
        } else {
            echo 'The username or password is incorrect.';
        }
    } else {
        echo 'Database query failed.';
    }
}

?>