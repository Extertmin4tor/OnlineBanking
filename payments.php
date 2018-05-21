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

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $csrf = new csrf();
    $token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
    if($csrf->check_valid($_POST['csrf_token'], $_POST['csrf_id'])){
    }
    else{
        json_error();
        
    }
    if(!validateValue($_POST['code']) && !validateValue($_POST['value']) && !validateValue($_POST['from']) && !validateValue($_POST['to'])){
        json_error();
    }
    $db = BD_init();
    try{
        $query = $db->prepare('SELECT * FROM accounts WHERE id = :id AND user_id = :user_id');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':id', $_POST['from']);
        $query->execute();
    } catch(Exception $e){
        json_error();
    }
    $value_from = 0;
    if ($query->rowCount() == 0) {
        json_error();
    } else {
        $selected = $query->fetchAll();
        foreach ($selected as $row) {
            $value_from  = $row['value'];
        }
    }
    
    $new_from_val = $value_from - $_POST['value'];
    if($value_from > $_POST['value'] && $_POST['value'] > 0 ){
        try{
            $query = $db->prepare('UPDATE accounts SET value=:value WHERE id=:id');
            $query->bindParam(':value', $new_from_val);
            $query->bindParam(':id', $_POST['from']);
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

switch($_POST['code']){
    case('mobile'):{
        save_history($db, "mobile payment");
        break;
    }

    case('utility'):{
        save_history($db, "utility payment");
        break;
    }
}
echo json_encode($return);
}

function save_history($db, $type){
    try{
        $query = $db->prepare('INSERT INTO operations_history (user_id, account_id, value, reciever, date, type) VALUES
        (:user_id, :account_id, :value, :reciever, :date, :type)');
        $query->bindParam(':user_id', $_SESSION['userid']);
        $query->bindParam(':account_id', $_POST['from']);
        $query->bindParam(':value', $_POST['value']);
        $query->bindParam(':reciever', $_POST['to']);
        $date = date('y-m-d');
        $query->bindParam(':date', $date);
        $query->bindParam(':type', $type);
        $query->execute();
    }
    catch(Exception $e){
        json_error();

}
}
function validateValue($value){
    return is_numeric($value) && $value > 0;
}

?>