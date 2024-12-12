<?php
    // set up local variables to store the host, database name, username
    // and user password.
    $database_host = "***REMOVED***";
    $database_user = "***REMOVED***";
    $database_pass = "***REMOVED***";
    $database_name = "***REMOVED***";
    // try to create a mysql database connection using a new PDO object
    // by specifying the database type, host, dbname - then username and pw.
    try
    {
        $pdo = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_pass);
    }
    // catch any pdo exceptions, display the error to and terminate.
    catch (Exception $e)
    {
        die("error" . $e->getMessage());
    }  
?>