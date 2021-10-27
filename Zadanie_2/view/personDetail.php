<?php

require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/OlympicGameController.php";

$personController = new PersonController();
$olController = new OlympicGameController();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../js/script.js"></script>

    <title>Person Detail</title>
    <style>
        table, tr, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th:hover {
            cursor: pointer;
        }
        .c:hover{
            cursor: default;
        }

    </style>

</head>
<body>
<h1>Detail of Athlete</h1>
<?php
$personDetail = $personController->getPerson(1);
echo "<h2>{$personDetail->getName()} {$personDetail->getSurname()}</h2>";

?>
<table id="detail">
    <tr>
        <th>Placement</th>
        <th>Discipline</th>
        <th>OG Venue</th>
        <th>OG year</th>
        <th>Type of OG</th>
    </tr>

    <?php
    $placements = $personDetail->getPlacements();
    foreach ($placements as $placement){
        echo "<tr>";
        echo "<td>{$placement->getPlacing()}</td>";
        echo "<td>{$placement->getDiscipline()}</td>";
        echo "<td>{$placement->country} {$placement->getCity()}</td>";
        echo "<td>{$placement->year}</td>";
        echo "<td>{$placement->type}</td>";
        echo "</tr>";
    }
    ?>
</table>
<script src="https://www.w3schools.com/lib/w3.js"></script>
</body>
</html>