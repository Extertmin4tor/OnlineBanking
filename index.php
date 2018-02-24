<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to M4Bank</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="sign_up.js"></script>
    <script src="sign_in.js"></script>
</head>
<body>
<div id="success-reg-text" title="Congratulation!" style="display: none;">
    <p>Welcome to M4bank-online!</p>
</div>
<button id="create-user">Become a client</button><br>
<div id="sign-in" class="widget" title="Sign in">
    <form action="signin.php" method="post">
        <input type="submit" name="submit" value="Log in" >
        <input type="text" name="login" class="text" placeholder="login">
        <input type="password" name="password"  class="text" placeholder="password">
    </form>
</div>
<div id="sign-up" title="Sign up">
    <p class="validateTips">All form fields are required.</p>
    <form action="signup.php" method="post">
            <label for="name">Login</label><br>
            <input type="text" name="login"  class="text"><br>
            <label for="email">E-mail</label><br>
            <input type="email" name="email" class="text" ><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" class="text"><br>
            <label for="repassword">Confirm password</label><br>
            <input type="password" name="repassword"  class="text"><br>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"><br>
    </form>
</div>
</body>
</html>