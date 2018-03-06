<?php
require_once "util.php";
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="personal.js"></script>
</head>
<body>
<header>
    <div id="success-reg-text" title="Congratulation!" style="display: none;">
        <p>Welcome to M4bank-online!</p>
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

    <div id="right-header">

            <button id="create-account" class="buttonpersonal">Create account</button>
            <a href="logout.php">
                <button id="logout" class="buttonpersonal">Log out</button>
            </a>
    </div>
</header>
<div id="main">
    <div id="personal">
        <div id="accordion-resizer" class="ui-widget-content">
            <div id="accordion">
                <?php
                $db = BD_init();
                $query = $db->prepare('SELECT * FROM accounts WHERE user_id = :user_id');
                $query->bindParam(':user_id', $_SESSION['userid']);
                $query->execute();
                if ($query->rowCount() != 0) {
                    $selected = $query->fetchAll();
                    foreach ($selected as $row) {
                        echo "<h3 class ='test'>" . $row['id'] . "</h3><div class ='test'>
             Value: " . $row['value'] . "
              </div>";
                    }
                } else {
                    echo "<h3 class='test2'>You have no accounts yet</h3>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">бла-бла-бла.</p>
</footer>
</body>
