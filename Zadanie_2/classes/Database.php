<?php

require_once "config.php";
class Database {

    private $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USER_NAME, PASSWORD);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }

}