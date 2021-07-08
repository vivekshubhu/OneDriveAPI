<?php
require './vendor/autoload.php';
require './OneDrive.php';
require './OneDriveDelta.php';
require_once './AuthToken.php';
// require './Subscription.php';


$auth = new AuthToken();
$token = $auth->getToken();

// var_dump($token);


//OneDrive

$oneDrive = new OneDrive($token);
// $folders = $oneDrive->getFilesByFolderName('CS10');
// $folders = $oneDrive->getFoldersOfMainDirectory();
$folders = $oneDrive->createFolder('CS12');


var_dump($folders);
