<?php

session_start();

if (!isset($_SERVER["user"])){
    header("Location:./login");
}
else{
    header("Location:./dashboard");
}

?>