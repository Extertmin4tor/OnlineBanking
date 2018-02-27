<?php
function BD_init(){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=m4banking;charset=utf8',"vhshunter","123789456");
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
?>