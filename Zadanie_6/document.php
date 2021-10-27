<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Dokumentacia</title>
</head>
<body style="background-color: #34B87F">
<div class="window">
    <h2>Do databazy nacitavam XML. Vyber podla datumu a krajiny a mena</h2>
    <pre class="lang-python"><code>
           $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?day='+ day2 +'&mo=' + month+ '&co=' + countr +'',
                success: function (data) {
                    var responsedata = $.parseJSON(data);
                    var length=responsedata.length;
                    $("#finalDiv").html('');
                    for (i=parseInt(length) ; i!==0; i--){
                        $("#finalDiv").append( 'Meno: '+responsedata[i-1]+ '')   ;
                    }
                }
            });

            Cez Ajax vypisujem na aktualnu stranku.
            Hladanie podla mena je riesene takym istim sposobom.
            Index php vzdy vrati json:
            echo json_encode($myarray,JSON_UNESCAPED_UNICODE);
        </code></pre>
    <h2>Sviatky a pametne dni</h2>
    <pre class="lang-python"><code>
            $.ajax({
                type: 'GET',
                url: 'http://147.175.98.50/zadanie_6/index.php?cztesttest=1',
                success: function (data) {

                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    var length2=responsedata.length;
                    for (i=parseInt(length2) ; i!==0; i--){
                        console.log(i);
                    $("#finalDiv").append( responsedata[i-1].testtest + '    &nbsp &nbsp &nbsp <br>             day:  '+ responsedata[i-1].day2+ ' &nbsp &nbsp &nbsp  Month:  ' + responsedata[i-1].month+'')   ;
                    }
                }

            Sviatky (SK/CZ) vypisujem pomocou url prikazu, ktory presmeruje na index.php,
            nasledne otestujem o co ide (sk/cz sviatky alebo pametne dni). Data nsaledne vypisujem z databazi na stranku.

            $sql = "select value, day_id from records  where type=? AND country_id=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,'memorial');
            $stmt->bindValue(2,4);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        </code></pre>
    <h2>Vytvaranie noveho mena</h2>
    <pre class="lang-python"><code>
Pomoucou js nacitam datum a nove meno,poslem to na index.php
             $.ajax({
                type: 'POST',
                url: 'http://147.175.98.50/zadanie_6/index.php?&value='+ NEV + '&day2=' + day22 + '&month=' + month2 +'',

                success: function (data) {
                    var responsedata = $.parseJSON(data);
                    $("#finalDiv").html('');
                    $("#finalDiv").append( "Ulozene")   ;
                }
            });

            V index.php napisem nove meno do databazy a id dostane "skd"
             $sql = "INSERT INTO records (day_id,country_id,type,value )
                VALUES (?,?,?,?)";
            $stm= $conn->prepare($sql);
            $stm->bindValue(1,$dayid['id']);

            $stm->bindValue(2,5);
            $stm->bindValue(3,'name');
            $stm->bindValue(4,$_GET['value']);
            $stm->execute();

            a priradim aj datum

               if (empty($dayid)){
                $sql = "INSERT INTO days (day,month)
                VALUES (?,?)";
                $stm= $conn->prepare($sql);
                $stm->bindValue(1,$_GET['day2']);

                $stm->bindValue(2,$_GET['month']);
                $stm->execute();
        </code></pre>
</div>
</body>
</html>