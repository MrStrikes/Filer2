<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        $manager = new FilesManager();
        if (isset($_POST['remove'])) {
            $file = $_POST['hiddenFile'];
            $manager->removeFile($file);
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just deleted the file '.$file."\n");
            fclose($logs);
            return $this->redirect('?action=upload');
        } else if (isset($_POST['download'])) {
            $file = $_POST['hiddenDownloadFile'];
            $manager = new FilesManager();
            $manager->downloadFile($file);
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just downloaded the file '.$file."\n");
            fclose($logs);
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

    public function renameAction()
    {
        $_POST['newName'] = '';
        $_POST['newName'] = '';
        if(isset($_POST['newName']) && isset($_POST['oldName']) && isset($_POST['hiddenFile'])) {
            $hiddenName = $_POST['hiddenFile'];
            $oldName = $_POST['oldName'];
            $newName = $_POST['newName'];
            $manager = new FilesManager();
            $arr = [
                'oldName' => $hiddenName
            ];
            $manager->renameFile($oldName, $newName);
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just renamed the file: \"' .$oldName.  '\" into: \"'.$newName."\" \n");
            fclose($logs);
            return $this->render('rename.html.twig', $arr);
        }
        $hiddenName = $_POST['hiddenFile'];
        $arr = [
            'oldName' => $hiddenName
        ];
        return $this->render('rename.html.twig', $arr);
    }
}