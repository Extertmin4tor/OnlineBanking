<?php
require_once "util.php";
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
require_once("csrf.class.php");


function json_error(){
    $return =  $_POST;
    $return['code'] = 'error';
    echo json_encode($return);
    die();
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $csrf = new csrf();
    $token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    if($csrf->check_valid($_POST['csrf_token'], $_POST['csrf_id'])){
    }
    else{
        echo 'Not Valid';
        die();
    }
    if(!validateValue($_POST['value']) && !validateValue($_POST['from']) && !validateValue($_POST['to'])){
        json_error();
        die();
    }
    $from_acc = test_input($_POST['from']);
    $to_acc = test_input($_POST['to']);
    if($from_acc == $to_acc){
        echo json_error();
    }
    $value = test_input($_POST['value']);
    $db = BD_init();
    try{
        $query = $db->prepare('SELECT * FROM accounts WHERE id = :id AND user_id = :user_id');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':id', $from_acc);
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
    $query->bindParam(':id', $to_acc);
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
    $new_from_val = $value_from - $value;
    $new_to_val = $value_to + $value;
    if($value_from > $value &&$value > 0 ){
        try{
            $query = $db->prepare('UPDATE accounts SET value=:value WHERE id=:id');
            $query->bindParam(':value', $new_from_val);
            $query->bindParam(':id', $from_acc);
            $query->execute();
            $query->bindParam(':value', $new_to_val);
            $query->bindParam(':id', $to_acc);
            $query->execute();
        }
        catch(Exception $e){
            json_error();
           
    }
}else{
    json_error();
}

$return['code'] = 'ok';
$return['value_from'] = $new_from_val;

if($user_id_to == $_SESSION['userid']){
    $return['value_to'] = $new_to_val;
}
save_history($db, $from_acc, $value, $to_acc, "transfer");
echo json_encode($return);
}


function validateValue($value){
    return is_numeric($value) && $value > 0;
}

function save_history($db, $from_acc, $value, $to_acc, $type){
    try{
        $query = $db->prepare('INSERT INTO operations_history (user_id, account_id, value, reciever, date, type) VALUES
        (:user_id, :account_id, :value, :reciever, :date, :type)');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':account_id', $from_acc);
        $query->bindParam(':value', $value);
        $query->bindParam(':reciever', $to_acc);
        $date = date('y.m.d');
        $query->bindParam(':date', $date);
        $query->bindParam(':type', $type);
        $query->execute();
    }
    catch(Exception $e){
        echo $e;
}


}
?>