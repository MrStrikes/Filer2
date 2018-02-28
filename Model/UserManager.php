<?php

require_once('Cool/DBManager.php');

class UserManager
{
    public function registerUser($user, $firstName, $lastName, $email, $password, $passwordVerify)
    {
        if(isset($user) && isset($firstName)
        && isset($lastName) && isset($email)
        && isset($password) && isset($passwordVerify)
        && isset($_POST['submit']))
        {
            if($password === $passwordVerify){
                $hashedPwd = hash(md5, $password);
                $dbm = DBManager::getInstance();
                $pdo = $dbm->getPdo();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $pdo->prepare("INSERT INTO `Users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`) 
                VALUES (NULL, :user, :firstName, :lastName, :email, :psw)");
                $stmt->bindParam(':user', $user);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':psw', $hashedPwd);

                $stmt->execute();
            }
        }
    }
    public function loginUser($user, $password)
    {
        if(isset($user) && isset($password)
        && isset($_POST['submit']))
        {
            $errors = '';
            $hashedPwd = hash(md5, $password);
            $dbm = DBManager::getInstance();
            $pdo = $dbm->getPdo();

            $stmt = $pdo->prepare("SELECT * FROM Users 
            WHERE username = :username AND password = :pwd");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':pwd', $hashedPwd);

            $stmt->execute();
            $result = $stmt->fetchAll();
            if ($user === NULL){
                $errors = 'Invalid username or password';
            } else {
                $_SESSION['username'] = $user[':username'];
            }
            return $result;
        }
    }
}
