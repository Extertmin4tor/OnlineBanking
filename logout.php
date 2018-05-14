<?php
ini_set('session.gc_maxlifetime', 300);
ini_set('session.cookie_lifetime', 0);
session_start();
session_destroy();
header("Location: personal.php");
?>