
<?php
// autoload.php
spl_autoload_register(function ($class) {
    // Adjust the path to where your classes are located
    $file = "php/classes/" . $class . ".php";
    if (file_exists($file)) {
        require_once $file;
    }
});

?>