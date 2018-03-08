<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        if (isset($_POST['remove'])) {
            $file = $_POST['hiddenFile'];
            $manager = new FilesManager();
            $manager->removeFile($file);
            return $this->redirect('?action=upload');

        } else {
            $manager = new FilesManager();
            $sendUserFiles = $manager->uploadFile();
            $arr = [
                'files' => $sendUserFiles,
                'uploaddir' => 'upload/'.$_SESSION['username']
            ];
            return $this->render('upload.html.twig', $arr);
        }
    }
}