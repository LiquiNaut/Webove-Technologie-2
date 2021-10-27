<?php
require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/PlacementController.php";
$personController = new PersonController();
$placementController = new PlacementController();

$title = 'Create';

function nullPerson() {
    var_dump($_POST['surname']);
    if ($_POST['name'] && $_POST['surname'] && $_POST['birth_day'] && $_POST['birth_place'] && $_POST['birth_country']){
        return false;
    }
    return true;
}

if(isset($_POST['name'])) {
    if (nullPerson()){
        header("Location: index.php");
        exit();
    }
    if(isset($_POST['id']) && $_POST['id']) {
        $person = $personController->getPerson($_POST['id']);
        $person->setName($_POST['name']);
        $person->setSurname($_POST['surname']);
        $person->setBirthDay($_POST['birth_day']);
        $person->setBirthPlace($_POST['birth_place']);
        $person->setBirthCountry($_POST['birth_country']);
        $person->setDeathDay($_POST['death_day']);
        $person->setDeathPlace($_POST['death_place']);
        $person->setDeathCountry($_POST['death_country']);
        $personController->updatePerson($person);
        $title = 'Edit';
        if (isset($_POST['placement_id'])){
            header("Location: newPlacement.php?person_id={$_POST['id']}&placement_id={$_POST['placement_id']}");
        }
    }else{
        $person = new Person();
        $person->setName($_POST['name']);
        $person->setSurname($_POST['surname']);
        $person->setBirthDay($_POST['birth_day']);
        $person->setBirthPlace($_POST['birth_place']);
        $person->setBirthCountry($_POST['birth_country']);
        $person->setDeathDay($_POST['death_day']);
        $person->setDeathPlace($_POST['death_place']);
        $person->setDeathCountry($_POST['death_country']);
        if ($personController->findDuplicitPerson($person) == null){
            $id = $personController->insertPerson($person);
            $person = $personController->getPerson($id);
            header("Location: newPlacement.php?person_id={$id}");
            exit();
        }
        header("Location: index.php");
        exit();
    }
}

if(isset($_GET['id'])){
    $person = $personController->getPerson($_GET['id']);
    $title = 'Edit';
}

if(isset($_GET['placement_id'])){
    $placement = $placementController->getPlacement($_GET['placement_id']);
}
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">

    <title>OG Winners</title>
    <style>
        body{
            margin: 0;
            background: #7DB7DF;
            align-items: center;
        }

        input{
            padding: 10px;
            margin: 5px;
            align-content: center;
            border-radius: 10px;//
        }

        label{
            padding: 20px;
            margin-left: -130px;
        }

        *{
            font-family: "Bookman Old Style", Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        h1{
            padding: 10px;
            margin-left: 650px;
        }

        form{
            padding: 10px;
            margin-left: 750px;
            align-content: center;
            justify-items: center;

        }

    </style>
</head>

<body>
<table id="nav">
    <tr>
        <th onclick="redirect('index.php')" class="sortable" >OG Winners</th>
        <th onclick="redirect('topTen.php')" class="sortable">Top 10</th>
        <th onclick="redirect('editPerson.php')" class="sortable active">Edit person</th>
<!--        <th></th>-->
<!--        <th></th>-->
    </tr>

</table>

<h1><?php echo $title?> Person</h1>

<?php
include "form/personForm.php";
?>

<script>
    function redirect(route){
        location.href = route;
    }
</script>

</body>
</html>