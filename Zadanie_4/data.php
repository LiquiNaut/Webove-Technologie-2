<?php
header("Content-Type: application/json");
//nacitanie pomocou curl web git
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://github.com/apps4webte/curldata2021");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($output);
libxml_use_internal_errors(false);

$links = $dom->getElementsByTagName('a');
$extractedLinks = array();
foreach($links as $link){

    //Get the link text.
    $linkText = $link->nodeValue;
    //Get the link in the href attribute.
    $linkHref = $link->getAttribute('href');
    $linkTitle = $link->getAttribute('data-pjax');

    //If the link is empty, skip it and don't
    //add it to our $extractedLinks array
    if(strlen(trim($linkHref)) == 0){
        continue;
    }

    //Skip if it is a hashtag / anchor link.
    if($linkHref[0] == '#'){
        continue;
    }

    if($linkHref[-1] != 'v'){
        continue;
    }

    //Add the link to our $extractedLinks array.
    $extractedLinks[] = array(
        'text' => $linkText,
        'href' => $linkHref
    );

}

$links = array_column($extractedLinks, 'text');

$count = 0;
$arrayName = array();
//nacitanie udajow zo vsetkych RAW stranok
for($i=0; $i<sizeof($extractedLinks); $i++){
    // if($i != 2){
    header("Content-Type: application/json");
    require_once "Database.php";
    $z = "https://raw.githubusercontent.com/apps4webte/curldata2021/main/" . $links[$i];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $z);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $output = mb_convert_encoding($output, "UTF-8", 'UTF-16LE');
    curl_close($ch);

    $lines = explode(PHP_EOL, $output);
    $csv = [];
    $conn = (new Database())->getConnection();
//pri updatovani stranky vymazat vsetky udaje
    $sql = "DELETE FROM `user_actions` WHERE lecture_id = '$i'";
    $q = $conn->prepare($sql);
    $response = $q->execute();

//nacitat vsetky udaje z RAW stranok
    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO user_actions (lecture_id, name, action, time)
            VALUES (:i, :name, :action, :time)");
    $stmt->bindParam(':i', $lecture_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':action', $action);
    $stmt->bindParam(':time', $time);

    foreach ($lines as $index => $line){

        $lineArray = str_getcsv($line, "\t");
        if($index >0 && ($lineArray[0])){
            // insert a row
            $name = $lineArray[0];
            $action = $lineArray[1];
            if($action != 'Joined' && $action != 'Left')
            {
                $action = 'Joined';
            }
            if($i ==2){
//americky format datumu
                $time = date('Y-m-d H:i:s', date_create_from_format('d/m/Y, H:i:s A', $lineArray[2])->getTimestamp());

            }else {
                $time = date('Y-m-d H:i:s', date_create_from_format('d/m/Y, H:i:s', $lineArray[2])->getTimestamp());
            }

            $lecture_id = $i;
            try {
                $stmt->execute();
            }catch (Exception $e){
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }


//pushnut kazde meno do databazy raz
            if(in_array($name, $arrayName)){
                continue;
            }else{
                array_push($arrayName, $name);
            }
        }

    }
    $count = $count + sizeof($lines) - 2;
    //}
}
echo json_encode(["status" => "success", "msg" => "Added " . $count ." lines"]);



require_once "config.php";
$conn = new PDO("mysql:host=". DB_HOST . ";dbname=" .DB_NAME, DB_USER, DB_PASS);


$stmt = 'SELECT * FROM user_actions';
$name2 = 0;
$lecture_id2 = -1;

//pri updatovani vymazat druhu databazu
foreach($conn->query($stmt) as $row){
    $sql = "DELETE FROM `time_calc` WHERE 1";
    $q = $conn->prepare($sql);
    $response = $q->execute();
}


//nastavenie maximalneho casu kedy uzivatel odisiel z prednasky
$max = new DateTime('16:05:00');

//for cyklus ktory sa opakuje tolko-krat, kolko je pouzivatelov v databaze
for($i=0; $i<count($arrayName); $i++) {
    $pocetLectures = array();
    $stmt = "SELECT * FROM user_actions WHERE user_actions.name = '$arrayName[$i]'";
    foreach ($conn->query($stmt) as $row) {
//udaj o tom, na ktorych prednaskach bol dany uzivatel
        array_push($pocetLectures, $row['lecture_id']);
    }
    for($j=0;$j<=max($pocetLectures);$j++) {
//for cyklus pre pocet prednasok
        $stmt = "SELECT * FROM user_actions WHERE user_actions.name = '$arrayName[$i]' and user_actions.lecture_id = '$j' ";
        $times = array();
        $statemant = 0;
        foreach ($conn->query($stmt) as $row) {
            $statemant = 1;
            $action = $row['action'];
            $name = $row['name'];
            $lecture = $row['lecture_id'];
            $minutes = 0;
            $second = 0;
//nastavenie casu kedy sa uzivatel pripojil na prednasku
            if ($row['action'] == 'Joined') {
                $datetime1 = new DateTime(date($row['time']));

            } else {
//nastavenie casu kedy sa odpojil
                $datetime2 = new DateTime(date($row['time']));
                $interval = ($datetime1->diff($datetime2));
                $interval = $interval->format('%H:%i:%s');

                $color = 0;

                array_push($times, $interval);
                $max = new DateTime( max($times) );
                foreach ($times as $time) {
                    list($hour, $minute, $seconds) = explode(':', $time);
                    $second += $seconds;
                    $second += $minute * 60;
                    $second += $hour * 3600;
                }
//vypocitanie casu straveneho na prednaske
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
                    if($minutes > 59) {
                        $hours += 1;
                        $minutes -= 60;
                    }
                    if($second > 59) {
                        $minutes += 1;
                        $second -= 60;
                    }
                }
                //$finalTime = new DateTime($hours.':'.$minutes.':'.$second);
                //echo $row['lecture_id'] . " "  . $row['name'] . ' ' . count($times) ." ". sprintf('%02d:%02d:%02d', $hours, $minutes, $second) . "----";
            }
        }
//ak sa uzivatel pripojil ale neodpojil, vypocita sa cas
        if($action == 'Joined'){
            $datetime2 = $max;
            $interval = ($datetime1->diff($datetime2));
            $interval = $interval->format('%H:%i:%s');

            $color = 1;

            array_push($times, $interval);
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
                if($minutes > 59) {
                    $hours += 1;
                    $minutes -= 60;
                }
                if($second > 59) {
                    $minutes += 1;
                    $second -= 60;
                }
            }
            $action = 'Left';

        }
        while($hours>2)
        {
            $hours -= 1;
        }
        if($statemant == 1)
        {
            $finalTime = new DateTime($hours.':'.$minutes.':'.$second);
            $sql = "INSERT INTO time_calc (name, lecture_id, time, color) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $lecture, $finalTime->format('H:i:s'), $color]);
        }
    }
}
?>
