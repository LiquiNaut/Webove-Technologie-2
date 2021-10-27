<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';
require_once  'config.php';

$websiteTitle = 'MyWebsite';

$ga = new PHPGangsta_GoogleAuthenticator();

$secret = $ga->createSecret();
session_start();
$_SESSION['secret'] = $secret;

$qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
echo '<img src="'.$qrCodeUrl.'" />';

$myCode = $ga->getCode($secret);

//third parameter of verifyCode is a multiplicator for 30 seconds clock tolerance
$result = $ga->verifyCode($secret, $myCode, 1);

