<?php
require_once 'config.php';

$sql = $conn->prepare("SELECT COUNT(*) FROM approaches WHERE type='Google';");
$sql->execute();
$resultGoogle = $sql->fetchColumn();

$sql = $conn->prepare("SELECT COUNT(*) FROM approaches WHERE type='2fa';");
$sql->execute();
$result2fa = $sql->fetchColumn();

$sql = $conn->prepare("SELECT COUNT(*) FROM approaches WHERE type='Ldap';");
$sql->execute();
$resultLdap = $sql->fetchColumn();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>Login</title>

</head>
<body>
<h3>Logins Overall:</h3>
<table id="customers">
    <tr>
        <th>Login type</th>
        <th>Number of login</th>
    </tr>
    <tr>
        <td>Google</td>
        <td><?php  echo $resultGoogle?></td>
    </tr>
    <tr>
        <td>2fa</td>
        <td><?php  echo $result2fa?></td>
    </tr>
    <tr>
        <td>Ldap</td>
        <td><?php  echo $resultLdap?></td>
    </tr>
</table>
</body>
</html>
