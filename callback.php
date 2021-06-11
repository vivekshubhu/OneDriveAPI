<?php

// session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . './OneDriveDelta.php';
require __DIR__ . './AuthToken.php';

$validToken = isset($_GET['validationToken']) ? $_GET['validationToken'] : '';
// webo_custom_logger('validation', $validToken);
if ($validToken) {
    header('Content-Type: text/plain');
    http_response_code(200);
    print $validToken;
    exit;
} else {
    $bodytxt = file_get_contents('php://input');

    $token = getAuthToken();

    // if (!isset($_SESSION['deltaToken'])) {
    //     setDeltaTokenInSession();
    //     webo_custom_logger('delta', $_SESSION['deltaToken']);
    // }

    $arr = include './deltaToken.php';

    $oneDriveDelta = new OneDriveDelta();

    //previous delta token passed to get latest changed file
    $changedFiles = $oneDriveDelta->getChangedFile($arr['deltaToken']);

    webo_custom_logger('event', $changedFiles);

    $filteredChangedArray = array_filter($changedFiles, function ($item) {
        return array_key_exists('file', $item) && !array_key_exists('deleted', $item);
    });

    $filteredDeletedFileIds = array_filter($changedFiles, function ($item) {
        return array_key_exists('deleted', $item);
    });

    $changedFolderNames = [];
    $deletedFileIds = [];

    foreach ($filteredChangedArray as $arr) {
        $path = $arr['parentReference']['path'];
        $folderName = end(explode('/', $path));
        if (!in_array($folderName, $changedFolderNames)) {
            array_push($changedFolderNames, $folderName);
        }
    }

    foreach ($filteredDeletedFileIds as $arr) {
        if (!in_array($arr['id'], $filteredDeletedFileIds)) {
            array_push($deletedFileIds, $arr['id']);
        }
    }

    // setDeltaTokenInSession();
    webo_custom_logger('event', $changedFolderNames);
    webo_custom_logger('event', $deletedFileIds);
    file_put_contents('./deltaToken.php', '<?php return $arr = ' . var_export(['deltaToken' => getDeltaToken()], true) . ';');

    return ['changedFolderNames' => $changedFolderNames, 'deletedFileIds' => $deletedFileIds];
}

function setDeltaTokenInSession()
{
    $deltaLinkToken = getDeltaToken();
    webo_custom_logger('delta', $deltaLinkToken);
    $_SESSION['deltaToken'] = $deltaLinkToken;
}

function getDeltaToken()
{
    $oneDriveDelta = new OneDriveDelta();
    return $oneDriveDelta->getDeltaLinkToken();
}

function webo_custom_logger($fileName, $data)
{
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    $filename = 'logs/' . $fileName . '/' . $current_date . '.log';
    $dirname = dirname($filename);
    if (!is_dir($dirname)) {
        mkdir($dirname, 0755, true);
    }
    $fp = fopen($filename, 'a'); //opens file in append mode
    if (gettype($data) != 'string') {
        $data = json_encode($data);
    }
    $content = "[" . $current_date . ' ' . $current_time . "] " . $data . "\n";
    fwrite($fp, $content);
    fclose($fp);
}

function getAuthToken()
{
    $authToken = new AuthToken();
    return $authToken->getToken();
}
