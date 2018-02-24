<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['reppassword']) && !empty($_POST['email'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $reppassword = $_POST['reppassword'];
        $email = $_POST['email'];
    } else {
        if (empty($_POST['login'])){
            $loginError = "login is required";
        }else{
            $login = test_input($_POST["login"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
                $nameErr = "Only letters and numbers allowed";
            }else{
                if(sizeof($login) > 32){
                    $nameErr = "Too long login";
                }
                else{

                }
            }
        }
        }
            header("Location: index.php");
        die();
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
?>