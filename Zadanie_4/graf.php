<?php
require_once "config.php";
$conn = new PDO("mysql:host=". DB_HOST . ";dbname=" .DB_NAME, DB_USER, DB_PASS);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body style="background-color: #2A2929; justify-content: center">

<?php
$stmt = "SELECT * FROM time_calc";
$max = 0;
$i = 0;
foreach ($conn->query($stmt) as $row) {
    if($row['lecture_id'] > $max)
    {
        $max = $row['lecture_id'];
    }
}
$dataPoints = array();
for($i=0; $i<=$max;$i++)
{
    $count = 0;
    $stmt = "SELECT * FROM time_calc WHERE time_calc.lecture_id = '$i'";
    foreach ($conn->query($stmt) as $row) {
        $count++;
    }

    $dataPoints[$i] = (
    array("x"=> $i+1, "y"=> $count)
    );
}

?>
<div class="container">
    <a href="index.php"> <button class="btn btn-primary" style="background: green; margin-top: 680px; margin-left: 400px; width: 300px; border-radius: 20px;border black; font-size: large; ">BACK</button></a>
    <div id="chartContainer" style="height: 70vh; width: 80%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 20px"></div>
</div>
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "dark1", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "number of students per lecture"
            },
            axisY:{
                includeZero: true
            },
            data: [{
                type: "column", //change type to bar, line, area, pie, etc
                //indexLabel: "{y}", //Shows y value on all Data Points
                indexLabelFontColor: "#000000",
                indexLabelPlacement: "outside",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

</body>
</html>

