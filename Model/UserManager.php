<?php

require_once('Cool/DBManager.php');

class UserManager
{
    public function registerUser($user, $firstName, $lastName, $email, $password, $passwordVerify)
    {
        if(isset($user) && isset($firstName)
        && isset($lastName) && isset($email)
        && isset($password) && isset($passwordVerify)
        && isset($_POST['submit'])){
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
}
