<?php
require_once "../php/db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $locations = $db->query("SELECT * FROM Location");

    if (empty($locations)) {
        echo "❌ Query executed but returned no data!";
    } else {
        echo "✅ Data retrieved successfully!<br>";
        print_r($locations); // Display fetched data
    }
} catch (Exception $e) {
    die("❌ Database Query Failed: " . $e->getMessage());
}
?>

