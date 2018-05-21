<?php
require_once "util.php";
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
include("csrf.class.php");
include("simple-php-captcha.php");
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Crypt/RSA.php');
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $login = "";
    $password = "";
    $rsa = new Crypt_RSA();
    switch($_POST['command']){
        case "getpublic":
            echo $publicKey;
            exit();  break;
        case "decrypt":
            $csrf = new csrf();
            $token_id = $csrf->get_token_id();
            $token_value = $csrf->get_token($token_id);
            if($csrf->check_valid($_POST['csrf_token'], $_POST['csrf_id'])){
            }
            else{
                echo 'Not Valid';
                die();
            }
            if(isset($_SESSION['counter'])){
                if($_SESSION['counter'] > 3){
                    echo "restrict";
                    die();
                }
             }
            $rsa->loadKey($privateKey); 
            $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $login =  $rsa->decrypt(base64_decode($_POST['login']));
            $password = $rsa->decrypt(base64_decode($_POST['password']));
            break;
        case "captcha":
            captcha();
            break;
    }
    if (!empty($login) && !empty($password)) {
        $login = test_input($login);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $loginErr = "Only letters and numbers allowed";
            captcha();
            die();
        }
        else
        {
            if(strlen($login) > 16 && strlen($login) < 4){
                $loginErr = "Wrong length";
                captcha();
                die();
            }
        }
        $pass = test_input($password);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $passErr = "Only letters and numbers allowed";
            captcha();
            die();
        }
        else
        {
            if(strlen($pass) > 32 && strlen($pass) < 8 ){
                $passErr = "Wrong length";
                captcha();
                die();
            }
        }
        $dbh = BD_init();
        $query = $dbh->prepare('SELECT password, id FROM users WHERE login=:login');
        $query->bindParam(':login', $login);
        $query->execute();
        $selected = $query->fetchAll();
        if($query->rowCount()==0){
            captcha();
            die();
        }
        else
        {
            foreach ($selected as $row) {
                if (!password_verify($pass, $row['password'])) {
                    captcha();
                    die();
                }
                 else
                {
                    echo "ok";
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['login'] = $login;

                }
            }
        }

    }
    else
    {
        if (empty($_POST['login'])){
            $loginError = "login is required";
            captcha();
            die();
        }
        else
        {
            if (empty($_POST['password'])){
                $passError = "password is required";
                captcha();
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

    function captcha(){
        if(!isset($_SESSION['counter'])){
            $_SESSION['counter'] = 1;
            echo($_SESSION['counter']);
            die();
        }
        else{
            if($_SESSION['counter'] > 2){
                if($_SESSION['counter'] == 3){
                    $_SESSION['counter']++;
                    echo "restrict";
                    die();
                }
                else{
                try{
                    $captcha = test_input($_POST["captcha"]);
                    if($captcha != $_SESSION['captcha']['code']){
                        echo "restrict";
                        die();
                    }
                    else{
                        unset($_SESSION['counter']);
                        echo "ok";
                        die();
                }
              
            }
            catch(Exception $e){
                echo "restrict";
                    die();
            }  
            }
        }
        else{
            $_SESSION['counter']++;
            echo($_SESSION['counter']);
            die();
        }  
        }
    }
?>