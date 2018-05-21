
<?php
require_once "util.php";
ini_set('session.cookie_lifetime', 0);
session_start();
setcookie(session_name(), session_id(), time() + 300, null, null, True, True);

if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
?>

<?php
        $db = BD_init();
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            try{
                $page_number = test_input($_POST['page']);
                $qr = "SELECT  account_id, value, reciever, date, type FROM operations_history WHERE user_id=:user_id";
                $qr_count = "SELECT COUNT(*) count  FROM operations_history WHERE user_id=:user_id";
                $from = test_input($_POST['from']);
                $to = test_input($_POST['to']);
                $value = test_input($_POST['value']);
                $date_bot = test_input($_POST['date_bot']);
                $date_top = test_input($_POST['date_top']);
                $type = test_input($_POST['type']);
                
                if($from=="" && $to=="" && $value=="" && $date_bot=="" && $date_top=="" && $type==""){
                }
                else{
                if($from != ""){   
                    $qr = $qr." AND account_id=:account_id"; 
                    $qr_count  =  $qr_count." AND account_id=:account_id";                              
                }
                if($to != ""){
                    $qr = $qr." AND reciever=:reciever";    
                    $qr_count  =  $qr_count." AND reciever=:reciever";  
                }
                if($value != ""){
                    $qr = $qr." AND value=:value";
                    $qr_count  =  $qr_count." AND value=:value"; 
                }
                if($date_bot != ""){
                    $qr = $qr." AND date > :date_bot";
                    $qr_count  =  $qr_count." AND date > :date_bot";
                }
                if($date_top != ""){
                    $qr = $qr." AND date > :date_top";  
                    $qr_count  =  $qr_count." AND date > :date_top";  
                }
                if($type != ""){
                    $qr = $qr." AND type=:type";   
                    $qr_count  =  $qr_count." AND type=:type";   
                }
            }
            $qr = $qr." ORDER BY user_id DESC LIMIT 15 OFFSET :page";
            $query = $db->prepare($qr);
            $page_number = intval(($page_number - 1) * 15);
            $query->bindParam(':page', $page_number, \PDO::PARAM_INT);  
            $query_count = $db->prepare($qr_count);
            if($from=="" && $to=="" && $value=="" && $date_bot=="" && $date_top=="" && $type==""){
            }
            else{
            if($from != ""){
                $query->bindParam(':account_id', $from);         
                $query_count->bindParam(':account_id', $from);                       
            }
            if($to != ""){
                $query->bindParam(':reciever', $to);  
                $query_count->bindParam(':reciever', $to);     
            }
            if($value != ""){
                $query->bindParam(':value', $value);   
                $query_count->bindParam(':value', $value); ; 
            }
            if($date_bot != ""){
                $query->bindParam(':date_bot', $date_bot);
                $query_count->bindParam(':date_bot', $date_bot);
            }
            if($date_top != ""){
                $query->bindParam(':date_top', $date_top); 
                $query_count->bindParam(':date_top', $date_top);    
            }
            if($type != ""){
                $query->bindParam(':type', $type);   
                $query_count->bindParam(':type', $type); 
            }
            
        }
            $query->bindParam(':user_id', $_SESSION['userid']);
            $query->execute();
              
            } catch(Exception $e){
                json_error();
                echo "<div class=\"nothing-to-show\">Nothing to show!</div>";
            }

         
       
         $query_count->bindParam(':user_id', $_SESSION['userid']);
         $query_count->execute();
         $count = $query_count->fetchAll()[0]['count'];
         $value_from = 0;
         $data = array();
            
            if ($query->rowCount() == 0) {
                $return['code'] = 'zero';
                echo json_encode($return);
                die();
    
            } else {
                $selected = $query->fetchAll();
                foreach ($selected as $row) {
                     $data[] = $row;
                }
            }
        
            $return['code'] = 'ok';
            $return['data'] = $data;
            $return['pages_count'] = $count;
            echo json_encode($return);
    }

        function json_error(){
            $return =  $_POST;
            $return['code'] = 'error';
            echo json_encode($return);
            die();
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        return $data;
        }
    ?>