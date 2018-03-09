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
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just deleted the file '.$file."\n");
            fclose($logs);
            return $this->redirect('?action=upload');

        } else if (isset($_POST['download'])){
            $file = $_POST['hiddenDownloadFile'];
            $manager = new FilesManager();
            $manager->downloadFile($file);
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just downloaded the file '.$file."\n");
            fclose($logs);
            return $this->redirect('?action=upload');
        }else {
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