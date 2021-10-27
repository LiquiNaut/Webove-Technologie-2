<?php
session_start();
require_once("../vendor/vendor/autoload.php");
require_once '../config.php';

$redirect_uri = 'https://wt50.fei.stuba.sk/Zadanie_03/googleOauth2/index.php';

$client = new Google_Client();
$client->setAuthConfig('../configs/credentials.json');
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    $_SESSION['upload_token'] = $token;
    // redirect back to the example
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
    $client->setAccessToken($_SESSION['upload_token']);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['upload_token']);
    }
} else {
    $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
    //Get user profile data from google
    $UserProfile = $service->userinfo->get();
    if(!empty($UserProfile)){
        $_SESSION['login'] = $UserProfile['given_name'] . ' ' . $UserProfile['family_name'];
        if(!empty($_SESSION['login'])){
            $date = date("d-m-Y h:i:sa");
            $sql = "INSERT INTO approaches (login, time, type) VALUES('{$UserProfile['email']}', '{$date}', 'Google')";
            $conn->exec($sql);
            header("Location: ../about.php");
        }
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location:'.filter_var($authUrl, FILTER_SANITIZE_URL));
}
?>

<div><?php echo $output; ?></div>

