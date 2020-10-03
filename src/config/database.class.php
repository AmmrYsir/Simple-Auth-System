<?php

class database {
    private $servername = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'php_auth';
    private $conn;

    public function connect() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO('mysql:host=' . $this->servername . ';dbname=' . $this->dbname, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
        
        return $this->conn;
    }

    public function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function checkDuplicateFromUserTable($name, $value) {
        $pdo = $this->connect();
        $pdo = $pdo->prepare("SELECT " . $name . " FROM user_table WHERE " . $name . " = ?");
        $pdo->execute([$value]);
        if ( $pdo->rowCount() ) return true;
        else return false;
    }

}