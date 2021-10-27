<?php

require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/OlympicGameController.php";
require_once "classes/controllers/PlacementController.php";

$personController = new PersonController();
$olympicGameController = new OlympicGameController();
$placementController = new PlacementController();

?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <script src="./js/script.js"></script>

    <title>OG Winners</title>
    <style>
        body{
            margin: 0;
            background: #f2f2f2;
            overflow-y: scroll;
        }
    </style>

</head>
<body>
<table id="nav">
    <tr>
        <th onclick="redirect('index.php')" class="active sortable" >OG Winners</th>
        <th onclick="redirect('topTen.php')" class="sortable">Top 10</th>
        <th onclick="redirect('editPerson.php')" class="sortable">Edit person</th>
<!--        <th></th>-->
<!--        <th></th>-->
    </tr>
</table>

<table id="oly">
    <tr>
        <th colspan="8">OG Winners</th>
    </tr>
    <tr>
        <th>#</th>
        <th class="sortable" onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(2)')" >Name</th>
        <th class="sortable" onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(3)')" >Year of Medal Acq</th>
        <th class="sortable" onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(4)')" >OG Venue</th>
        <th class="sortable" id="olytype" onclick="sortTable()" data-sorted="false" >Type of OG</th>
        <th class="sortable" onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(6)')" >Discipline</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php
    $people = $personController->getAllPeople();
    $index = 0;
    foreach ($people as $person){
        $placements = $person->getPlacements();
        foreach ($placements as $win){
            if ($win->getPlacing() == 1){
                $index += 1;
                $oh = $olympicGameController->getGame($win->getOhId());
                echo "<tr class='row' >";
                echo "<td>{$index}</td>";
                $id = $person->getId();
                echo "<td><a href='detail.php?person_id={$id}'>{$person->getName()} {$person->getSurname()}</a></td>";//
                echo "<td>{$oh->getYear()}</td>";
                echo "<td>{$oh->getCountry()}</td>";
                echo "<td>{$oh->getType()}</td>";
                echo "<td>{$win->getDiscipline()}</td>";
                $placement_id = $win->getId();
                echo "<td><a href='editPerson.php?id={$id}&placement_id={$placement_id}'>Edit</a></td>";
                echo "<td><a href='deletePlacement.php?placement_id={$placement_id}'>X</a></td>";
                echo "</tr>";
            }
        }
    }
    ?>

</table>
<br>

<script>
    function redirect(route){
        location.href = route;
    }

    function sortTable() {
        const element = document.getElementById('olytype');
        if (element.getAttribute('data-sorted') === 'ascend'){
            w3.sortHTML('#oly', '.row', 'td:nth-child(3)');
            w3.sortHTML('#oly', '.row', 'td:nth-child(3)');
            w3.sortHTML('#oly', '.row', 'td:nth-child(5)');
            w3.sortHTML('#oly', '.row', 'td:nth-child(5)');
            element.setAttribute('data-sorted', 'descend');
        }
        else {
            w3.sortHTML('#oly', '.row', 'td:nth-child(3)');
            w3.sortHTML('#oly', '.row', 'td:nth-child(5)');
            element.setAttribute('data-sorted', 'ascend');
        }
    }
</script>
<script src="https://www.w3schools.com/lib/w3.js"></script>

</body>
</html>