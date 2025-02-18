<?php 
session_start();

require_once "../php/db.php";
require_once '../autoload.php';

// Authenticate the user
if(!isset($_SESSION["user"])){
    // change respose header to 400
    http_response_code(400);
    echo json_encode(["error" => "Could not authenticate user"]);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // gather which fields need to be changed
    // update them in the database
    $oldPassword = $_POST["oldPass"];
    $newPassword = $_POST["newPass"];

    $user = unserialize($_SESSION["user"]);

    $response = $db->query("SELECT salt,password FROM User WHERE user_id=:id", ["id"=>$user->getUserId()]);

    $result = $response[0];


    $half_position = intdiv(strlen($oldPassword), 2);

    $password = substr_replace( $oldPassword, $result["salt"], $half_position, 0 );

    $hashed_password = hash("sha256", $password);

    if($hashed_password == $result["password"]){

        $half_position = intdiv(strlen($newPassword), 2);

        $password = substr_replace( $newPassword, $result["salt"], $half_position, 0 );

        $hashed_password = hash("sha256", $password);

        
        $db->query("UPDATE User SET password=:newpass WHERE user_id=:id", ["id"=>$user->getUserId(), ":newpass" => $hashed_password]);
        session_destroy();
    }
    else{
        http_response_code(400);
        echo json_encode(["error" => "User password was incorrect"]);
        exit();
    }

}

?>
