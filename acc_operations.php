<?php
require_once "util.php";
ini_set('session.gc_maxlifetime', 300);
ini_set('session.cookie_lifetime', 0);
session_start();

function json_error(){
    $return =  $_POST;
    $return['code'] = 'error';
    echo json_encode($return);
    die();
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(!validateValue($_POST['value']) && !validateValue($_POST['from']) && !validateValue($_POST['to'])){
        json_error();
        die();
    }
    $db = BD_init();
    try{
        $query = $db->prepare('SELECT * FROM accounts WHERE id = :id AND user_id = :user_id');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':id', $_POST['from']);
        $query->execute();
    } catch(Exception $e){
        json_error();
        die();
    }
    $value_from = 0;
    if ($query->rowCount() == 0) {
        json_error();
        die();
    } else {
        $selected = $query->fetchAll();
        foreach ($selected as $row) {
            $value_from  = $row['value'];
        }
    }
    $query = $db->prepare('SELECT * FROM accounts WHERE id = :id');
    $query->bindParam(':id', $_POST['to']);
    $query->execute();
    $value_to = 0;
    $user_id_to = 0;
    if ($query->rowCount() == 0) {
        json_error();
        die();
    }else {
        $selected = $query->fetchAll();
        foreach ($selected as $row) {
            $value_to  = $row['value'];
            $user_id_to = $row['user_id'];
        }
    } 
    $new_from_val = $value_from - $_POST['value'];
    $new_to_val = $value_to + $_POST['value'];
    if($value_from > $_POST['value'] && $_POST['value'] > 0 ){
        try{
            $query = $db->prepare('UPDATE accounts SET value=:value WHERE id=:id');
            $query->bindParam(':value', $new_from_val);
            $query->bindParam(':id', $_POST['from']);
            $query->execute();
            $query->bindParam(':value', $new_to_val);
            $query->bindParam(':id', $_POST['to']);
            $query->execute();
        }
        catch(Exception $e){
            json_error();
            die();
    }
}else{
    json_error();
}

$return['code'] = 'ok';
$return['value_from'] = $new_from_val;

if($user_id_to == $_SESSION['userid']){
    $return['value_to'] = $new_to_val;
}
save_history($db, "transfer");
echo json_encode($return);
}


function validateValue($value){
    return is_numeric($value) && $value > 0;
}

function save_history($db, $type){
    try{
        $query = $db->prepare('INSERT INTO operations_history (user_id, account_id, value, reciever, date, type) VALUES
        (:user_id, :account_id, :value, :reciever, :date, :type)');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':account_id', $_POST['from']);
        $query->bindParam(':value', $_POST['value']);
        $query->bindParam(':reciever', $_POST['to']);
        $date = date('y.m.d');
        $query->bindParam(':date', $date);
        $query->bindParam(':type', $type);
        $query->execute();
    }
    catch(Exception $e){
        json_error();
        die();
}
}
?>