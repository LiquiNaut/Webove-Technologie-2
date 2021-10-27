<?php

require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/OlympicGameController.php";

$personController = new PersonController();
$olympicGameController = new OlympicGameController();

if(isset($_GET['person_id'])){
    $id = $_GET['person_id'];
}
else if(isset($_POST['person_id'])){
    $id = $_POST['person_id'];
}
else if ($_POST['person_id'] == null){
    exit();
}
else{
    exit();
}
$personDetail = $personController->getPerson($id);

?>
<table id="detail">
    <tr>
        <th colspan="5"><?php echo "{$personDetail->getName()} {$personDetail->getSurname()}" ?></th>
    </tr>
    <tr>
        <th class="sortable" onclick="w3.sortHTML('#detail', '.rowdetail', 'td:nth-child(1)')" >Placement</th>
        <th class="sortable" onclick="w3.sortHTML('#detail', '.rowdetail', 'td:nth-child(2)')" >Discipline</th>
        <th class="sortable" onclick="w3.sortHTML('#detail', '.rowdetail', 'td:nth-child(3)')" >OG Venue</th>
        <th class="sortable" onclick="w3.sortHTML('#detail', '.rowdetail', 'td:nth-child(4)')" >Year of OG</th>
        <th class="sortable" onclick="w3.sortHTML('#detail', '.rowdetail', 'td:nth-child(5)')" >Type of OG</th>
    </tr>

    <?php
    $placements = $personDetail->getPlacements();
    if ($placements == null){
        echo "<tr><td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td></tr>";
    }
    else{
        foreach ($placements as $placement){
            echo "<tr class='rowdetail'>";
            echo "<td>{$placement->getPlacing()}</td>";
            echo "<td>{$placement->getDiscipline()}</td>";
            echo "<td>{$placement->country} - {$placement->getCity()}</td>";
            echo "<td>{$placement->year}</td>";
            echo "<td>{$placement->type}</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
