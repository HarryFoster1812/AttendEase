<?php

class Database {
    private $pdo;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct($host, $port, $dbname, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $user;
        $this->password = $pass;
    }

    public function getHost(){
        return $this->host;
    }

    public function getPort(){
        return $this->port; 
    }

    public function getDbname(){
        return $this->dbname; 
    }

    public function getUsername(){
        return $this->username; 
    }

    public function getPassword(){
        return $this->password; 
    }
    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        if ($stmt->execute($params)) {
            if (stripos(trim($query), "SELECT") === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            // For UPDATE, INSERT, DELETE, return affected row count
            return $stmt->rowCount();
        } else {
            throw new Exception("Database Query Failed");
        }
    }

    public function getPdo(){
        return $this->pdo;
    } 
}

?>
