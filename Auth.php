<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . './OneDrive.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;




$token = 'EwBYA8l6BAAU6k7+XVQzkGyMv7VHB/h4cHbJYRAAARtiX8yU5xQWxqckgEu3iynlO+H0Mg5Fmkzyt+C5CqyUxgjgkdV8RtwRUHFmajkfiGOwAHPwP8+bNKMSdOjDwU+rSKNHa4iHgy195i3Ey8ODb6larVkjCMoeJ+BNZ/LjaxIEI4RsnfhnKHM/kXZGzewRQZLOaQ5S0te5V4ZPyvirh/hOuWvF6A9cFrlC2tru3bmEmenzeSJ1YbiXYMJ5nwaOguymaRpW80hU9r0TFkqq+1laKoXDa/t7LYfs9OrhcKxF3kKenIIYOyg3V34AYfPg6Ryd0bE2fufd4/6MTTqdoQbFjURCiXx/U81wYyj2qVmoCrsemBXTUqIEt+pU4AUDZgAACDLgcsfWt31GKAJaoGjlLgLGk7ZlUB0bs7/Rk3iHDfL21vX4lpAifjlKmvTKsjM8qy0ZOCBRl/usY1whxC+s2wz2RwJtfc06cg4rY/Ga/ZMd+iXHr4MFL/qnrg2grv30Lw68/Thpp9igD0XZv7J6KR0nNnCznVZU5b9tp2qLwGwnYnXUfQ/uq8GA9MEJpo+VZhMBCyVXVWKLwzhqNv4krMqi0V6Z0lQsDgOimCu9VSivAS6RY57tzPMGXtssuSg98ugnXc62lXRXjOyJNj01XFe6+CWaeUVSOBOv9ooTPa408orKBUbL0d2BhLJV8AmnEmDInoVfR1iuxCoGgsccoUhr4y7gkX0sxOaoKgp1hoLlm/AEZPPYNRyQ9Z7UazEpE2fL8MHCUa1VLfcx1ac5ytKhlb5akINaqHAdxc5b6A1KRE+aMGVHZh27dw4O2j4dwqOg8x06EbUgyUzlnyPPWzmFDkiOAxAThMZr2pVB1TIhL0U6fU5VQXYVDctINnpeS4uCEBnOP1bLTGU/J3U6wUWhLjNjWPyrYwH4feWZ2AfBBJ+UzXJla99gAZF4e1CWv/baHk5cFODWH8NdK+l/gfa9r7ji617aVsmEl6fl3MAbqpjH3tSqEeGIsyYisdkem8li88Xswp32DD+B7dvD9moTYx7tZhKbd9pZFSqniwJRoo2kwd7YLFbOOqZzjvMI8fRQziZbW6cyukMoTYy1Qxo8pNoxfqL/7r9zjTnC9RikPWdyAg==';



$oneDrive = new OneDrive($token);

//@@getting files inside folder
// $response = $oneDrive->getFilesInsideFolder('4C62E5C68408E692!123');

//@@getting files inside folder by folder name
// $response = $oneDrive->getFilesByFolderName('CS10');
// var_dump($response);
//@@Download file
// $response = $oneDrive->downloadFile('citizenship.jpg');

//@@get all files and folder
// $response = $oneDrive->getFilesAndFolders();

// // //@@get single file
// // $response = $oneDrive->getFile('4C62E5C68408E692!126');
// $var = json_decode(json_encode($response), true);

//Delete file
// $response = $oneDrive->deleteFile('4C62E5C68408E692!133');
// var_dump($response);

//@@Upload File
// $file = $_FILES["fileToUpload"]["tmp_name"];
// $fileName = $_FILES["fileToUpload"]["name"];
// $response = $oneDrive->uploadFile($file, $fileName, '4C62E5C68408E692!122');

// $response = $graph->createRequest("PUT", "/drive/root/children/" . $_FILES["fileToUpload"]["name"] . "/content")
//     ->upload($_FILES["fileToUpload"]["tmp_name"]);
// var_dump($response);







// //@@GETTING ACCESS TOKEN PROCESS

// $client = new \GuzzleHttp\Client();
// // $tenantId = 'f8cdef31-a31e-4b4a-93e4-5f571e91255a';
// $clientId = "55464f0d-e064-49ba-bd97-44da9b642756";
// // $clientSecret = "KV_Gfw-FXtXRhdpjdZ33--079ADd7S6Gwu";
// $redirectUrl = 'http://localhost:8000/callback.php';
// // $code = 'M.R3_BAY.e263b05a-fbce-f7fc-333e-9f54df6a5d44';


// //@@Get Code

// $res = $client->get("https://login.live.com/oauth20_authorize.srf?client_id=$clientId&scope=files.readwrite.all&response_type=code&redirect_uri=$redirectUrl");

// var_dump($res->getBody());

//Get Authorization Token
// $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
// $user_token = json_decode($client->request('post', $url, [
//     'form_params' => [
//         'client_id' => $clientId,
//         'client_secret' => $clientSecret,
//         'redirect_uri' => $redirectUrl,
//         'grant_type' => 'authorization_code',
//         'code' => $code,
//     ]
// ])->getBody()->getContents());
// $user_accessToken = $user_token->access_token;
// var_dump($user_accessToken);

// $graph = new Graph();
// $graph->setAccessToken($token);

// $target_dir = "uploads/";









//@UPLOAD File

// $target_file = basename($_FILES["fileToUpload"]["name"]);
// var_dump($target_file);


// Save to uploads folder on server
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
// echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

// $file = $$_FILES['file'];

// var_dump($file);
// Download to server
// https://graph.microsoft.com/v1.0/me/drive/items/4C62E5C68408E692!111


// $target_dir = 'Downloads/';






// var_dump(($response));

// Send download response to client
// header('Content-Description: File Transfer');
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename="' . basename($target_dir . 'Capture.JPG') . '"');
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($target_dir . 'Capture.JPG'));
// flush();
// readfile($target_dir . 'Capture.JPG');
// die();
