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
        } else {
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
        $hiddenName = $_POST['hiddenFile'];
        $oldName = $_POST['oldName'];
        $newName = $_POST['newName'];
        $manager = new FilesManager();
        $arr = [
            'oldName' => $hiddenName
        ];
        $manager->renameFile($oldName, $newName);
        if(isset($newName) && isset($oldName) && isset($hiddenName))
        {
            return $this->redirect('?action=home');
        }
        return $this->render('rename.html.twig', $arr);
    }
}