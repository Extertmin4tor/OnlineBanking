<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        echo "ok";

    } else {
        if (empty($_POST['login'])){
            $loginError = "login is required";
            die();
        }else{
            $login = test_input($_POST["login"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
                $loginErr = "Only letters and numbers allowed";
                die();
            }else{
                if(sizeof($login) > 16 && sizeof($login) < 4){
                    $loginErr = "Wrong length";
                    die();
                }
            }
        }
        if (empty($_POST['password'])){
            $passError = "password is required";
            die();
        }else{
            $pass = test_input($_POST["password"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
                $passErr = "Only letters and numbers allowed";
                die();
            }else{
                if(sizeof($password) > 32 && sizeof($password) < 8 ){
                    $passErr = "Wrong length";
                    die();
                }
            }
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            die();
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
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