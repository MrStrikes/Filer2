<?php

class FilesManager//in progress
{
    public function uploadFile()
    {
        /*if ($_FILES["user_file"]["error"] > 0)
            echo "Return Code: " . $_FILES["user_file"]["error"] . "<br>";*/
        if (isset($_FILES['user_file']))
        {
            $uploaddir = 'upload/' . $_SESSION['username'];
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