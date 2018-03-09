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
                $logs = fopen('logs/error.log', 'a+');
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

    public function removeFile($file)
    {
        $uploaddir = 'upload/' . $_SESSION['username'] . '/';
        unlink("$uploaddir"."$file");
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
}