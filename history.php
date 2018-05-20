<?php
require_once "util.php";
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
require_once("csrf.class.php");
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
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
    <link rel="stylesheet" href="css/history.css">    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/history.js"></script>
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
<div id="nav-menu">
    <ul class="dropdown">
        <li class="filter-li"><a>Filter</a></li>
        <li class="back-li"><a>Back</a></li>
    </ul>
</div>
<div id="filter-history" class="custom-overlay" title="Filter history">
    <form method="post" id="filter-history-form" action="history.php">
            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
            <table class="filter-table">
            <tr>
            <td><label for="number_from">From</label></td>
            <td><input type="text" name="from" class="text ui-widget-content ui-corner-all"></td>
            <td><label for="number_to">To</label></td>
            <td><input type="text" name="personal-account" class="text ui-widget-content ui-corner-all "</td>
            
            </tr>
            <tr>
            <td><label for="value">Value</label></td>
            <td><input type="text" name="value" class="text ui-widget-content ui-corner-all"></td>
           
            
           
            <td><label for="value">Date from</label></td>
            <td><input type="date" name="date-bot"  class="text ui-widget-content ui-corner-all"></td>
</tr>
<tr>
            <td><label for="value">Date to</label></td>
            <td> <input type="date" name="date-top" size="30" class="text ui-widget-content ui-corner-all"></td>
            <td><label for="value">Operation</label></td>
            <td><input type="text" name="operation" class="text ui-widget-content ui-corner-all"></td>
            </tr>
        </table>
        <input type="submit" id="submit-filter" value="Find" name="submit-filter" class="button">
    </form>
</div>
<div id="main">  
</div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">Вставить текст</p>
</footer>
</body>
