<?php
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);
session_destroy();
header("Location: personal.php");
?>