<!-- main in all pages -->

<?php 

session_start();

 include 'connection.php'; 

include_once 'functions.php';




if (isset($_SESSION['usermail'])) { ?>


<?php  
    

    
    $id = $_POST['myid'];
            
$firstname = $_POST['firstname']; 
$lastname = $_POST['lastname']; 
$reginfo = $_POST['reginfo'];
        
$regmail = $_POST['regmail']; 

        
    $events_status = $_SESSION['status'];
    $phone_num = $_POST['vodNumber'];
    $reg_code = 'ev' . generateRandomString();

        
     if (isset($_POST['action'])) {

 $stmtreg = $con->prepare("SELECT id FROM users");
                $stmtreg ->execute();
                $rowreg = $stmtreg ->fetch();
                $countreg = $stmtreg ->rowCount();
    
                if ($countreg  > 0 ) {
            
            // register session with username
        
                    $_SESSION['id'] = $rowreg['id'];

                    }
                
        $regby = $_SESSION['ID'];
    
             
                        
        
         $ins = $con->prepare(" INSERT INTO users_registered (firstname, lastname, regmail, reginfo, regby, events_status, events_id, reg_status, phone_num, reg_code ) VALUES ('$firstname', '$lastname', '$regmail', '$reginfo', '$regby', '$events_status', '$id', 0, '$phone_num', '$reg_code')");
        $ins->execute(array($firstname, $lastname, $regmail, $reginfo, $regby, $events_status, $id, $phone_num, $reg_code));
         
             header('location:user-event-dashboard.php?id=' . $id . '');
         
         
         date_default_timezone_set('Africa/Cairo');

         
          $message = ' قام' . $firstname . $lastname . ' بالتسجيل في الإيفنت الخاص بك <a href="http://localhost/eventy/event-details.php?id=' . $id . '"> توجه إليه</a>';
         $read_n = 0;
         $current = date('Y-m-d H:i:s');
     
     
$stmt1 = $con->prepare("SELECT postby FROM events WHERE id='$id'");
                $stmt1 ->execute();
                $row1 = $stmt1 ->fetch();
                $count1 = $stmt1 ->rowCount();
    
                if ($count1  > 0 ) {
            
            // register session with username
        
                    $_SESSION['postby'] = $row1['postby'];

                    }
                
        $post_by = $_SESSION['postby'];        
         
          
     $noti = $con->prepare(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$post_by')");
        $noti->execute(array($message, $read_n, $current, $post_by));

        
         
    } 
         


?>

    
<?php

} else {
        header('location:add-event.php');
}

?>

