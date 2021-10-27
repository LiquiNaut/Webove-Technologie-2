<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <title>Zadanie_6</title>
</head>
<body style="background-color: #34B87F; background-size: cover;" class="container">
<div style="background-color: whitesmoke; margin-top: 200px; border-radius: 15px; width: 50%; margin-left: 300px; border: solid 2px"><h3>Meniny info</h3>
<div class="login-box" style="margin-top: -50px">
    <form style="margin-top: -50px">
        <div class="selector">
<!--            hladanie podla...-->
            <select name="cars" id="mode" style="background-color: #E2BF24; width: 250px; height: 40px; border-radius: 10px; font-size: large ;text-align-last:center; border: solid 2px">
                <option value="a">
                    Hladanie podla datumu a krajiny</option>
                <option value="b">Hladanie podla mena</option>
                <option value="c">SK sviatky</option>
                <option value="d">CZ sviatky</option>
                <option value="e"> SK dni</option>
                <option value="f">Nove meno</option>
            </select>
        </div>

<!--        datum input-->
        <div class="MODE" id="a">
            <div class="user-box">
                <input id="datum" type="date" name="" required="" style="background-color: #E2BF24; border-radius: 10px; width: 250px; text-align-last:center; border: solid 2px">
            </div>
            <div class="user-box">
                <select name="country" id="country" style="background-color: #E2BF24; width: 250px; height: 40px; border-radius: 10px; font-size: large; text-align-last:center; border: solid 2px">
                    <option value="1">Maďarsko</option>
                    <option value="2">Poľsko</option>
                    <option value="3">Rakúsko</option>
                    <option value="4">Slovensko</option>
                    <option value="5">SLOVENSKO "skd"</option>
                    <option value="6">Česká republika</option>
                </select>
            </div>
        </div>

        <div class="MODE" id="b">
            <div class="user-box">
                <input id="nev" type="text" name="" required="" style="background-color: #E2BF24; border-radius: 10px; width: 250px; text-align-last:center; border: solid 2px" placeholder="Zadaj meno..">
            </div>
            <div class="user-box">
                <select name="country2" id="country2" style="background-color: #E2BF24; width: 250px; height: 40px; border-radius: 10px; font-size: large; text-align-last:center; border: solid 2px">
                    <option value="1">Maďarsko</option>
                    <option value="2">Poľsko</option>
                    <option value="3">Rakúsko</option>
                    <option value="4">Slovensko</option>
                    <option value="5">SLOVENSKO EXTRA</option>
                    <option value="6">Česká republika</option>
                </select>
            </div>
        </div>

        <div class="MODE" id="c">
            <div class="user-box">

            </div>
        </div>

        <div class="MODE" id="d" >
            <div class="user-box">

            </div>
        </div>

        <div class="MODE" id="e">
            <div class="user-box">

            </div>
        </div>

        <div class="MODE" id="f">
            <div class="user-box">
                <input id="nevadd" type="text" name="" required="" style="background-color: #E2BF24; border-radius: 10px; width: 250px; text-align-last:center; border: solid 2px" placeholder="Zadaj meno">
            </div>
            <div class="user-box">
                <input id="datum2" type="date" name="" required="" style="background-color: #E2BF24; width: 250px; height: 40px; border-radius: 10px; font-size: large; text-align-last:center; border: solid 2px">
            </div>

        </div>
        <div style="margin-left: -10px">
            <a id="submit" style="border: solid 2px; height: 50px; margin: 10px; padding: 10px;border-radius: 10px; background-color: aqua">
                Odoslat
            </a>

            <a onclick="window.location.href = 'document.php'"  style="border: solid 2px; height: 50px; margin: 10px; padding: 10px;border-radius: 10px; background-color: aqua; margin-left: -10px" >
                Dokumentacia
            </a>
        </div>
    </form>
</div>
    <br>
    <br>
</div>

<script src="js.js"></script>

<div id="finalDiv"></div>
</body>
</html>