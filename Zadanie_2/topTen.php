<?php
require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/OlympicGameController.php";

$personController = new PersonController();
$olympicGameController = new OlympicGameController();
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>

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
        <th onclick="redirect('index.php')" class="sortable" >OG Winners</th>
        <th onclick="redirect('topTen.php')" class="sortable active">Top 10</th>
        <th onclick="redirect('editPerson.php')" class="sortable">Edit person</th>
<!--        <th></th>-->
<!--        <th></th>-->
    </tr>

</table>
<table id="topten">
    <tr>
        <th colspan="3">Top 10</th>
    </tr>
    <tr>
        <th class="c" >#</th>
        <th class="sortable" onclick="w3.sortHTML('#topten', '.rowtopten', 'td:nth-child(2)')" >Name</th>
        <th class="sortable" onclick="w3.sortHTML('#topten', '.rowtopten', 'td:nth-child(3)')" >Num of Wins</th>
    </tr>

    <?php
    $people = $personController->getAllPeople();
    $index = 0;
    foreach ($people as $person){
        $placements = $person->getPlacements();
        $winCounter = 0;
        foreach ($placements as $placement){
            if ($placement->getPlacing() == 1){
                $winCounter += 1;
                $oh = $olympicGameController->getGame($placement->getOhId());
            }
        }
        if ($winCounter >= 1){
            $index += 1;
            echo "<tr class='rowtopten' ><td>{$index}</td><td>{$person->getName()} {$person->getSurname()}</td><td>{$winCounter}</td></tr>";
        }
    }
    ?>

</table>
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
<script>
    const sortAndCut = () => {
        console.log('loaded')
        w3.sortHTML('#topten', '.rowtopten', 'td:nth-child(3)');
        w3.sortHTML('#topten', '.rowtopten', 'td:nth-child(3)');
        const tableElement =  document.getElementById('topten');
        while (tableElement.rows.length > 12){ // vypis 10 najlepsich
            tableElement.deleteRow(-1)
        }
    }
    window.onload = sortAndCut();
</script>
</body>
</html>