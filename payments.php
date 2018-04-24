<?php
require_once "util.php";
session_start();

function json_error(){
    $return =  $_POST;
    $return['code'] = 'error';
    echo json_encode($return);
    die();
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(!validateValue($_POST['code']) && !validateValue($_POST['value']) && !validateValue($_POST['from']) && !validateValue($_POST['to'])){
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
            die();
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
        $date = date('Y-m-d H:i:s');
        $query->bindParam(':date', $date);
        $query->bindParam(':type', $type);
        $query->execute();
    }
    catch(Exception $e){
        json_error();
        die();
}
}
function validateValue($value){
    return is_numeric($value) && $value > 0;
}

?>