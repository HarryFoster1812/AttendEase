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
    public static function contructHref($record, $table, $keys){
        $href = "../database-edit/?table=".$table;
        if(sizeof($keys)>1){
            $columns = [];
            $ids = [];
            foreach ($keys as $value) {
                $keyName = $value["Column_name"];
                array_push($columns, $keyName);
                array_push($ids, $record[$keyName]);
            }
            $href .= '&filter='.urlencode(json_encode($columns)).'&id='.urlencode(json_encode($ids)).'&multi=1';
        }
        else{
            $href .= '&filter='.$keys[0]["Column_name"].'&id='.$record[$keys[0]["Column_name"]];
        }
        return $href;
}


}

?>
