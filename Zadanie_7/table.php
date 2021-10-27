<?php
require_once "Database.php";
$conn = (new Database())->getConnection();

$sth = $conn->prepare("SELECT country, COUNT(country) FROM log GROUP BY country");
$sth->execute();
$result = $sth->fetchAll();

$sth = $conn->prepare("SELECT COUNT(country) FROM log");
$sth->execute();
$sum = $sth->fetch();

$sth = $conn->prepare("SELECT lat, lon FROM log");
$sth->execute();
$coor = $sth->fetchAll();
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css"/>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" type="text/css">

    <title>Table</title>

</head>
<body style="background-image: url('globe.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
<div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top: 5vh;">
    <div class="modal-content text-center " style="border-radius: 15px;">
        <div class="modal-header" >
            <h5 class="modal-title tt" id="exampleModalLabel" ><b>Table</b></h5>
        </div>
        <div class="modal-body">
            <table id="data_table">
                <thead>
                <tr>
                    <th>Vlajka</th>
                    <th>Štát</th>
                    <th>Počet</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($result as $row) {
                    $sth = $conn->prepare("SELECT countryCode FROM log WHERE country = :country");
                    $sth->bindParam("country", $result[$i]["country"]);
                    $sth->execute();
                    $state = $sth->fetch();
                    echo '<tr>';
                    echo '<td><img src="https://ipdata.co/flags/'.$state["countryCode"].'.png"></td>';
                    echo '<td><a href="info.php?country='. $result[$i]["country"] .'"</a>'.$result[$i]["country"].'</td>';
                    echo '<td>'. $result[$i]["COUNT(country)"] .'</td>';
                    echo '</tr>';
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
        <div id="mapid" style="height: 360px; margin-bottom: 20px"></div>
        <div class="modal-footer">
            <a id="ip_btn" class="submit" href="index.php"><button id="button_main_page" class="btn btn-primary" style="width: 100px">Domov</button></a>
            <a id="index1_btn" class="submit butt2" href="ip.php"><button style="width: 100px" id="button_main_page" class="btn btn-primary">IP</button></a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        let mymap = L.map('mapid').setView([48.1526824, 17.073073], 2);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiamFzdHJhYmlpaWlrIiwiYSI6ImNraDBvbjM5NTAwN3gycW13cWRjZ3YzYWoifQ.Vr9FsaKrdvmcJCbJIWxeBg'
        }).addTo(mymap);



        var tmp = <?php echo json_encode($sum); ?>;
        var i = tmp[0]
        var coor = <?php echo json_encode($coor); ?>;
        console.log(i);
        for (var j = 0; j < i; j++) {
            var marker = L.marker([coor[j][0], coor[j][1]]).addTo(mymap);
        }

    })
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
