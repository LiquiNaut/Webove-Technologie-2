<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Info</title>
</head>
<body class="center">
<?php
session_start();
echo "<h1>" ." Welcome: " . $_SESSION['login'] . "</h1>";
//echo "<h2>" . "Logged in as: " . $_SESSION['login'] . "</h2>";

require_once 'jednotlivePrihlasenia.php';
if (isset($_POST['logout'])) {
    header("Location: googleOauth2/logout.php");
}
else if (isset($_POST['showTable'])){
    require_once 'table.php';
    ?>
    <style type="text/css">#minulePrihlasenia{
            display:none;
        }</style>
    <?php
}
?>
<form action="" method="POST">
    <br><input type="submit" class="btn btn-primary" id="minulePrihlasenia" name="showTable" value="Logins">
</form>

<form action="" method="POST">
    <br><input type="submit" class="btn btn-primary" id="logout" name="logout" value="Log Out">
</form>

</body>
</html>
