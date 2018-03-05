<?php

class FilesManager//in progress
{
    public function uploadFile()
    {
        /*if ($_FILES["user_file"]["error"] > 0)
            echo "Return Code: " . $_FILES["user_file"]["error"] . "<br>";*/
        if (isset($_FILES['user_file']))
        {
            if (file_exists("upload/" . $_FILES["user_file"]["name"]))
                echo $_FILES["user_file"]["name"] . " already exists. ";
            else
            {
                echo $_FILES["user_file"]["name"] . " has been uploaded. <br>";
                if (!file_exists('upload/' . $_SESSION['username'])) {
                    mkdir('upload/' . $_SESSION['username'], 0777, true);
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                        "upload/" . $_SESSION['username'] ."/" . $_FILES["user_file"]["name"]);
                } else {
                    move_uploaded_file($_FILES["user_file"]["tmp_name"],
                        "upload/" . $_SESSION['username'] ."/" . $_FILES["user_file"]["name"]);
                }
            }
        }

    }
}