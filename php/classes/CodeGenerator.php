<?php

class CodeGenerator {
    public static function generate($id): int{
        $min = 10000000;
        $max = 99999999;
        // generate the correct code
        srand(floor(time()/60)*$id); // we might need to change this later but for now its fine
        $generatedCode = rand($min, $max);
        return $generatedCode;
    } 
}

?>
