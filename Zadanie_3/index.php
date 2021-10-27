<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Home</title>

</head>

<body class="center">
<form method="post">
    <label for="login"><h3><strong>Login:</strong></h3></h3></label><br>
    <input type="text" id="login" name="login" required><br>

    <label for="password"><h3><strong>Password:</strong></h3></h3></label><br>
    <input type="password" id="password" name="password" required><br><br>

    <div class="text-center">
    <button type="submit" class="btn btn-primary "><h4><strong>Submit</strong></h4></button><br><br>
</form>

<?php require_once 'singin.php'; ?>

<br><a href="registration.php">Register</a>
<br><a href="googleOauth2/index.php">Google</a>
<br><a href="ldap.php">Ldap</a>
</body>
</html>
