<?php

class Database {
    private $pdo;

    public function __construct($host, $port, $dbname, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Database Query Failed");
        }
    }

    public function getPdo(){
        return $this->pdo;
    } 
}

?>
