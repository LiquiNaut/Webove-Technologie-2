<?php
require_once "Database.php";
$conn = (new Database())->getConnection();

$ipUrl = "http://ip-api.com/json/" . $_SERVER['REMOTE_ADDR'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $ipUrl);
$response = curl_exec($ch);

curl_close($ch);
$ip = json_decode($response, true);
$city = $ip["regionName"];

$capital = file_get_contents("https://restcountries.eu/rest/v2/name/". $ip["country"] ."?fullText=true");
$capital_js = json_decode($capital);
$date = date('Y-m-d');
$i = 0;
$sth = $conn->prepare("SELECT * FROM log WHERE ip = :ip");
$sth->bindParam("ip", $_SERVER["REMOTE_ADDR"]);
$sth->execute();
$result = $sth->fetchAll();
foreach ($result as $row){
    if ($row["timestamp"] == $date) {
        $i += 1;
    }
}
$code = strtolower($ip["countryCode"]);
if ($i == 0){
    $sth = $conn->prepare("INSERT INTO log (ip, country, place, countryCode, lat, lon, timestamp) VALUES (:ip, :country, :place, :countrycode, :lat, :lon, :timestamp)");
    $sth->bindParam("ip", $_SERVER["REMOTE_ADDR"]);
    $sth->bindParam("country", $ip["country"]);
    $sth->bindParam("place", $ip["city"]);
    $sth->bindParam("countrycode", $code);
    $sth->bindParam("lat", $ip["lat"]);
    $sth->bindParam("lon", $ip["lon"]);
    $sth->bindParam("timestamp", $date);
    $sth->execute();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <title>IP</title>

</head>
<body style="background-image: url('globe.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
<div class="modal-dialog modal-dialog-centered" style="margin-top: 25vh;">
    <div class="modal-content text-center modal-dialog-centered" style="border-radius: 15px;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>IP</b></h5>
        </div>
        <div class="modal-body">
            <div>
                <?php
                echo "<b>IP: </b>".$_SERVER["REMOTE_ADDR"];
                echo "<br>";
                echo "<b>LAT: </b>" . $ip["lat"] . "° <b>LON: </b>" . $ip["lon"] . "°";
                echo "<br>";
                echo "<b>Mesto: </b>" . $ip["city"];
                echo "<br>";
                echo "<b>Štát: </b>" . $ip["country"];
                echo "<br>";
                echo "<b>Hlavne mesto: </b>".$capital_js["0"]->capital;
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <a id="ip_btn" class="submit" href="index.php"><button id="button_main_page" class="btn btn-primary" style="width: 100px">Domov</button></a>
            <a id="table2_btn" class="submit" href="table.php"><button style="width: 100px" id="button_main_page" class="btn btn-primary">Tabulka</button></a>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>

