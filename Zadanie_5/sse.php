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

$sql = "SELECT a, y1, y2, y3 FROM data";
$stm = $conn->prepare($sql);
$stm->execute();
$set = $stm->fetch(PDO::FETCH_ASSOC);

header('Content-type: text/event-stream');
header('Cache-Control: no-cache');
header("Connection: keep-alive");
header("Accces-Control-Allow-Origin: *");

$lastId = $_SERVER["HTTP_LAST_EVENT_ID"];
if (isset($lastId) && !empty($lastId) && is_numeric($lastId)) {
    $lastId = intval($lastId);
    $lastId++;
} else {
    $lastId = 0;
}

$a = $set['a'];
$set_y1 = $set['y1'];
$set_y2 = $set['y2'];
$set_y3 = $set['y3'];

while (true) {
    $x = $lastId;
    $y1 = sin($a * $x) * sin($a * $x);
    $y2 = cos($a * $x) * cos($a * $x);
    $y3 = sin($a * $x) * cos($a * $x);

    if ($set_y1 == "true" && $set_y2 == "true" && $set_y3 == "true") {
        $data = array(
            'x' => "{$x}",
            'y1' => "{$y1}",
            'y2' => "{$y2}",
            'y3' => "{$y3}"
        );
    } elseif ($set_y1 == "true" && $set_y2 == "true" && $set_y3 == "false") {
        $data = array(
            'x' => "{$x}",
            'y1' => "{$y1}",
            'y2' => "{$y2}"
        );
    } elseif ($set_y1 == "true" && $set_y2 == "false" && $set_y3 == "false") {
        $data = array(
            'x' => "{$x}",
            'y1' => "{$y1}"
        );
    } elseif ($set_y1 == "false" && $set_y2 == "false" && $set_y3 == "false") {
        $data = array(
            'x' => "{$x}"
        );
    } elseif ($set_y1 == "true" && $set_y2 == "false" && $set_y3 == "true") {
        $data = array(
            'x' => "{$x}",
            'y1' => "{$y1}",
            'y3' => "{$y3}"
        );
    } elseif ($set_y1 == "false" && $set_y2 == "false" && $set_y3 == "true") {
        $data = array(
            'x' => "{$x}",
            'y3' => "{$y3}"
        );
    } elseif ($set_y1 == "false" && $set_y2 == "true" && $set_y3 == "true") {
        $data = array(
            'x' => "{$x}",
            'y2' => "{$y2}",
            'y3' => "{$y3}"
        );
    } elseif ($set_y1 == "false" && $set_y2 == "true" && $set_y3 == "false") {
        $data = array(
            'x' => "{$x}",
            'y2' => "{$y2}"
        );
    }

    echo 'data: ' . json_encode($data) . PHP_EOL . PHP_EOL;

    $lastId++;
    ob_flush();
    flush();

    sleep(2);
}
