<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class OneDrive
{
    public $graph;

    public function __construct($token)
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken($token);
    }

    public function getFilesAndFolders()
    {
        $response = $this->graph->createRequest("GET", "/drive/root/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFile($fileId)
    {
        $response = $this->graph->createRequest("GET", "/me/drive/items/$fileId")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFilesInsideFolder($id)
    {
        $response = $this->graph->createRequest("GET", "/drive/items/$id/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFilesByFolderName($folderName)
    {
        //@TODO drive id should be changed
        // api is like /drives/{drive_id}/root:/{folderName}/{foldername}:/children
        $response = $this->graph->createRequest("GET", "/drives/4c62e5c68408e692/root:/WebsiteImages/$folderName:/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function downloadFile($fileName)
    {
        $target_dir = './downloads/';
        $response = $this->graph->createRequest("GET", "/me/drive/root:/document/$fileName:/content")
            ->download($target_dir . $fileName);
    }

    public function uploadFile($file, $fileName, $folderId)
    {
        $response = $this->graph->createRequest("PUT", "/drive/items/$folderId:/" . $fileName . ':' . "/content")
            ->upload($file);
        return $response;
    }

    public function deleteFile($fileId)
    {
        $response = $this->graph->createRequest("delete", "/me/drive/items/$fileId")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }
}
