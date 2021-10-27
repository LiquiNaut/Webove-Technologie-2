<?php

class Database
{
    private $conn;

    /**
     * @return mixed
     */
    public function getConnection()
    {
        $DB_HOST = 'localhost';
        $DB_USER = 'xgasparovicb';
        $DB_PASS = '123456';
        $DB_NAME = 'z7';

        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME,$DB_USER,$DB_PASS);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
        }catch (PDOException $exception){
            echo "database could not be rich: " . $exception->getMessage();
        }
        return $this->conn;
    }

}