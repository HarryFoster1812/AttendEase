<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db.php';
    

    $username = $_POST['username'];
    $password = $_POST['password'];

    //get the salt for the use
    $query = 'SELECT * FROM User WHERE username = ?';

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            
            $salt = $result["salt"];
            $position = intdiv(strlen($password), 2);

            $password = substr_replace( $password, $salt, $position, 0 );
            $hashed_password = hash('sha256', $password);
            
            if (password_verify($password, $result["password"])){

                $_SESSION["username"] = $username;
                $_SESSION["userid"] = $result["userid"];
                echo $result;
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<pre>
<?php 
    print_r($_POST); 
?>
</pre>
</body>
</html>