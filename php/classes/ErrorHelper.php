<?php

class ErrorHelper {
    public static function createError($message): void{
            http_response_code(400);
        echo json_encode(["error" => $message]);
        exit();

    } 
}

?>
