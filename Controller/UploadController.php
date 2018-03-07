<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        if(isset($_SESSION['username'])){
            $manager = new FilesManager();
            $sendUserFiles = $manager->uploadFile();
            $arr = [
                'files' => $sendUserFiles
            ];
            return $this->render('upload.html.twig', $arr);
        }
    }
}