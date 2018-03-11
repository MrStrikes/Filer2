<?php

class FilesManager
{
    public function uploadFile()
    {
        $uploaddir = 'upload/' . $_SESSION['username'];
        if (isset($_FILES['user_file']))
        {
            if (file_exists($uploaddir.'/'.$_FILES["user_file"]["name"])){
                echo $_FILES["user_file"]["name"] . " already exists. ";
                $logs = fopen('logs/security.log', 'a+');
                fwrite($logs, $_SESSION['username']." tried to upload ".$_FILES["user_file"]["name"]." but it already exists\n");
                fclose($logs);
            } else {
                echo $_FILES["user_file"]["name"] . " has been uploaded. <br>";
                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                    $uploaddir."/". $_FILES["user_file"]["name"]);
                    $logs = fopen('logs/access.log', 'a+');
                    fwrite($logs, 'A new directory has been created by '.$_SESSION['username'].' and he uploaded a file named '.$_FILES['user_file']['name']."\n");
                    fclose($logs);
                } else {
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                    $uploaddir."/" . $_FILES["user_file"]["name"]);
                    $logs = fopen('logs/access.log', 'a+');
                    fwrite($logs, $_SESSION['username'].' just uploaded a file called '.$_FILES['user_file']['name']."\n");
                    fclose($logs);
                }
            }
        }
        $results = array_diff(scandir($uploaddir), array(".", "..",));
        return $results;
    }

    public function isDirectory($file)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        if (!is_dir($uploaddir . $file)) {
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just deleted the file '.$file."\n");
            fclose($logs);
            return $this->removeFile($file);
        } else {
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just deleted the directory '.$file."\n");
            fclose($logs);
            return $this->deleteDir($file);
        }
    }

    private function removeFile($file)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        unlink("$uploaddir"."$file");
    }

    public function renameFile($oldFilename, $newFilename)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        $oldPath = $uploaddir.$oldFilename;
        $newPath = $uploaddir.$newFilename;
        rename($oldPath, $newPath);
    }
    
    public function downloadFile($file)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
            $userFile = $uploaddir . $file;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($userFile) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($userFile));
            readfile($userFile);
    }

    public function createDir($dirname)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        $userDir =$uploaddir . $dirname . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true);
            $logs = fopen('logs/access.log', 'a+');
            fwrite($logs, $_SESSION['username'].' just created the directory: '.$dirname."\n");
            fclose($logs);
        } else {
            echo $dirname . " already exists. ";
            $logs = fopen('logs/security.log', 'a+');
            fwrite($logs, $_SESSION['username']." tried to create the directory: ".$dirname." but it already exists\n");
            fclose($logs);
        }
        return $userDir;
    }

    private function deleteDir($userDir)
    {
        $dirPath = 'upload/' . $_SESSION['username'] . '/' . $userDir .'/';

            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
        rmdir($dirPath);
    }

    public function editFile($file, $content)
    {
        $fileInfo = pathinfo($file);
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        if($fileInfo['extension'] === 'txt'){
            $datas = file_get_contents($uploaddir.$file);
            if(isset($_POST['btnEdit'])){
                return file_put_contents($uploaddir.$file, $content);
            }
            return $datas;
        } else {
            $errors = 'This is not the good file extension';
            return $errors;
        }
    }

    public function userDir($userdir)
    {
        $array = [];
        foreach ($userdir as $dir) {
            $dirPath = 'upload/' . $_SESSION['username'] . '/' . $dir .'/';
            if (is_dir($dirPath)) {
                array_push($array, $dir);
            }
        }
        return $array;
    }

    public function displayFolderContent($dir)
    {
        $uploaddir = 'upload/' . $_SESSION['username'];
        $userdir = $uploaddir . '/' . $dir;
        $results = array_diff(scandir($userdir), array(".", "..",));
        return $results;
    }

    public function userDir($userdir)
    {
        $array = [];
        foreach ($userdir as $dir) {
            $dirPath = 'upload/' . $_SESSION['username'] . '/' . $dir .'/';
            if (is_dir($dirPath)) {
                array_push($array, $dir);
            }
        }
        return $array;
    }

    public function displayFolderContent($dir)
    {
        $uploaddir = 'upload/' . $_SESSION['username'];
        $userdir = $uploaddir . '/' . $dir;
        $results = array_diff(scandir($userdir), array(".", "..",));
        return $results;
    }

    public function changeDir($oldFilePath, $newFilePath, $file)
    {
        rename($oldFilePath.'/'.$file,$newFilePath.'/'.$file);
        $logs = fopen('logs/access.log', 'a+');
        fwrite($logs, $_SESSION['username'].' just move the file: '.$file.' from: '.$oldFilePath.' to: '.$newFilePath."\n");
        fclose($logs);
    }
}