<?php
require_once 'config.php';

session_start();
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $ldapconfig['host'] = 'ldap.stuba.sk';//CHANGE THIS TO THE CORRECT LDAP SERVER
    $ldapconfig['port'] = '389';
    $ldapconfig['basedn'] = 'ou=People, DC=stuba, DC=sk';//CHANGE THIS TO THE CORRECT BASE DN
    $ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
    $ds = ldap_connect($ldapconfig['host'], $ldapconfig['port']);


    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

    $dn = "uid=" . $username . "," . $ldapconfig['basedn'];
    if (isset($_POST['username'])) {
        if ($bind = ldap_bind($ds, $dn, $password)) {
            $_SESSION['login'] = $username;
            $date = date("d-m-Y h:i:sa");
            $sql = "INSERT INTO approaches (login, time, type) VALUES('{$username}', '{$date}', 'Ldap')";
            $conn->exec($sql);
            header("Location: about.php");
        } else {

            echo "Login Failed: Wrong Name or Password!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Ldap</title>

</head>
<body class="center">
<form method="post">
    <label for="username"><h3><strong>Login:</strong></h3></label><br>
    <input type="text" name="username" required><br>

    <label for="password"><h3><strong>Password:</strong></h3></label><br>
    <input type="password" name="password" required><br><br>

    <div class="text-center">
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
</body>
</html>
