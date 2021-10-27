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

    <title>OG Winners</title>
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
<h1>OG Winners</h1>

<table id="oly">
    <tr>
        <th class="c" >#</th>
        <th onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(2)')" >Name</th>
        <th onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(3)')" >when was the medal acquired</th>
        <th onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(4)')" >where was the OG held</th>
        <th id="olytype" onclick="sortTable()" data-sorted="false" >type of OG </th>
        <th onclick="w3.sortHTML('#oly', '.row', 'td:nth-child(6)')" >discipline</th>
    </tr>

</table>
<a href="index.php">index</a>
<script>
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