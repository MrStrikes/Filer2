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
        } else if (isset($_POST['create_dir'])) {
            if (isset($_POST['dir_name'])) {
                $dirname = $_POST['dir_name'];
                $manager = new FilesManager();
                $manager->createDir($dirname);
                $sendUserFiles = $manager->uploadFile();
                $userDirectory = $manager->userDir($sendUserFiles);
                $arr = [
                    'files' => $sendUserFiles,
                    'dir' => $userDirectory
                ];
                return $this->render('upload.html.twig', $arr);
            }
        } else {
            $manager = new FilesManager();
            $sendUserFiles = $manager->uploadFile();
            $userDirectory = $manager->userDir($sendUserFiles);

            $arr = [
                'files' => $sendUserFiles,
                'uploaddir' => 'upload/'.$_SESSION['username'],
                'dir' => $userDirectory
            ];
            return $this->render('upload.html.twig', $arr);
        }
    }

    public function renameAction()
    {
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

    public function folderAction()
    {
        if (isset($_POST['display_dir'])) {
            $folder = $_POST['display_folder'];
            $manager = new FilesManager();
            $sendUserFiles = $manager-> displayFolderContent($folder);
            $arr = [
                'folder' => $folder,
                'files' => $sendUserFiles
            ];
            return $this->render('folder.html.twig', $arr);
            } else {
            $arr = [
                'folder' => $_POST['display_folder']
            ];
            return $this->render('folder.html.twig', $arr);
        }
    }
}