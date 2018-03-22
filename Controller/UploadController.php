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
        } else if (isset($_POST['create_dir'])) {
            if (isset($_POST['dir_name'])) {
                $dirname = str_replace('/', '', $_POST['dir_name']);
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
        } else if(isset($_POST['change_folder'])) {
            $file = $_POST['hiddenChangeFile'];
            $folder = $_POST['directory'];
            $oldFilePath = 'upload/' . $_SESSION['username'];
            $newFilePath = $oldFilePath.'/'.$folder;
            $manager = new FilesManager();
            $manager->changeDir($oldFilePath, $newFilePath, $file);
            return $this->redirect('?action=upload');
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
    }

    public function renameAction()
    {
        if(empty($_SESSION['username'])){
            return $this->redirect('?action=home');
        } else {
            if(isset($_POST['oldName']) && isset($_POST['newName'])){
                $oldName = $_POST['oldName'];
                $newName = str_replace('/', '', $_POST['newName']);
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

    public function editAction(){
        $hiddenFile = $_POST['editHidden'];
        $manager = new FilesManager();
        $datas = $manager->editFile($hiddenFile, $_POST['edit-file']);
        $arr = [
            'contents' => $datas,
            'name' => $hiddenFile
        ];
        return $this->render('edit.html.twig', $arr);
    }
    
    public function folderAction()
    {
        if (empty($_SESSION['username'])) {
            return $this->redirect('?action=home');
        } else if (isset($_POST['display_dir'])) {
            $folder = $_POST['display_folder'];
            $manager = new FilesManager();
            $sendUserFiles = $manager->displayFolderContent($folder);
            $userDirectory = $manager->userDir($sendUserFiles);
            $arr = [
                'folder' => $folder,
                'files' => $sendUserFiles,
                'dir' => $userDirectory
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