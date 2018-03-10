<?php

require_once('Cool/BaseController.php');
require_once('Model/FilesManager.php');


class UploadController extends BaseController
{
    public function uploadAction()
    {
        if(empty($_SESSION['username'])){
            return $this->redirect('?action=home');
        } else {
            $manager = new FilesManager();
            if (isset($_POST['remove'])) {
                $file = $_POST['hiddenFile'];
                    $manager->isDirectory($file);
                    return $this->redirect('?action=upload');
            } else if (isset($_POST['download'])) {
                $file = $_POST['hiddenDownloadFile'];
                $manager = new FilesManager();
                $manager->downloadFile($file);
                $logs = fopen('logs/access.log', 'a+');
                fwrite($logs, $_SESSION['username'].' just downloaded the file '.$file."\n");
                fclose($logs);
                return $this->redirect('?action=upload');
            } else if (isset($_POST['create_dir'])) {// DO A <select> TO CHOSE WHAT DIR YOU CHOSE AND DISPLAY FILES IN THIS DIR
                if (isset($_POST['dir_name'])) {
                    $dirname = $_POST['dir_name'];
                    $manager = new FilesManager();
                    $manager->createDir($dirname);
                    $logs = fopen('logs/access.log', 'a+');
                    fwrite($logs, $_SESSION['username'].' just created the directory: '.$dirname."\n");
                    fclose($logs);
                    return $this->redirect('?action=upload');
                }
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

    public function renameAction()
    {
        if(empty($_SESSION['username'])){
            return $this->redirect('?action=home');
        } else {
            if(isset($_POST['oldName']) && isset($_POST['newName'])){
                $oldName = $_POST['oldName'];
                $newName = $_POST['newName'];
                $manager = new FilesManager();
                $manager->renameFile($oldName, $newName);
                $logs = fopen('logs/access.log', 'a+');
                fwrite($logs, $_SESSION['username'].' just renamed the file: \''.$oldName.'\' into: \''.$newName."'\n");
                fclose($logs);
                return $this->redirect('?action=upload');
            } else {
                $arr = [
                    'oldName' => $_POST['hiddenFile']
                ];
                return $this->render('rename.html.twig', $arr);
            }
        }
    }
}