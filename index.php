<?php
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
require_once("csrf.class.php");
include("simple-php-captcha.php");
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
if (isset($_SESSION['userid'])) {
    header("Location: personal.php");
}
$_SESSION['captcha'] = simple_php_captcha();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to M4Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="jsencrypt/jsencrypt.js"></script>
    <script src="js/sign_up.js"></script>
    <script src="js/sign_in.js"></script>
    <script src="js/slider.js"></script>
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
        <div id="sign-in" class="widget" title="Sign in">
            <form action="signin.php" method="post">
                <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                <input type="text" name="login" required="required"
                       class="text ui-widget-content ui-corner-all form_elems" placeholder="login"><br>
                <input type="password" name="password" required="required"
                       class="text ui-widget-content ui-corner-all form_elems" placeholder="password"><br>
                       <input type="submit"  name="submit" class="button"  value="Log in">
                       <button id="create-user" class="button" >Registration</button>
                
            </form>
            
        </div>
    </div>


</header>
<div id="bg-block-slider">
    <div id="block-slider">
        <div id="viewpoint">
            <ul id="slidewrapper">
                <li class="slide"><div class="slide-item">
                        <h2>Кредиты!</h2>
                        <p>У нас самые выгодные займы!</p>
                    </div></li>
                <li class="slide"><div class="slide-item"><h2>Вставить текст</h2></div></li>
                <li class="slide"><div class="slide-item"><h2>Вставить текст</h2></div></li>
                <li class="slide"><div class="slide-item"><h2>Вставить текст</h2></div></li>
            </ul>
            <div id="prev-next-btns">
                <div id="prev-btn"></div>
                <div id="next-btn"></div>
            </div>
            <ul id="nav-btns">
                <li class="slide-nav-btn"></li>
                <li class="slide-nav-btn"></li>
                <li class="slide-nav-btn"></li>
                <li class="slide-nav-btn"></li>
            </ul>
        </div>
    </div>
</div>
<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">Вставить текст.</p>
</footer>
<div id="sign-up" class="custom-overlay sign-up" title="Sign up">
    <form action="signup.php" class="sign-up-form" method="post">
        <label for="name">Login</label><br>
        <input type="text" name="login" class="text ui-widget-content ui-corner-all pop_form_elems" required><br>
        <label for="email">E-mail</label><br>
        <input type="email" name="email" class="text ui-widget-content ui-corner-all  pop_form_elems" required><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" class="text ui-widget-content ui-corner-all  pop_form_elems"
               required><br>
        <label for="repassword">Confirm password</label><br>
        <input type="password" name="repassword" class="text ui-widget-content ui-corner-all  pop_form_elems"
               required><br>
        <label for="captcha">Enter symbols</label><br>
        <input type="text" name="captcha" class="text ui-widget-content ui-corner-all  pop_form_elems"
               required><br>
        <?php echo '<img id="captcha" src= "' .$_SESSION['captcha']['image_src']. '"></img>'; ?>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
<div id="captcha-sign-up" class="custom-overlay" title="Enter captcha">
<form action="signin.php" method="post">
        <label for="captcha">Enter symbols</label><br>
        <input type="text" name="captcha" class="text ui-widget-content ui-corner-all  pop_form_elems"
               required><br>
        <?php echo '<img id="captcha" src= "' .$_SESSION['captcha']['image_src']. '"></img>'; ?>
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
</form>
</div>
</body>
</html>