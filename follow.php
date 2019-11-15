
<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { 
    
    $id = $_SESSION['id'];

         
                if(isset($_POST['follow'])) {
                    
                     $stmt2 = $con->prepare("SELECT * FROM users");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
            // register session with username
                    
                   
                    
                  $follower = $_SESSION['ID'];
                    $follower_name = $_SESSION['firstname'];
                    $followed = $_SESSION['id'];
                   
                    
                                    }
                    
                    
                        
                       $stmt = $con->prepare("SELECT * FROM users WHERE id='$id'");
                $stmt ->execute();
                $row = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
            
            // register session with username
                    
                    $_SESSION['firstname'] = $row['firstname'];
                     $_SESSION['lastname'] = $row['lastname'];

                }
                    
                   $followed_name = $_SESSION['firstname'];
                    
                    
                     $ins = $con->prepare(" INSERT INTO followers (follower, followed, follower_name, followed_name ) VALUES ('$follower', '$followed', '$follower_name', '$followed_name')");
        $ins->execute(array($follower, $followed, $follower_name, $followed_name));
                    
                    
                    
             header('location:user-profile.php?id=' . $followed . '');
                    
                    
                     date_default_timezone_set('Africa/Cairo');

                     $stmt = $con->prepare("SELECT * FROM users WHERE id='$follower'");
                $stmt ->execute();
                $row1 = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
            
            // register session with username
                    
                    $_SESSION['firstname'] = $row1['firstname'];
                     $_SESSION['lastname'] = $row1['lastname'];

                }
                    
                     $firstname =  $_SESSION['firstname'];
                    $lastname =  $_SESSION['lastname'];
         
          $message = 'قام' . $firstname . $lastname . 'بمتابعتك';
         $read_n = 0;
         $current = date('Y-m-d H:i:s');
     
         
          
     $noti = $con->prepare(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$followed')");
        $noti->execute(array($message, $read_n, $current, $followed));


                    
                }
                }
         
            ?>
              
         