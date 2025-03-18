<?php
require_once "../php/db.php";
require_once '../autoload.php';

header('Content-Type: application/json'); // Ensure correct response type

$data = (string) file_get_contents("php://input");
$decodedData = json_decode($data, true);

if ($decodedData === null) {
    echo json_encode(["error" => "Invalid JSON", "message" => json_last_error_msg()]);
    exit;
}

if ($decodedData) {
    echo $decodedData["userid"] . " " . $decodedData["timeslotid"];
    $params = [
        "userID" => (int) $decodedData["userid"],
        "timeslotID" => (int) $decodedData["timeslotid"]
    ];
    try {
        $rowsAffected = $db->query(
            "UPDATE Attendance SET appeal = 0 WHERE user_id = :userID AND timeslot_id = :timeslotID",
            $params
        );

        if ($rowsAffected > 0) {
            echo "\nUpdate successful, Rows Affected: " . $rowsAffected;
        } else {
            echo "\nUpdate failed: No rows affected. Check if user_id and timeslot_id exist.";
        }
    } catch (Exception $e) {
        echo "\nQuery error: " . $e->getMessage();
    }
} else {
    echo "No data received";
}
?>