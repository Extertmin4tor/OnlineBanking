<?php
require_once "util.php";
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}

$db = BD_init();


$query = $db->prepare('INSERT INTO accounts (user_id, value) VALUES (:userid, :value)');
$query->bindParam(':userid', $_SESSION['userid']);
$zero = 0;
$query->bindParam(':value', $zero);
$query->execute();

$query = $db->prepare('SELECT id FROM accounts WHERE user_id = :userid ORDER BY id DESC LIMIT 1');
$query->bindParam(':userid', $_SESSION['userid']);
$query->execute();
$id = 0;
if ($query->rowCount() == 0) {
    print "Error!";
} else {
    $selected = $query->fetchAll();
    foreach ($selected as $row) {
        $id = $row['id'];
    }
}

$return = $_POST;
$return['code'] = 'ok';
$return['id'] = $id;

echo json_encode($return);

?>