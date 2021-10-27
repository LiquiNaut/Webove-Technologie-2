<?php

require_once "classes/Placement.php";
require_once "classes/Database.php";
class PlacementController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function getPlacement(int $id){
        $stmt = $this->conn->prepare("select * from umiestnenia where umiestnenia.id=:placementId;");
        $stmt->bindParam(":placementId", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Placement");
        return $stmt->fetch();
    }

    public function insertPlacement(Placement $placement)
    {
        $stmt = $this->conn->prepare("Insert into umiestnenia (person_id, oh_id, placing, discipline) values (:person_id, :oh_id, :placing, :discipline)");
        $person_id = $placement->getPersonId();
        $oh_id = $placement->getOhId();
        $placing = $placement->getPlacing();
        $discipline = $placement->getDiscipline();
        $stmt->bindParam(":person_id", $person_id, PDO::PARAM_INT);
        $stmt->bindParam(":oh_id", $oh_id, PDO::PARAM_INT);
        $stmt->bindParam(":placing", $placing, PDO::PARAM_INT);
        $stmt->bindParam(":discipline", $discipline, PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updatePlacement(Placement $placement)
    {
        $stmt = $this->conn->prepare("Update umiestnenia set oh_id=:oh_id, placing=:placing, discipline=:discipline where id=:id");
        $id = $placement->getId();
        $oh_id = $placement->getOhId();
        $placing = $placement->getPlacing();
        $discipline = $placement->getDiscipline();
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":oh_id", $oh_id, PDO::PARAM_STR);
        $stmt->bindParam(":placing", $placing, PDO::PARAM_STR);
        $stmt->bindParam(":discipline", $discipline, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deletePlacement(int $id){
        $stmt = $this->conn->prepare("DELETE from umiestnenia where umiestnenia.id=:placementId;");
        $stmt->bindParam(":placementId", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}