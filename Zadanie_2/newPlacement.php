<?php
require_once "classes/controllers/PlacementController.php";
require_once "classes/controllers/PersonController.php";

$placementController = new PlacementController();
$personController = new PersonController();

$title = '0';

if(isset($_POST['oh_id'])) {
    if(isset($_POST['id']) && $_POST['id']) {
        $placement = $placementController->getPlacement($_POST['id']);
        if ($placement != null){
            if ($_POST['person_id']!=null){
                $placement->setPersonId($_POST['person_id']);
            }
            $placement->setOhId($_POST['oh_id']);
            $placement->setPlacing($_POST['placing']);
            $placement->setDiscipline($_POST['discipline']);
            $placementController->updatePlacement($placement);
            if ($_POST['person_id']==null){
                header("Location:index.php");
                exit();
            }
            $title = 'Uprav existujuce umiestnenie:';
        }
        else{
            echo "<h1>Error 404, Placement not found</h1>";
            exit();
        }
    } else {
        $title = 'Uprav existujuce umiestnenie:';
        $placement = new Placement();
        $placement->setPersonId($_POST['person_id']);
        $placement->setOhId($_POST['oh_id']);
        $placement->setPlacing($_POST['placing']);
        $placement->setDiscipline($_POST['discipline']);
        $id = $placementController->insertPlacement($placement);
        $placement = $placementController->getPlacement($id);
        $person = $personController->getPerson($_POST['person_id']);
    }

}

if(isset($_GET['person_id'])){
    if (isset($_GET['placement_id'])){
        $placement = $placementController->getPlacement($_GET['placement_id']);
        $title = 'Uprav Umiestnenie:';
    }
    else{
        $person = $personController->getPerson($_GET['person_id']);
        if ($person == null){
            echo "<h1>Error 404, person not found!</h1>";
            exit();
        }
        $title = 'Pridaj nove umiestnenie';
    }
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
            background: #f2f2f2;
            overflow-y: scroll;
        }

    </style>

</head>
<body>
<table id="nav">
    <tr>
        <th onclick="redirect('index.php')" class="sortable" >OG Winners</th>
        <th onclick="redirect('topTen.php')" class="sortable">Top 10</th>
        <th onclick="redirect('editPerson.php')" class="sortable active">Edit Person</th>
<!--        <th></th>-->
<!--        <th></th>-->
    </tr>

</table>
<table>
    <tr>
        <th><?php echo $title?></th>
        <?php
        $person_id = 1;
        if(isset($_POST['person_id'])){
            $person_id = $_POST['person_id'];
        }else if(isset($_GET['person_id'])){
            $person_id = $_GET['person_id'];
        }
        ?>
        <th class="sortable" onclick="redirect('<?php echo "newPlacement.php?person_id={$person_id}";?>')" >Add Placement</th>
    </tr>
</table>

<?php
include "form/placementForm.php";
?>

<?php
include "form/personDetail.php";
?>

<script>
    function redirect(route){
        location.href = route;
    }
</script>

</body>
</html>