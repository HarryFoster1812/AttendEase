<?php
require_once "../php/db.php";
require_once '../autoload.php';

header('Content-Type: application/json'); // Ensure it is sent as JSON

try {
    // Fetch all locations
    $locations = $db->query("SELECT * FROM Location");

    if ($locations === false) {
        echo json_encode(["error" => "Database query failed"]);
        exit();
    }

    // Check if we have data
    if (empty($locations)) {
        echo json_encode(["error" => "No data found"]);
    } else {
        echo json_encode($locations);
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

?>

