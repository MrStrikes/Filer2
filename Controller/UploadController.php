<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        $manager = new FilesManager();
        $sendUserFiles = $manager->uploadFile();
        $arr = [
            'files' => $sendUserFiles,
            'uploaddir' => 'upload/'.$_SESSION['username']
        ];
        return $this->render('upload.html.twig', $arr);
    }
}