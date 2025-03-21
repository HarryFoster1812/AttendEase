<?php  

require_once "../autoload.php";
require_once "../php/db.php";
session_start();

$user = unserialize($_SESSION["user"]);

if($user->getRoleId() != 3){
    ErrorHelper::createError("Access Denied");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $query = $_POST["query"];
    $searchManager = new SearchManager($db);
    $results = $searchManager->getSearchResults($query);

    echo json_encode($results);
    
}


?>
