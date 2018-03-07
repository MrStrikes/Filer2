<?php

class FilesManager
{
    public function uploadFile()
    {
        $uploaddir = 'upload/' . $_SESSION['username'];

        if (isset($_FILES['user_file']))
        {
            if (file_exists("upload/" . $_FILES["user_file"]["name"]))
                echo $_FILES["user_file"]["name"] . " already exists. ";
            else
            {
                echo $_FILES["user_file"]["name"] . " has been uploaded. <br>";
                if (!file_exists($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                        $uploaddir."/". $_FILES["user_file"]["name"]);
                } else {
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                        "upload/" . $_SESSION['username'] ."/" . $_FILES["user_file"]["name"]);
                }
            }
        }
        $results = array_diff(scandir($uploaddir), array(".", "..",));
        return $results;
    }
}