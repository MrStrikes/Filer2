<?php

require_once('Cool/BaseController.php');
require_once('Model/UserManager.php');

class MainController extends BaseController
{
    public function homeAction()
    {
        return $this->render('home.html.twig');
    }

    public function registerAction()
    {
        if(isset($_POST['username']) && isset($_POST['firstName'])
        && isset($_POST['lastName']) && isset($_POST['email'])
        && isset($_POST['password']) && isset($_POST['passwordVerify'])){
            $username = $_POST['username'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordVerify = $_POST['passwordVerify'];
            $manager = new UserManager();
            $userDatas = $manager->registerUser($username, $firstName, $lastName, $email, $password, $passwordVerify);
        }
        return $this->render('register.html.twig');
    }
}
