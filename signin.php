<?php
    if(!empty($_REQUEST['login']) && !empty($_REQUEST['password'])){
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];
        echo "ok";
    }
    else{
        die();
    }


?>