<?php
include_once("config.php");

try {
    $conn = new PDO("mysql:host=". DB_HOST . ";dbname=" .DB_NAME, DB_USER, DB_PASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['submit'])){
    $sql = "DELETE FROM data";
    $stm = $conn->prepare($sql);
    $stm->execute();

    if (!isset($_POST['y1'])) {
        $_POST['y1'] = "false";
    }
    if (!isset($_POST['y2'])) {
        $_POST['y2'] = "false";
    }
    if (!isset($_POST['y3'])) {
        $_POST['y3'] = "false";
    }

    $sql = "INSERT INTO data (a, y1, y2, y3) VALUES (?, ?, ?, ?)";
    $stm = $conn->prepare($sql);
    $stm->execute([$_POST["a"], $_POST["y1"], $_POST["y2"], $_POST["y3"]]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie_5</title>
</head>
<body>

<div class="container">
    <div id="graf"></div>

    <div style="margin-top: 100px">
        <form action="index.php" method="POST">
            <div class="input-group">
                <div class="form-group col-sm">
                    <input type="number" step="1" class="form-control" id="a" name="a" value="1">
                </div>
            </div>
            <div class="input-group" id="inputY1">
                <div class="form-group col-sm">
                    <input type="checkbox" class="form-check-input" id="y1" name="y1" value="true">
                    <label class="form-check-label" for="y1"><h4>y1</h4></label>
                </div>
            </div>
            <div class="input-group" id="inputY2">
                <div class="form-check col-sm">
                    <input type="checkbox" class="form-check-input" id="y2" name="y2" value="true">
                    <label class="form-check-label" for="y2"><h4>y2</h4></label>
                </div>
            </div>
            <div class="input-group" id="inputY3">
                <div class="form-check col-sm">
                    <input type="checkbox" class="form-check-input" id="y3" name="y3" value="true">
                    <label class="form-check-label" for="y3"><h4>y3</h4></label>
                </div>
            </div>
            <div class="input-group" id="centerButton">
                <div class="col-sm">
                    <input type="submit" class="btn btn-success" id="submit" name="submit">
                </div>
            </div>
        </form>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
    var trace1 = {
        x: [],
        y: [],
        type: 'scatter',
        visible: true,
        opacity: 0.5,
        line: {
            color: "blue"
        }

    };

    var trace2 = {
        x: [],
        y: [],
        type: 'scatter',
        visible: true,
        opacity: 0.5,
        line: {
            color: "red"
        }

    };

    var trace3 = {
        x: [],
        y: [],
        type: 'scatter',
        visible: true,
        opacity: 0.5,
        line: {
            color: "yellow"
        }
    };

    var layout = {
        title:'Graph for Sin, Cos, SinCos'
    };

    var hodn = [trace1, trace2, trace3];
    Plotly.newPlot('graf', hodn, layout);

    if(typeof(EventSource) !== "undefined") {
        var source = new EventSource("sse.php");
        source.addEventListener("message", function (e) {
            var data = JSON.parse(e.data);
            trace1.x.push(data.x);
            trace1.y.push(data.y1);
            trace2.x.push(data.x);
            trace2.y.push(data.y2);
            trace3.x.push(data.x);
            trace3.y.push(data.y3);
            hodn = [trace1, trace2, trace3];
            Plotly.newPlot('graf', hodn);
        }, false);
    } else {
        document.getElementById("result").innerHTML = "Sorry.";
    }
</script>

</body>
</html>