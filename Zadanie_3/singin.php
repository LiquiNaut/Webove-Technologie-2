<?php
require_once 'config.php';

if(!empty($_POST['login']) && !empty($_POST['password'])){
    $login = $_POST['login'];
    $sql = $conn->prepare("SELECT COUNT(*) FROM users WHERE login='$login'");
    $sql->execute();
    $result = $sql->fetchColumn();

    if($result == 1) {
        session_start();
        $veta = $conn->prepare("SELECT password from users WHERE login='$login'");
        $veta->execute();
        $result = $veta->fetchColumn();
        $heslo = $_POST['password'];
        if (password_verify($heslo, $result)) {
            $_SESSION['login'] = $login;
            header("Location: checkSingin.php");
        }
        else if(!password_verify($heslo, $result)){
            echo "Wrong Password!";
        }
    }
    else if($result != 1){
        echo "<br><div id='warning'><span>User not registered! Please do so...</span></div><br>";
    }
}
