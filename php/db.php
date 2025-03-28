<?php
require_once 'classes/Database.php';
// set up local variables to store the host, database name, username
// and user password.

$port          = "3306";

$database_host = "localhost";
$database_user = "root";
$database_pass = "password";
$database_name = "AttendEase";


// try to create a mysql database connection using a new PDO object
// by specifying the database type, host, dbname - then username and pw.
try
{
    $db = new Database($database_host, $port, $database_name, $database_user, $database_pass);
}
// catch any pdo exceptions, display the error to and terminate.
catch (Exception $e)
{
    echo "error" . $e->getMessage();
} 

?>
