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
    $modifiedCount = (int)$_POST["modCount"];
    $changedFields = json_decode($_POST["changedFields"]);
    $newValues = json_decode($_POST["newValues"]);

    $user = unserialize($_SESSION["user"]);
    
    $options = ["pronouns" => 0, "username" => 1, "location" => 2, "leaderboard" => 3];
    $optionsQuery = ["pronouns=:newpronouns", "username=:newusername", "location_opt_in=:newlocation", "leaderboard_opt_in=:newleaderbaord"];
    $optionvariables = [":newpronouns", ":newusername", ":newlocation", ":newleaderbaord"];

    $queryVariables = [":id" => $user->getUserId()];

    $completeQuery = "UPDATE User SET ";
    $endquery = "WHERE user_id=:id";

    for ($i = 0; $i < $modifiedCount; $i++) {
        $index = $options[$changedFields[$i]];
        $completeQuery = $completeQuery . $optionsQuery[$index] . ", ";
        $queryVariables[$optionvariables[$index]] = $newValues[$i];

        if ($index == 0){
            $user->setPronouns($newValues[$i]);
            $_SESSION["user"] = serialize($user);
        }
        else if($index == 2){
             $user->setLocationOpt($newValues[$i]);
            $_SESSION["user"] = serialize($user);

        }
        else if($index == 3){
            $user->setLeaderboardOpt($newValues[$i]);
            $_SESSION["user"] = serialize($user);

        }
    }


    $completeQuery = rtrim($completeQuery, ", ") . " " . $endquery;

    $db->query($completeQuery, $queryVariables);

}

?>
