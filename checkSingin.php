<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Check</title>

</head>
<body class="center">
<h2>Enter verification code:</h2>
<form method="post">
    <label for="code">code:</label><br>
    <input type="text" id="code" name="code" required><br><br>

    <button class="btn btn-success" type="submit"><h4><strong>Submit</strong></h4></button><br><br>
</form>

<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';
require_once 'config.php';

session_start();
$login =  $_SESSION['login'];
$sql = $conn->prepare("SELECT id FROM users WHERE login='$login'");
$sql->execute();
$result = $sql->fetchColumn();
$sql = $conn->prepare("SELECT secret FROM account WHERE user_id='$result'");
$sql->execute();
$result = $sql->fetchColumn();

if (!empty($_POST['code'])){
    $code = $_POST['code'];

    $ga = new PHPGangsta_GoogleAuthenticator();
    $result = $ga->verifyCode($result, $code);
    if ($result == 1) {
        $date = date("d-m-Y h:i:sa");
        $sql = "INSERT INTO approaches (login, time, type) VALUES('{$_SESSION['login']}', '{$date}', '2fa')";
        $conn->exec($sql);
        header("Location: about.php");
    } else {
        echo 'Login unsuccesfull!';
    }
}
?>
</body>
</html>
