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
<div id="nav-menu">
    <ul class="dropdown">
        <li class="transfer-li"><a>Transfer</a></li>
        <li class="drop"><a>Payment</a>
            <ul class="sub_menu">
        	    <li class="mobile-li"><a>Mobile services</a></li>
				<li class="utility-li"><a>Utility services</a></li>	
        	</ul>
        	</li>
            </li>
        <li class="history-li"><a>History</a></li>
        <li class="create-li"><a>Create account</a></li>
    </ul>
</div>
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
<div id="transfer-dialog" class="custom-overlay" title="Transfer">
    <p class="validateTips">All form fields are required.</p>
    <form method="post">
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">To</label><br>
        <input type="text" name="to" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="mobile-payment-dialog" class="custom-overlay" title="Mobile payment">
    <p class="validateTips">All form fields are required.</p>
    <form method="post">
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">Mobile number</label><br>
        <input type="text" name="number" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="utility-payment-dialog" class="custom-overlay" title="Utility payment">
    <p class="validateTips">All form fields are required.</p>
    <form method="post">
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">Personl account</label><br>
        <input type="text" name="personal-account" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="filter-history" class="custom-overlay" title="Filter history">
    <p class="validateTips">All form fields are required.</p>
    <form method="post" id="filter-histor-form" action="history.php">
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems"><br>
        <label for="number_to">To</label><br>
        <input type="text" name="personal-account" class="text ui-widget-content ui-corner-all pop_form_elems"><br>
        <label for="value">Value</label><br>
        <input type="text" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems"><br>
        <label for="value">Date from</label><br>
        <input type="date" name="date-bot"  class="text ui-widget-content ui-corner-all  pop_form_elems"><br>
        <label for="value">Date to</label><br>
        <input type="date" name="date-top" size="30" class="text ui-widget-content ui-corner-all  pop_form_elems"><br>
        <label for="value">Operation</label><br>
        <input type="text" name="operation" class="text ui-widget-content ui-corner-all  pop_form_elems"><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">Вставить текст</p>
</footer>
</body>
