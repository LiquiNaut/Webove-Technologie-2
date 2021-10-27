<?php
require_once "config.php";
$conn = new PDO("mysql:host=". DB_HOST . ";dbname=" .DB_NAME, DB_USER, DB_PASS);
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zadanie_4</title>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <script>
        function getUpdateDb(){
            document.getElementById('load').style.display = 'block';
            fetch('data.php')
                .then(
                    function(response) {
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: ' +
                                response.status);
                            return;
                        }

                        // Examine the text in the response
                        response.json().then(function() {
                            //alert(data.msg);
                            location.reload();
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
        }
    </script>

</head>
<body style="background-color: #C29712;" class="container center">

<div id="load" style="width: 100%; height: 100vh; position: absolute; background: #C29712; z-index: 100; color: black;display: none;">
    <h2 style="position: absolute; top: 50%; left: 35%;)">Please wait for website to load the table...</h2>
</div>


<div id="test">
    <table id="table_data" class="cell-border" style="text-align: center; background: black; color: white; margin: 3%; position: relative; top: 50%; left: 50%; transform: translate(-50%); border-radius: 10px">
        <thead>
        <tr>
            <th>Name</th>
            <?php
            $pocetLectures = array();
            $stmt = "SELECT * FROM time_calc";
            foreach ($conn->query($stmt) as $row) {
                array_push($pocetLectures, $row['lecture_id']);
            }
            $max = max($pocetLectures);
            $i=0;
            for($i=0; $i<=$max; $i++)
            {
                echo '<th>Lecture ' . $i+1 . '</th>';
            }
            ?>
            <th>Presence</th>
            <th>Time</th>
        </tr>
        </thead>
        <?php

        $arrayName[] = [];
        foreach($conn->query($stmt) as $row){
            $name = $row['name'];
            if(in_array($row['name'], $arrayName)){
                continue;
            }else{
                array_push($arrayName, $row['name']);
            }
        }
        $x = 0;
        for($i=1; $i<count($arrayName); $i++)

        {
            $stmt = "SELECT * FROM time_calc WHERE time_calc.name = '$arrayName[$i]'";
            $j = 0;
            $times = array();
            echo "<tr>";
            echo "<td style='background: #3BAD10'>" . $arrayName[$i] . "</td>";

            $pole = array();

            foreach($conn->query($stmt) as $row){
                array_push($pole, $row['lecture_id']);
            }

            $x=0;
            $z = 0;

            foreach($conn->query($stmt) as $row){

                if($pole[$x] == $z)
                {
                    if($row['color'] == 0)
                    {
                        echo "<td style='background: white'><a href='info.php?id=$row[id]')' > " . $row['time'] . "</a></td>";
                    }else{
                        echo "<td style='background: navajowhite'><a href='info.php?id=$row[id]' > " . $row['time'] . "</a></td>";
                    }
                    array_push($times, $row['time']);
                    $j++;
                    $z++;
                    $x += 1;
                }
                else{
                    while($pole[$x] != $z)
                    {
                        echo "<td style='background: red'></td>";
                        $z += 1;
                    }
                    if($row['color'] == 0) {
                        echo "<td style='background: white'><a href='info.php?id=$row[id]'> " . $row['time'] . "</a></td>";
                    }else{
                        echo "<td style='background: red'><a href='info.php?id=$row[id]'>" . $row['time'] . "</a></td>";
                    }
                    array_push($times, $row['time']);
                    $j++;
                    $z++;
                    $x += 1;
                }
            }

            while($z <= $max)
            {
                echo "<td style='background: red'></td>";
                $z++;
            }
            $minutes = 0;
            $second = 0;
            foreach ($times as $time) {
                list($hour, $minute, $seconds) = explode(':', $time);
                $second += $seconds;
                $second += $minute * 60;
                $second += $hour * 3600;
            }
            $hours = 0;
            while($second >= 3600)
            {
                $hours += 1;
                $second -= 3600;
            }
            while($second>59){
                $minutes +=1;
                $second -= 60;
            }
            while($minutes > 59 or $second > 59) {
                if ($minutes > 59) {
                    $hours += 1;
                    $minutes -= 60;
                }
                if ($second > 59) {
                    $minutes += 1;
                    $second -= 60;
                }
            }

            echo "<td style='background: lightslategrey'>" . $j . "</td>";
            echo "<td style='background: cornflowerblue'>" . sprintf('%02d:%02d:%02d', $hours, $minutes, $second) . "</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <button class="btn btn-primary" style="background: green; width: 135px; margin-top: 60px; margin-left: 630px; border-radius: 20px; border-color: black" onclick="getUpdateDb()">UPDATE THE TABLE</button>
    <a href="graf.php"> <button class="btn btn-primary" style="background: darkred; width: 135px; margin-top: -100px; margin-left: -140px; border-radius: 20px; border-color: black">GRAPH</button></a>
</div>

<script>
    window.onload = () => {
        document.getElementById('table_data_filter').style.display = 'none';
        document.getElementById('table_data_length').style.display = 'none';
        document.getElementById('table_data_info').style.display = 'none';
    };

</script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="script.js"></script>
</body>
</html>
