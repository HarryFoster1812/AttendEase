<?php

class UrlHelper {
    public static function enforceTrailingSlash() {
        $uri = $_SERVER["REQUEST_URI"];
        
        if (substr($uri, -1) !== "/") {
            header("Location: " . $uri . "/", true, 301);
            exit;
        }
    }
}

?>