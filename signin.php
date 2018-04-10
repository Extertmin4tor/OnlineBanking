<?php
require_once "util.php";
session_start();
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
            $rsa->loadKey($privateKey); 
            $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $login =  $rsa->decrypt(base64_decode($_POST['login']));
            $password = $rsa->decrypt(base64_decode($_POST['password']));
            break;
    }
    if (!empty($login) && !empty($password)) {
        $login = test_input($login);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $loginErr = "Only letters and numbers allowed";
            die();
        }
        else
        {
            if(strlen($login) > 16 && strlen($login) < 4){
                $loginErr = "Wrong length";
                die();
            }
        }
        $pass = test_input($password);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $passErr = "Only letters and numbers allowed";
            die();
        }
        else
        {
            if(strlen($pass) > 32 && strlen($pass) < 8 ){
                $passErr = "Wrong length";
                die();
            }
        }
        $dbh = BD_init();
        $query = $dbh->prepare('SELECT password, id FROM users WHERE login=:login');
        $query->bindParam(':login', $login);
        $query->execute();
        $selected = $query->fetchAll();
        if($query->rowCount()==0){
            echo "Access denied!";
            die();
        }
        else
        {
            foreach ($selected as $row) {
                if (!password_verify($pass, $row['password'])) {
                    echo "Access denied!";
                    die();
                }
                 else
                {
                    echo "ok";
                    $_SESSION['userid'] = $row['id'];

                }
            }
        }

    }
    else
    {
        if (empty($_POST['login'])){
            $loginError = "login is required";
            die();
        }
        else
        {
            if (empty($_POST['password'])){
                $passError = "password is required";
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