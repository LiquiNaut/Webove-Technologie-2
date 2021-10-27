<?php
require_once "Database.php";
$conn = (new Database())->getConnection();

$sth = $conn->prepare("SELECT place, COUNT(place) FROM log WHERE country = :country GROUP BY place");
$sth->bindParam("country", $_GET["country"]);
$sth->execute();
$result = $sth->fetchAll();

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

    <title>Info</title>

</head>
<body style="background-image: url('globe.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
<div class="modal-dialog modal-dialog-centered" style="margin-top: 25vh;">
    <div class="modal-content modal-dialog-centered" style="border-radius: 15px;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tabulka</h5>
        </div>
        <div class="modal-body">
            <table id="data_table1">
                <thead>
                <tr>
                    <th>Mesto</th>
                    <th>Počet</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($result as $row) {
                    echo '<tr>';
                    echo '<td>'. $result[$i]["place"] .'</td>';
                    echo '<td>'. $result[$i]["COUNT(place)"] .'</td>';
                    echo '</tr>';
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a id="back_btn" class="submit" href="table.php"><button id="button_main_page" class="btn btn-primary" style="width: 100px">Späť</button></a>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="script.js"></script>
</body>
</html>

