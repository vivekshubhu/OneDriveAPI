<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . './OneDrive.php';
require __DIR__ . './OneDriveDelta.php';
// require_once __DIR__ . './AuthToken.php';
require __DIR__ . './Subscription.php';



$auth = new AuthToken();
$token = $auth->getToken();

// var_dump($token);

$subscription = new Subscription();

var_dump($subscription->create());
