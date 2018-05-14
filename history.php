<?php
require_once "util.php";
ini_set('session.gc_maxlifetime', 300);
ini_set('session.cookie_lifetime', 0);
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal</title>
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/personal.js"></script>
</head>
<body>
<header>
    <div id="wrong-dialog" title="Warning" style="display: none;">
        <p>Something is wrong!</p>
    </div>
    <div id="success-text" title="Done!" style="display: none;">
        <p>Transfer operation completed!</p>
    </div>

    <div id="access-denied-reg-text" title="Access denied!" style="display: none;">
        <p>Wrong login or password</p>
    </div>
    <div id="already-use-reg-text" title="Warning" style="display: none;">
        <p>Sorry, this login or email already in use</p>
    </div>
    <div id="logo-div">
        <a href="index.php"><img src="images/logo.png" class="logo"></a>
    </div>
    <div id="manage-buttons">
            <a href="logout.php">
                <button id="logout" class="button">Log out</button>
            </a>
    </div>
</header>
<div id="main">
    <?php
        $db = BD_init();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            try{
                $qr = "SELECT account_id, value, reciever, date, type FROM operations_history WHERE user_id=:user_id";
                $from = test_input($_POST['from']);
                $to = test_input($_POST['personal-account']);
                $value = test_input($_POST['value']);
                $date_bot = test_input($_POST['date-bot']);
                $date_top = test_input($_POST['date-top']);
                $type = test_input($_POST['operation']);
                
                if($from=="" && $to=="" && $value=="" && $date_bot=="" && $date_top=="" && $type==""){
                }
                else{
                if($from != ""){   
                    $qr = $qr." AND account_id=:account_id";                                
                }
                if($to != ""){
                    $qr = $qr." AND reciever=:reciever";     
                }
                if($value != ""){
                    $qr = $qr." AND value=:value";
                }
                if($date_bot != ""){
                    $qr = $qr." AND date > :date_bot";
                }
                if($date_top != ""){
                    $qr = $qr." AND date > :date_top";  
                }
                if($type != ""){
                    $qr = $qr." AND type=:type";   
                }
            }
            $query = $db->prepare($qr);
            if($from=="" && $to=="" && $value=="" && $date_bot=="" && $date_top=="" && $type==""){
            }
            else{
            if($from != ""){
                $query->bindParam(':account_id', $from);                                
            }
            if($to != ""){
                $query->bindParam(':reciever', $to);     
            }
            if($value != ""){
                $query->bindParam(':value', $value);   
            }
            if($date_bot != ""){
                $query->bindParam(':date_bot', $date_bot);
            }
            if($date_top != ""){
                $query->bindParam(':date_top', $date_top);    
            }
            if($type != ""){
                $query->bindParam(':type', $type);     
            }
            
        }
            $query->bindParam(':user_id', $_SESSION['userid']);
            $query->execute();
              
            } catch(Exception $e){
                echo "<div class=\"nothing-to-show\">Nothing to show!</div>";
            }
            $value_from = 0;
            if ($query->rowCount() == 0) {
                echo "<div class=\"nothing-to-show\">Nothing to show!</div>";
            } else {
                $selected = $query->fetchAll();
                echo "<div id=\"history-table\">";
                echo "<table border='1' class=\"paleBlueRows\">";
                echo "<thead>";
                    echo "<th>" . "Account" . "</th>";
                    echo "<th>" ."Value". "</th>";
                    echo "<th>" ."Reciever". "</th>";
                    echo "<th>" ."Date"."</th>";
                    echo "<th>" ."Type". "</th>";
                echo "</thead>";
                foreach ($selected as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['account_id'] . "</td>";
                    echo "<td>" . $row['value'] . "</td>";
                    echo "<td>" . $row['reciever'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }
        }

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
    ?>

    </div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">Вставить текст</p>
</footer>
</body>
