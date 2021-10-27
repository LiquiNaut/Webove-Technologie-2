<?php
$appid = 'f0f385b2a5768e73542270f66b5c896a';

$ipUrl = "http://ip-api.com/json/" . $_SERVER['REMOTE_ADDR'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $ipUrl);
$response = curl_exec($ch);

curl_close($ch);
$ip = json_decode($response, true);
$city = $ip["city"];

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=".$ip["city"]."&appid=". $appid ."&units=metric&lang=sk";

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $apiUrl);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);

if ($data["cod"] == "404") {
    $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=".$ip["regionName"]."&appid=". $appid ."&units=metric&lang=sk";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
}


?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" type="text/css">

    <title>Zadanie_7</title>

</head>
<body style="background-image: url('globe.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
<div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top: 25vh;">
    <div class="modal-content text-center modal-dialog-centered" style="border-radius: 15px;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>DOMOV</b></h5>
        </div>
        <div class="modal-body">
            <div>
                <?php
                echo "<b>Mesto: </b>" . $city;
                echo '<br>';
                echo "<b>Počasie: </b>" . ucwords($data["weather"]["0"]["description"]);
                echo '<br>';
                echo "<b>Teplota: </b>".$data["main"]["temp"] . " °C";
                echo '<br>';
                echo "<b>Rychlost vetra: </b>".$data["wind"]["speed"] . " km/h";
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <a id="index_btn" class="submit" href="ip.php"><button style="width: 100px" id="button_main_page" class="btn btn-primary">IP</button></a>
            <a id="table_btn" class="submit" href="table.php"><button style="width: 100px" id="button_main_page" class="btn btn-primary">Tabulka</button></a>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>