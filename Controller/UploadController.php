<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        $manager = new FilesManager();
        $sendUserFiles = $manager->uploadFile();
        return $this->render('upload.html.twig');
    }
}