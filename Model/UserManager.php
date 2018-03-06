<?php

require_once('Cool/DBManager.php');

class UserManager
{
    public function registerUser($user, $firstName, $lastName, $email, $password, $passwordVerify)
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

    public function loginUser($user, $password)
    {
        $hashedPwd = hash(md5, $password);
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();

        $stmt = $pdo->prepare("SELECT * FROM Users 
        WHERE username = :username AND password = :pwd");
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':pwd', $hashedPwd);

        $stmt->execute();
        $result = $stmt->fetchAll();
        if (count($result) < 1 || count($result) >1){
            $errors = 'Invalid username or password';
            return $errors;
        } else {
            $_SESSION['username'] = $user;
            return $user;
        }
    }
}
