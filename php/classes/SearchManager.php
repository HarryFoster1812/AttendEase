<?php
class SearchManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getSearchResults($query){
        $data = [];
        $tables = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE :dbName ORDER BY TABLE_NAME ;" , [":dbName" => $this->db->getDbname()]);
        for($i=0;$i<sizeof($tables);$i++){
            $tableName = $tables[$i]["TABLE_NAME"];
            $data[$tableName] = $this->searchTable($query, $tableName);
        }



        return $data;
    }


    private function searchTable($needle, $tableName){
        $tableInfo = $this->db->query("SELECT COLUMN_NAME AS 'Field', COLUMN_KEY AS 'Key', COLUMN_DEFAULT AS 'Default' FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :dbName AND TABLE_NAME = :tableName; ", [":dbName" =>$this->db->getDbname(), ":tableName"=>$tableName]);

        $pdo = $this->db->getPdo();
        $stmt = $pdo->prepare('SHOW KEYS FROM '.$tableName.' WHERE Key_name = "PRIMARY"');
        $stmt->execute();
        $keys = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT * FROM ".$tableName." WHERE ";

        $lowerNeedle = strtolower($needle);

        for($i=0;$i<sizeof($tableInfo);$i++){
            $column_name = $tableInfo[$i]["Field"];
            $query .=  $column_name." LIKE '%{$needle}%' OR "; 
        }
        $query = rtrim($query, "OR ");
        $results = $this->db->query($query, []);

        $proccessed_results = []; 
        for($i=0;$i<sizeof($results);$i++){
            // loop through each column and find the first occurance where the query matches;
            // after break and add this column and value to the array
            for($j=0;$j<sizeof($tableInfo);$j++){
                $column_name = $tableInfo[$j]["Field"];
                $value = $results[$i][$column_name];
                $haystackLower = strtolower($value);
                if(str_contains($haystackLower, $lowerNeedle)){
                    break;
                }
            }

            // now that we have the column where it is found we can then add the primary keys

            $proccessed_results[$i]["display"] = $value;
            $proccessed_results[$i]["url"] = UrlHelper::contructHref($results[$i], $tableName, $keys);
        }

        return $proccessed_results;
    }
}
?>
