<?php
$xml = simplexml_load_file("meniny.xml");

$countries = [
    "SK" => ["title" => "Slovensko"],
    "CZ" => ["title" => "Česká republika"],
    "AT" => ["title" => "Rakúsko"],
    "HU" => ["title" => "Maďarsko"],
    "PL" => ["title" => "Poľsko"],
    "SKd" => ["title" => "SLOVENSKO"],
];

$day = "";
$month = "";

$stmtDays = $conn->prepare("INSERT IGNORE INTO days (day, month) VALUES (:day, :month)");
$stmtDays->bindParam(":day", $day);
$stmtDays->bindParam(":month", $month);

$code = "";
$title = "";

$stmtCountries = $conn->prepare("INSERT IGNORE INTO countries (code, title) VALUES (:code, :title)");
$stmtCountries->bindParam(":code", $code);
$stmtCountries->bindParam(":title", $title);

$day_id = "";
$country_id = "";
$value = "";
$type = "";

$stmtRecords = $conn->prepare("INSERT IGNORE INTO records (day_id, country_id, value, type) VALUES (:day_id, :country_id, :value, :type)");
$stmtRecords->bindParam(":day_id", $day_id);
$stmtRecords->bindParam(":country_id", $country_id);
$stmtRecords->bindParam(":value", $value);
$stmtRecords->bindParam(":type", $type);

foreach ($xml->children() as $row) {
    // Add Day to Database
    $day = substr($row->den, 2, 2);
    $month = substr($row->den, 0, 2);
    $stmtDays->execute();

    $d = $conn->prepare("SELECT id FROM days WHERE day=$day AND month=$month");
    $d->execute();
    $day_id = $d->fetchColumn();

    foreach (array_keys(((array)$row)) as $item) {
        if (array_key_exists($item, $countries)) {
            if (!isset($countries[$item]["id"])) {

                $code = $item;
                $title = $countries[$item]["title"];
                $stmtCountries->execute();

                $c = $conn->prepare("SELECT id FROM countries WHERE code='$code'");
                $c->execute();
                $country_id = $c->fetchColumn();
                $countries[$item]["id"] = $country_id;
            }
            $type = "name";
            $country_id = $countries[$item]["id"];

            foreach (explode(",", $row->$item) as $name) {
                $value = trim($name);
                $stmtRecords->execute();
            }
        }
    }

    if ($row->SKd) {
        $c = $conn->prepare("SELECT id FROM countries WHERE code='SKd'");
        $c->execute();
        $country_id = $c->fetchColumn();
        foreach (explode(",", $row->SKd) as $name) {
            $value = trim($name);
            if (!empty($value)){
                $stmtRecords->execute();
            }
        }
    }

    if ($row->SKsviatky) {
        $c = $conn->prepare("SELECT id FROM countries WHERE code='SK'");
        $c->execute();
        $country_id = $c->fetchColumn();

        $type = "holiday";
        $value = $row->SKsviatky;
        $stmtRecords->execute();
    }

    if ($row->CZsviatky) {

        $c = $conn->prepare("SELECT id FROM countries WHERE code='CZ'");
        $c->execute();
        $country_id = $c->fetchColumn();

        $type = "holiday";
        $value = $row->CZsviatky;
        $stmtRecords->execute();
    }

    if ($row->SKdni) {
        $c = $conn->prepare("SELECT id FROM countries WHERE code='SK'");
        $c->execute();
        $country_id = $c->fetchColumn();

        $type = "memorial";
        $value = $row->SKdni;
        $stmtRecords->execute();
    }
}

