<?php 

session_start();
try{
    session_destroy();
    echo "Sucessfully destroyed the session data";
} catch {
    echo "Something went wrong...";
}

?>