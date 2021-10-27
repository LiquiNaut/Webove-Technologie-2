<?php
require_once "config.php";
$conn = new PDO("mysql:host=". DB_HOST . ";dbname=" .DB_NAME, DB_USER, DB_PASS);

$id = $_GET['id'];

$stmt = "SELECT * FROM time_calc WHERE time_calc.id = '$id'";

foreach($conn->query($stmt) as $row){
    $name = $row['name'];
    $lecture_id = $row['lecture_id'];
}

$stmt = "SELECT * FROM user_actions WHERE user_actions.name = '$name' AND user_actions.lecture_id = '$lecture_id'";


?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Info</title>
</head>
<body class="container" style="background-color: #5a5f73; color: white; border-radius: 10px">
<div>
    <table id="table_data" class="cell-border" style="text-align: center; background: #5a5f73; color: white; margin: 30px;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 1000px; height: 100px; border: 1px solid black;">
        <thead style="border: 1px solid black; background: black">
        <tr>
            <th style="border: 1px solid black;">Students Name</th>
            <th style="border: 1px solid black;">Time</th>
            <th style="border: 1px solid black;">Joined/Left</th>
        </tr>
        </thead>
        <a href="index.php"> <button class="btn btn-primary" style="background: black; margin-top: 500px; margin-left: 450px; width: 300px; border-radius: 20px;border black; font-size: large; ">BACK</button></a>
        <?php

        foreach($conn->query($stmt) as $row){
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['action'] . "</td>";
            echo "</tr>";
            //echo "<p>" . $row['name'] . " " . $row['time'] . " " . $row['action'] . "</p><br>";
        }

        ?>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

