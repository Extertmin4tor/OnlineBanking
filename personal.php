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

    <div id="profile">
            <?php echo "Hello, ".$_SESSION['login']."<br>"; ?>
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
        <table class="card-table">
            <tbody>
                <?php
                $db = BD_init();
                $query = $db->prepare('SELECT a.id, a.value, a.card_type_2, c.pic_reference FROM accounts a
                INNER JOIN cards c on a.card_type = c.card_type WHERE a.user_id=:user_id ORDER BY a.id');
                $query->bindParam(':user_id', $_SESSION['userid']);
                $query->execute();
    
                if ($query->rowCount() != 0) {
                    $selected = $query->fetchAll();
                    foreach ($selected as $row) {
                        $path = $row['pic_reference'];
                        echo "<tr>"
                            ."<td rowspan = '2' width='25%'><img src=$path width='150' height='100'></td><td class='left-cell'>". $row['id']."</td>"
                            ."<td rowspan = '2' class='money-cell'>$" . $row['value']."</td>"
                            ."</tr><tr><td class='left-cell'>".$row['card_type_2']."</td>"
                            ."</tr>";        
                    }
                } else {
                    echo "<h3 class='test2'>You have no accounts yet</h3>";
                }
                ?>
            </tbody>
         </table>
</div>
<div id="transfer-dialog" class="dialog custom-overlay" title="Transfer">
    <form method="post">
        <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">To</label><br>
        <input type="text" name="to" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="mobile-payment-dialog" class="dialog custom-overlay" title="Mobile payment">
    <form method="post">
        <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">Mobile number</label><br>
        <input type="text" name="number" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="utility-payment-dialog" class="dialog  custom-overlay" title="Utility payment">
    <form method="post">
        <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
        <label for="number_from">From</label><br>
        <input type="text" name="from" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="number_to">Personl account</label><br>
        <input type="text" name="personal-account" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="value">Value</label><br>
        <input type="money" name="value" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="add-acc-form" class="dialog custom-overlay" title="Add an account">
    <form method="post" id="add-acc" action="create_account.php">
        <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
        <label for="payment-system-choose">Payment system</label><br>
        <select id="payment-system-choose" name="payment-system-choose" size="3">
            <option value="Master Card">Master Card</option>
            <option value="Visa">Visa</option>
            <option value="American Express">Amertican Express</option>
        </select><br>
        <label for="card-type-2">Card type</label><br>
        <select id="card-type-2" name="card-type-2" size="2">
            <option value="debit">Debit</option>
            <option value="credit">Credit</option>
        </select>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">Вставить текст</p>
</footer>
</body>
