<?php
require_once "util.php";
session_start();

if(!isset($_SESSION['userid']))    {
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
    <script src = "personal.js"></script>
</head>
<body>
<button id="create-account">Create account</button><br>
<div id="accordion-resizer" class="ui-widget-content">
<div id="accordion">
    <?php
    $db = BD_init();
    $query = $db->prepare('SELECT * FROM accounts WHERE user_id = :user_id');
    $query->bindParam(':user_id', $_SESSION['userid']);
    $query->execute();
    $selected = $query->fetchAll();
    foreach($selected as $row){
        echo "<h3>".$row['id']."</h3><div>
             Value: ".$row['value']."
              </div>";
    }
    ?>
</div>
</div>
</body>
<?php
echo $_SESSION['userid'];
?>