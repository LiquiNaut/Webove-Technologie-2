<?php
$servername = "localhost";
$username = "xgasparovicb";
$password = '123456';
$dbname = "authentication";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    date_default_timezone_set('Europe/Prague');

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
