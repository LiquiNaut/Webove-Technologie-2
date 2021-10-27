<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="style.css">

    <title>Login</title>

</head>
<body class="center">
<?php
require_once 'start.php';
require_once 'config.php';

session_start();
$secret = $_SESSION['secret'];
$id = $_SESSION['id'];
if(!empty($secret)){
    $sql = "UPDATE account SET secret='{$secret}' WHERE user_id='{$id}'";
    $conn->exec($sql);
}

?>
<div id="loginform">
    <br><br><label for="kod">Input code:</label><br>
    <input type="text" name="kod" id="googlecode" /><br><br>

    <input class="btn btn-primary" type="submit" id="submit-googlecode" value="Submit" /><br><br>
</div>

<script>
    $('input#submit-googlecode').on('click', function() {
        var googlecode = $('input#googlecode').val();
        if ($.trim(googlecode) != '') {
            $.post('check.php', {code: googlecode}, function(data) {
                $('div#loginstatus').text(data);
                if (data == 1) {
                    window.location="about.php";
                }
            });
        }
    });
</script>

</body>
</html>