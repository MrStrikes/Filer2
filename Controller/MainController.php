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
        && isset($_POST['password']) && isset($_POST['passwordVerify'])
        && isset($_POST['submit'])){
            $username = htmlentities($_POST['username']);
            $firstName = htmlentities($_POST['firstName']);
            $lastName = htmlentities($_POST['lastName']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $passwordVerify = htmlentities($_POST['passwordVerify']);
            $manager = new UserManager();
            $sendUserDatas = $manager->registerUser($username, $firstName, $lastName, $email, $password, $passwordVerify);
        }
        return $this->render('register.html.twig');
    }

    public function loginAction()
    {
        if(isset($_POST['username']) && isset($_POST['psw'])
        && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $username = htmlentities($_POST['username']);
            $password = $_POST['psw'];
            $manager = new UserManager();
            $getUserData = $manager->loginUser($username, $password);
            $arr = [
                'user' => $_SESSION['username']
            ];
            return $this->render('login.html.twig', $arr);
        } else {
            return $this->render('login.html.twig');
        }
    }

    public function logoutAction(){
        session_destroy();
        $this->redirect('?action=home');
    }
}