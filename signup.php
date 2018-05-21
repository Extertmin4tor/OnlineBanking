<?php
require_once "util.php";
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
include("simple-php-captcha.php");
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Crypt/RSA.php');
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $login = "";
    $password = "";
    $email = "";
    $rsa = new Crypt_RSA();
    switch($_POST['command']){
        case "getpublic":
            echo $publicKey;
            exit();  break;
        case "decrypt":
            $rsa->loadKey($privateKey); 
            $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $login =  $rsa->decrypt(base64_decode($_POST['login']));
            $password = $rsa->decrypt(base64_decode($_POST['password']));
            $email = $rsa->decrypt(base64_decode($_POST['email']));
            break;
    }
    if (!empty($login) && !empty($password) && !empty($email) && !empty($_POST["captcha"])) {
        $login = test_input($login);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $loginErr = "Only letters and numbers allowed";
            die();
        }else{
            if(strlen($login) > 16 && strlen($login) < 4){
                $loginErr = "Wrong length";
                die();
            }
        }
        $pass = test_input($password);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $passErr = "Only letters and numbers allowed";
            die();
        }else{
            if(strlen($pass) > 32 && strlen($pass) < 8 ){
                $passErr = "Wrong length";
                die();
            }
        }
        $email = test_input($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            die();
        }
        $captcha = test_input($_POST["captcha"]);
        if($captcha != $_SESSION['captcha']['code']){
            $captchaErr = "Captcha is wrong";
            die();
        }
        $dbh = BD_init();
        $query = $dbh->prepare('SELECT id FROM users WHERE email=:email or login=:login');
        $query->bindParam(':email', $email);
        $query->bindParam(':login', $login);
        $query->execute();
        if($query->rowCount()==0){
            try {
                $query = $dbh->prepare('INSERT INTO users (login, password, email) VALUES (:login,  :password ,:email)');
                $query->bindParam(':login', $login, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $password = password_hash($pass, PASSWORD_DEFAULT);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                $query->execute();
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
            echo "ok";
            $query = $dbh->prepare('SELECT id FROM users WHERE email=:email or login=:login');
            $query->bindParam(':email', $email);
            $query->bindParam(':login', $login);
            $query->execute();
            $_SESSION['userid'] =  $query->fetchColumn(0);
            $_SESSION['login'] = $login;

        }
        else
        {
            echo "Login or email already in use!";
            die();
        }
        $dbh = null;
        $query = null;
    }

    } else {
        if (empty($_POST['login'])){
            $loginError = "login is required";
            die();
        }else{
            if (empty($_POST['password'])){
                $passError = "password is required";
                die();
            }else{
                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                    die();
                }
            }
        }

    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}


?>