<?php

class UrlHelper {
    public static function enforceTrailingSlash() {
        $uri = $_SERVER["REQUEST_URI"];
        $params = "";
        if(str_contains($uri, "?") ==  1){
            // need to remove the get clause
            $params = '?' . explode('?', $uri)[1];
            $uri = explode('?', $uri)[0];
        } 
        if (substr($uri, -1) !== "/") {
            header("Location: " . $uri . "/" . $params, true, 301);
            exit;
        }
    }
}

?>
