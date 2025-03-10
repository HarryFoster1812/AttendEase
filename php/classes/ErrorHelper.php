<?php

class ErrorHelper {
    public static function createError($message): void{
        echo json_encode(["error" => $message]);
        http_response_code(400);
        exit();

    } 
}

?>
