<?php

require_once "classes/Person.php";
require_once "classes/Placement.php";
require_once "classes/Database.php";
class PersonController
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getAllPeople()
    {
        $stmt = $this->conn->prepare("select osoby.*, sum(u.placing = 1) as gold_count from osoby join umiestnenia u on osoby.id = u.person_id group by osoby.id;");
        $stmt->execute();
        $people = $stmt->fetchAll(PDO::FETCH_CLASS, "Person");

        foreach ($people as $person) {
            $stmt = $this->conn->prepare("select umiestnenia.*, oh.city from umiestnenia join oh on umiestnenia.oh_id = oh.id where person_id = :personId; ");
            $stmt->bindParam(":personId", $person->getId(), PDO::PARAM_INT);
            $stmt->execute();
            $placements = $stmt->fetchAll(PDO::FETCH_CLASS, "Placement");
            $person->setPlacements($placements);
        }
        return $people;
    }

    public function getPerson(int $id)
    {
        $stmt = $this->conn->prepare("select osoby.*, sum(u.placing = 1) as gold_count from osoby left OUTER join umiestnenia u on osoby.id = u.person_id where osoby.id = :personId;");
        $stmt->bindParam(":personId", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        $person = $stmt->fetch();

        $stmt = $this->conn->prepare("select umiestnenia.*, oh.city, oh.year, oh.type, oh.country from umiestnenia join oh on umiestnenia.oh_id = oh.id where person_id = :personId; ");
        $stmt->bindParam(":personId", $person->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $placements = $stmt->fetchAll(PDO::FETCH_CLASS, "Placement");
        $person->setPlacements($placements);
        return $person;
    }

    public function findDuplicitPerson(Person $person){
        $stmt = $this->conn->prepare("SELECT osoby.* from osoby where osoby.name=:name AND osoby.surname=:surname;");
        $name = $person->getName();
        $surname = $person->getSurname();
        $stmt->bindParam(":name", $name,PDO::PARAM_STR);
        $stmt->bindParam(":surname", $surname,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        return $stmt->fetch();
    }

    public function insertPerson(Person $person)
    {
        $stmt = $this->conn->prepare("Insert into osoby (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) values (:name, :surname, :birth_day, :birth_place, :birth_country, :death_day, :death_place, :death_country)");
        $name = $person->getName();
        $surname = $person->getSurname();
        $birth_day = $person->getBirthDay();
        $birth_place = $person->getBirthPlace();
        $birth_country = $person->getBirthCountry();
        $death_day = $person->getDeathDay();
        $death_place = $person->getDeathPlace();
        $death_country = $person->getDeathCountry();
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindParam(":birth_day", $birth_day, PDO::PARAM_STR);
        $stmt->bindParam(":birth_place", $birth_place, PDO::PARAM_STR);
        $stmt->bindParam(":birth_country", $birth_country, PDO::PARAM_STR);
        $stmt->bindParam(":death_day", $death_day, PDO::PARAM_STR);
        $stmt->bindParam(":death_place", $death_place, PDO::PARAM_STR);
        $stmt->bindParam(":death_country", $death_country, PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updatePerson(Person $person)
    {
        $stmt = $this->conn->prepare("Update osoby set name=:name, surname=:surname, birth_day=:birth_day, birth_place=:birth_place, birth_country=:birth_country, death_day=:death_day, death_place=:death_place, death_country=:death_country where id = :personId");
        $id = $person->getId();
        $name = $person->getName();
        $surname = $person->getSurname();
        $birth_day = $person->getBirthDay();
        $birth_place = $person->getBirthPlace();
        $birth_country = $person->getBirthCountry();
        $death_day = $person->getDeathDay();
        $death_place = $person->getDeathPlace();
        $death_country = $person->getDeathCountry();
        $stmt->bindParam(":personId", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindParam(":birth_day", $birth_day, PDO::PARAM_STR);
        $stmt->bindParam(":birth_place", $birth_place, PDO::PARAM_STR);
        $stmt->bindParam(":birth_country", $birth_country, PDO::PARAM_STR);
        $stmt->bindParam(":death_day", $death_day, PDO::PARAM_STR);
        $stmt->bindParam(":death_place", $death_place, PDO::PARAM_STR);
        $stmt->bindParam(":death_country", $death_country, PDO::PARAM_STR);
        $stmt->execute();
    }

}