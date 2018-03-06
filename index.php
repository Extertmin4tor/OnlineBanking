<?php
session_start();
if (isset($_SESSION['userid'])) {
    header("Location: personal.php");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to M4Bank</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="sign_up.js"></script>
    <script src="sign_in.js"></script>
    <script src="slider.js"></script>
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
                <input type="text" name="login" required="required"
                       class="text ui-widget-content ui-corner-all form_elems" placeholder="login">
                <input type="password" name="password" required="required"
                       class="text ui-widget-content ui-corner-all form_elems" placeholder="password">
                <input type="submit" name="submit" class="button" value="Log in">
            </form>
        </div>
        <div id="becomeclientdiv">
            <button id="create-user" class="button">Become a client</button>
        </div>
    </div>
</header>
<div id="under-header">
    <div id="block-slider">
        <div id="viewpoint">
            <ul id="slidewrapper">
                <li class="slide"><div class="slide-item">
                        <h2>Кредиты!</h2>
                        <p>У нас самые выгодные займы!</p>
                    </div></li>
                <li class="slide"><div class="slide-item"><h2>BBBBBBBBBBBBBBBBBBBBBBBBBBBB</h2></div></li>
                <li class="slide"><div class="slide-item"><h2>CCCCCCCCCCCCCCCCCCCCCCCCCCCC</h2></div></li>
                <li class="slide"><div class="slide-item"><h2>AAAAAAAAAAAAAAAAAAAAAAAAAAAA</h2></div></li>
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
<div id="sign-up" class="custom-overlay" title="Sign up">
    <p class="validateTips">All form fields are required.</p>
    <form action="signup.php" method="post">
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
        <input type="submit" class="button" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>

<footer>
    <p id="tel">8 880 5353535 - проще позвонить, чем у кого-то занимать.</p>
    <p id="info">бла-бла-бла.</p>
</footer>
</body>
</html>