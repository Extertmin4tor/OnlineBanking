<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}

$db = BD_init();
$query = $db->prepare('SELECT id FROM users  WHERE login = :login');
$query->bindParam(':login', $_SESSION['userid']);
$query->execute();
$user_id = null;
if ($query->rowCount() == 0) {
    print "Error!";
} else {
    $selected = $query->fetchAll();
    foreach ($selected as $row) {
        $user_id = $row['id'];
    }
}

$query = $db->prepare('INSERT INTO accounts (user_id, value) VALUES (:userid, :value)');
$query->bindParam(':userid', $user_id);
$zero = 0;
$query->bindParam(':value', $zero);
$query->execute();

$query = $db->prepare('SELECT id FROM accounts WHERE user_id = :user_id ORDER BY id DESC LIMIT 1');
$query->bindParam(':userid', $user_id);
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

function BD_init()
{
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=m4banking;charset=utf8', "vhshunter", "123789456");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>