<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { 

    
    $id = $_GET['id'];
    
    
        if(isset($_POST['submit'])) {

       $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
       $mess_to = $_POST['mess_to'];
                                             date_default_timezone_set('Africa/Cairo');

        $current = date('Y-m-d H:i');

    $read_n = 0;
            
             $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, $mess_to, $read_n, $current));

header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        }
    
        
    
    
        if(isset($_POST['submitAll'])) {
            
                    $stmt4 = $con->prepare("SELECT id FROM users");
$stmt4->execute();
$users = $stmt4->fetchAll();
         
            
            foreach($users as $user) {
                $mess_to = $user['id'];
            

       $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i');

    $read_n = 0;
            
             $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, $mess_to, $read_n, $current));
                
                            }


header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        }
    
    
    
            if(isset($_POST['submitAllReg'])) {
            
                    $stmt4 = $con->prepare("SELECT regby FROM users_registered");
$stmt4->execute();
$userRegistereds = $stmt4->fetchAll();
         
            
            foreach($userRegistereds as $userRegistered) {
                $mess_to = $userRegistered['regby'];
            

       $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
                
                                 date_default_timezone_set('Africa/Cairo');

        $current = date('Y-m-d H:i');

    $read_n = 0;
            
             $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, $mess_to, $read_n, $current));
                
                            }


header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        }
    
    
    if(isset($_POST['submit2'])) {
        
        $ID = $_POST['events_id'];
            
    $stmtManage = $con->prepare("SELECT * FROM users_registered WHERE events_id='$ID'");
    $stmtManage->execute();
    $usersRegistered = $stmtManage->fetchAll();
        
                         date_default_timezone_set('Africa/Cairo');

        
         $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
                $current = date('Y-m-d H:i');

     foreach ( $usersRegistered as $Reguser) {
         
                $mess_to = $Reguser['regby'];
         
           $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, $mess_to, $read_n, $current));

header('Location: ' . $_SERVER['HTTP_REFERER']);
     }

           
      
    }
    
        if(isset($_POST['submit3'])) {
        
        $ID = $_POST['events_id'];
            
    $stmtManage = $con->prepare("SELECT * FROM follow_event WHERE followed_event='$ID'");
    $stmtManage->execute();
    $usersRegistered = $stmtManage->fetchAll();
        
            
                     date_default_timezone_set('Africa/Cairo');

            
         $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i:s');
     foreach ( $usersRegistered as $Reguser) {
         
                $mess_to = $Reguser['follower'];
         
           $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, $mess_to, $read_n, $current));

header('Location: ' . $_SERVER['HTTP_REFERER']);
     }

           
      
    }
    
    if(isset($_POST['submit4'])) {
        
                 date_default_timezone_set('Africa/Cairo');

                 $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i:s');


         
           $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '2', '$read_n', '$current')");
        $noti->execute(array($message, $mess_by, 2, $read_n, $current));

header('Location: ' . $_SERVER['HTTP_REFERER']);
        
    }
    
    if(isset($_POST['submit5'])) {
        
        $ID = $_POST['mess_by'];
         $stmtManage = $con->prepare("SELECT follower FROM followers WHERE followed='$ID'");
    $stmtManage->execute();
    $followers = $stmtManage->fetchAll();
        
                 date_default_timezone_set('Africa/Cairo');

                 $read_n = 0;

        $message = $_POST['message'];
                $mess_to = $_POST['mess_by'];

        $current = date('Y-m-d H:i:s');

        foreach($followers as $follower) {
            
            $follower = $follower['follower'];

         
           $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$ID', '$follower', '$read_n', '$current')");
        $noti->execute(array($message, $ID, $follower, $read_n, $current));

header('Location: ' . $_SERVER['HTTP_REFERER']);
            
                    }

        
    }

         
        




} else {
        header('location:add-event.php');
}

?>