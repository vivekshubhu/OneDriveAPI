<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

require './AuthToken.php';

class OneDrive
{
    private $graph;
    private $mainDirectory;

    public function __construct($token)
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken($token);
        $this->mainDirectory = 'WebsiteImages';
    }

    public function createFolder($folderName)
    {
        $postData = json_encode([
            "name" => $folderName,
            "folder" => [],
            "@microsoft.graph.conflictBehavior" => "rename"
        ], JSON_FORCE_OBJECT);
        
        try {
            $response = $this->graph->createRequest("POST", "/drive/root:/$this->mainDirectory:/children")->attachBody($postData)
                ->setReturnType(Model\User::class)
                ->execute();
            $responseJsonDecode = json_decode(json_encode($response), true);
        } catch (\Exception $e) {
            echo 'Message:', $e->getMessage();
        }

        return [
            "message" => "Folder Created Successfully", 
            "folder_name" => $responseJsonDecode["name"]
        ];
    }

    public function getFoldersOfMainDirectory()
    {
        try {
            $response = $this->graph->createRequest("GET", "/drive/root:/$this->mainDirectory:/children")
                ->setReturnType(Model\User::class)
                ->execute();
            $folders = json_decode(json_encode($response), true);

            $onlyFolderName = [];

            foreach ($folders as $folder) {
                array_push($onlyFolderName, [
                    'name' => $folder['name'],
                    'id' => $folder['id'],
                ]);
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return $onlyFolderName;
    }

    public function getAllFilesAndFolder()
    {
        try {
            $folders = $this->getFoldersOfMainDirectory();

            $allFilesAndFolders = [];

            foreach ($folders as $key => $folder) {
                $allFilesAndFolders[$key]['product_sku'] = $folder['name'];

                $files = $this->getFilesByFolderName($folder['name']);

                $filteredFiles = [];

                foreach ($files as $file) {
                    array_push($filteredFiles, $file);
                }
                $allFilesAndFolders[$key]['files'] = $filteredFiles;
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return $allFilesAndFolders;
    }

    public function getFile($fileId)
    {
        try {
            $response = $this->graph->createRequest("GET", "/drive/items/$fileId")
                ->setReturnType(Model\User::class)
                ->execute();
            $file = json_decode(json_encode($response), true);
            $formattedFile = $this->__getFormattedFile($file);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return $formattedFile;
    }

    public function getFilesByFolderId($id)
    {
        try {
            $response = $this->graph->createRequest("GET", "/drive/items/$id/children")
                ->setReturnType(Model\User::class)
                ->execute();
            $files = json_decode(json_encode($response), true);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return $this->__getFormattedFiles($files);
    }

    public function getFilesByFolderName($folderName)
    {
        try {
            $response = $this->graph->createRequest("GET", "/drive/root:/$this->mainDirectory/$folderName:/children")
                ->setReturnType(Model\User::class)
                ->execute();
            $files = json_decode(json_encode($response), true);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return $this->__getFormattedFiles($files);
    }

    public function uploadFile($file, $fileName, $folderId)
    {
        try {
            $response = $this->graph->createRequest("PUT", "/drive/items/$folderId:/" . $fileName . ':' . "/content")
                ->upload($file);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
        return true;
    }

    public function deleteFile($fileId)
    {
        try {
            $response = $this->graph->createRequest("delete", "/drive/items/$fileId")
                ->setReturnType(Model\User::class)
                ->execute();
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }

        return true;
    }

    public function __getFormattedFile($file)
    {
        return  [
            'download_url' => $file['@microsoft.graph.downloadUrl'],
            'id' => $file['id'],
            'name' => $file['name'],
            'web_url' => $file['webUrl'],
            'media_type' => $file['file']['mimeType'],
            'size' => $file['size'],
        ];
    }

    public function __getFormattedFiles($files)
    {
        $filteredFiles = [];

        foreach ($files as $file) {
            $formatedFile = $this->__getFormattedFile($file);
            array_push($filteredFiles, $formatedFile);
        }

        return $filteredFiles;
    }
}
