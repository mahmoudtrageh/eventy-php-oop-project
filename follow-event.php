<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { 
    
    $id = $_GET['id'];
         
                if(isset($_POST['follow-event'])) {
                    
                     $stmt2 = $con->prepare("SELECT * FROM users");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
            // register session with username
                    
                   
                    
                     $follower = $_SESSION['ID'];
                    $follower_name = $_SESSION['firstname'];
                    
                   
                    
                                    }
                    
                       $stmt = $con->prepare("SELECT EventTitle FROM events WHERE id='$id'");
                $stmt ->execute();
                $row = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
            
            // register session with username
                    
                     $followed_name_event = $_SESSION['EventTitle'];
                    $followed_event = $id;
                }
                    
                     $ins = $con->prepare(" INSERT INTO follow_event (follower, followed_event, follower_name, followed_name ) VALUES ('$follower', '$followed_event', '$follower_name', '$followed_name_event')");
        $ins->execute(array($follower, $followed_event, $follower_name, $followed_name_event));
                    
header('Location: ' . $_SERVER['HTTP_REFERER']);

                    
                }
                }
         
            ?>
              
         