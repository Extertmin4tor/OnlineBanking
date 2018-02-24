<?php
    if(!empty($_REQUEST['login']) && !empty($_REQUEST['password'])){
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];
        echo "ADWDAWDWAD";
    }
    else{
        header("Location: index.php");
        die();
    }


?>