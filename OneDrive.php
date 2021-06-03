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

    public function getFoldersOfMainDirectory($mainDirectory)
    {
        $response = $this->graph->createRequest("GET", "/drive/root:/$mainDirectory:/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFile($fileId)
    {
        $response = $this->graph->createRequest("GET", "/drive/items/$fileId")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFilesByFolderId($id)
    {
        $response = $this->graph->createRequest("GET", "/drive/items/$id/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getFilesByFolderName($folderName)
    {
        $response = $this->graph->createRequest("GET", "/drive/root:/WebsiteImages/$folderName:/children")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function uploadFile($file, $fileName, $folderId)
    {
        $response = $this->graph->createRequest("PUT", "/drive/items/$folderId:/" . $fileName . ':' . "/content")
            ->upload($file);
        return $response;
    }

    public function deleteFile($fileId)
    {
        $response = $this->graph->createRequest("delete", "/drive/items/$fileId")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
    }

    public function getDeltaToken()
    {
        $response = $this->graph->createRequest("GET", "/drives/b!qr6_XPV0S0qNpOz8TMRdZIB0lzTYzKlJpLDrr8K98DuIA1lgGJHzSr7mwkS_W6_k/root/delta?deltaToken=latest")
            ->setReturnType(Model\User::class)
            ->execute();
        return $response;
        // https://graph.microsoft.com/v1.0/

    }
}
