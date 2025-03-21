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

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['image'])){
    $userData = unserialize($_SESSION["user"]);
    
    $base64Image = $data['image'];

    // Remove the data:image/png;base64, part (if present)
    $imageData = str_replace('data:image/png;base64,', '', $base64Image);
    $imageData = str_replace(' ', '+', $imageData);  // Handle potential spaces

    // Decode the base64 data
    $decodedData = base64_decode($imageData);

    // Specify the path where you want to save the file
    $filePath = '../images/uploads/' . $userData->getUserID() . '.png'; 
    if(file_put_contents($filePath, $decodedData)){
        // sucessful
        // add fiile to path
        $userData->setPfpPath($filePath);
        $_SESSION["user"] = serialize($userData);
        $query = "UPDATE User SET file_loc=:path WHERE user_id=:user_id";

        $db->query($query, [
            ":user_id" => $userData->getUserId(),
            ":path" => $filePath
        ]); 
    }
    else{
        // failed to upload
     http_response_code(400);
    echo json_encode(["error" => "Could not upload image"]);
    exit();
       
    }
}


echo json_encode($data);

?>
