<?php
require_once "util.php";
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);

if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $card_type_1 = $_POST['card_type_1'];
    $card_type_2 = $_POST['card_type_2'];
    if (!empty($card_type_1) && !empty($card_type_2)){
        $card_type_1 = test_input($card_type_1);
        $card_type_2 = test_input($card_type_2);
        $db = BD_init();
        $query = $db->prepare('INSERT INTO accounts (user_id, value, card_type, card_type_2) VALUES (:userid, :value, :card_type_1, :card_type_2)');
        $query->bindParam(':userid', $_SESSION['userid']);
        $money = 1000;
        $query->bindParam(':value', $money);
        $query->bindParam(':card_type_1', $card_type_1);
        $query->bindParam(':card_type_2', $card_type_2);
        $query->execute();

        $return = $_POST;
        $return['code'] = 'ok';
        echo json_encode($return);
    }
    else{
        echo 'error';
        die();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>