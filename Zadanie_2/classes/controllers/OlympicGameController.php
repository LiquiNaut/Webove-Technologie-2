<?php

require_once "classes/OlympicGames.php";
require_once "classes/Database.php";
class OlympicGameController
{
    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function getGame(int $id){
        $stmt = $this->conn->prepare("select * from oh where oh.id = :ohId;");
        $stmt->bindParam(":ohId", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "OlympicGame");
        return $stmt->fetch();
    }

    public function getAllGames(){
        $stmt = $this->conn->prepare("select * from oh ORDER BY oh.year;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "OlympicGame");
    }
}