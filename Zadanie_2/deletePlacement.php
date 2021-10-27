<?php

require_once "classes/controllers/PersonController.php";
require_once "classes/controllers/OlympicGameController.php";
require_once "classes/controllers/PlacementController.php";

$personController = new PersonController();
$olympicGameController = new OlympicGameController();
$placementController = new PlacementController();

var_dump($_GET['placement_id']);
if(isset($_GET['placement_id']) && $_GET['placement_id']) {
    $placementController->deletePlacement($_GET['placement_id']);
    header("Location:index.php");
    exit();
}

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

<form method="POST" action="deletePlacement.php?placement_id=2">
    <input type="submit">
</form>

</body>
</html>