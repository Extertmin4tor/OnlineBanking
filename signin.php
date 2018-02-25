<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $login = test_input($_POST["login"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $loginErr = "Only letters and numbers allowed";
            die();
        }else{
            if(strlen($login) > 16 && strlen($login) < 4){
                $loginErr = "Wrong length";
                die();
            }
        }
        $pass = test_input($_POST["password"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            $passErr = "Only letters and numbers allowed";
            die();
        }else{
            if(strlen($pass) > 32 && strlen($pass) < 8 ){
                $passErr = "Wrong length";
                die();
            }
        }
        $dbh = BD_init();
        $query = $dbh->prepare('SELECT password FROM users WHERE login=:login');
        $query->bindParam(':login', $login);
        $query->execute();
        $selected = $query->fetchAll();
        if($query->rowCount()==0){
            echo "Access denied!";
            die();
        }else {
            foreach ($selected as $row) {
                if (password_verify($pass, $row['password'])) {
                    echo "Access denied!";
                    die();
                } else {
                    echo "ok";
                    $_SESSION['userid'] = $login;
                    //header("Location: personal.php");
                }
            }
        }

    } else {
        if (empty($_POST['login'])){
            $loginError = "login is required";
            die();
        }else{
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

    function BD_init(){
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=m4banking',"vhshunter","123789456");
            return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    }
?>