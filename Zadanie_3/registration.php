<?php require_once 'config.php'; ?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Registration</title>

</head>
<body class="center">
<form method="post">
    <label for="name"><h3><strong>Name:</strong></h3></label><br>
    <input type="text" id="name" name="name" required><br>

    <label for="surname"><h3><strong>Surname:</strong></h3></label><br>
    <input type="text" id="surname" name="surname" required><br>

    <label for="email"><h3><strong>Email:</strong></h3></label><br>
    <input type="email" id="email" name="email" required><br>

    <label for="login"><h3><strong>Login:</strong></h3></label><br>
    <input type="text" id="login" name="login" required><br>

    <label for="password"><h3><strong>Password:</strong></h3></label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button class="btn btn-primary center-block" type="submit"><h4><strong>Submit</strong></h4></button><br><br>
</form>

<?php
if(!empty($_POST['login'])){
    $login = $_POST['login'];
    $sql = $conn->prepare("SELECT COUNT(*) FROM users WHERE login='$login'");
    $sql->execute();
    $result = $sql->fetchColumn();
    if($result > 0){
        echo "Login already used, choose another one!";
    }
    else if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['login'])
        && !empty($_POST['password'])) {
        session_start();
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, surname, email, login, password)
        VALUES ('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['email']}', '{$_POST['login']}', 
                '{$hash}')";
        $conn->exec($sql);


        $sql2 = $conn->prepare("SELECT id FROM users WHERE login='$login'");
        $sql2->execute();
        $result = $sql2->fetchColumn();
        $_SESSION['id'] = $result;

        $sql2 = "INSERT INTO account (user_id) VALUES('{$result}')";
        $conn->exec($sql2);

        $date = date("d-m-Y h:i:sa");
        $sql = "INSERT INTO approaches (login, time, type) VALUES('{$_POST['login']}', '{$date}', '2fa')";
        $conn->exec($sql);


        $_SESSION['login'] = $_POST['login'];
        header("Location: qrLogin.php");
    }
}
?>
</body>
</html>