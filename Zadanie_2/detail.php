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
        <th onclick="redirect('index.php')" class="sortable" >OG Winners</th>
        <th onclick="redirect('topTen.php')" class="sortable">Top 10</th>
        <th onclick="redirect('editPerson.php')" class="sortable">Edit person</th>
<!--        <th class="active">Detail of Athlete</th>-->
<!--        <th></th>-->
    </tr>

</table>
<?php
include "form/personDetail.php";
?>
</table>
<script>
    function redirect(route){
        location.href = route;
    }

</script>
<script src="https://www.w3schools.com/lib/w3.js"></script>

</body>
</html>