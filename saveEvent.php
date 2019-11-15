<!-- main in all pages -->

<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { ?>


<?php        


$EventTitle = $_POST['EventTitle']; 

$status = $_POST['status']; 
$town = $_POST['town'];
$category = $_POST['category'];
$date = $_POST['date'];
$time = $_POST['time'];
$finish_date = $_POST['finish_date'];
$finish_time = $_POST['finish_time'];
$members = $_POST['member_number'];
$address = $_POST['address'];
$map_link = $_POST['map_link'];
$fb_link = $_POST['fb_link'];
$tw_link = $_POST['tw_link'];
$event_desc = $_POST['event_desc'];
$org_desc = $_POST['org_desc'];
$ticket_price = $_POST['ticket_price'];
$voda_num = $_POST['voda_num'];



    


// info about img i will recieve 
//files respons for files 
$filename = $_FILES['EventImg']['name'];
$filetype = $_FILES['EventImg']['type'];
$filesize = $_FILES['EventImg']['size'] / 1024;
$filetmp = $_FILES['EventImg']['tmp_name'];
    


// create random number 
$r = rand();

// date
$d = date("h.i.sa");

//img validation

$validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    
if ( in_array($filetype, $validTypes ) ) {
    
  
        // add img to uploads file 
move_uploaded_file($filetmp, './assets/images/uploads/'.$r.$d.$filename);
    
    // make source of img 
$finalDes = 'assets/images/uploads/'.$r.$d.$filename;
    
move_uploaded_file($filetmp, '../assets/images/uploads/'.$r.$d.$filename);
    
    
 if (isset($_POST['action'])) {
     
                     
                $stmt2 = $con->prepare("SELECT id FROM users");
                $stmt2->execute();
                $row = $stmt2->fetch();
                $count1 = $stmt2->rowCount();
    
                if ($count1 > 0 ) {
            
            // register session with username
        
                    $_SESSION['id'] = $row['id'];

                    }
                
        $postBy = $_SESSION['ID'];
     
     
         
      $ins = $con->prepare(" INSERT INTO events (EventTitle, EventImg, town, status, postby, category, date, time, finish_date, finish_time, member_number, address, map_link, fb_link, tw_link, event_desc, org_desc, ticket_price, voda_num ) VALUES ('$EventTitle', '$finalDes', '$town', '$status', '$postBy', '$category', '$date', '$time', '$finish_date', '$finish_time', '$members', '$address', '$map_link', '$fb_link', '$tw_link', '$event_desc', '$org_desc', '$ticket_price', '$voda_num')");
        $ins->execute(array($EventTitle, $finalDes, $town, $status, $postBy, $category, $date, $time, $finish_date, $finish_time, $members, $address, $map_link, $fb_link, $tw_link, $event_desc, $org_desc, $ticket_price, $voda_num));
              
     
     
                $followed = $_SESSION['ID'];


                $stmt2 = $con->prepare("SELECT followed_name, followed FROM followers WHERE followed='$followed'");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
            // register session with username
                    
                   
                    
                    $_SESSION['followed_name'] = $row2['followed_name'];
                                       $_SESSION['followed'] = $row2['followed'];

                    
                                    }

                        $followed_name = $_SESSION['followed_name'];
                        $followed_id = $_SESSION['followed'];

     
     $stmt1 = $con->prepare("SELECT firstname, lastname FROM users WHERE username='$followed_name'");
                $stmt1 ->execute();
                $row1 = $stmt1 ->fetch();
                $count1 = $stmt1 ->rowCount();
    
                if ($count1  > 0 ) {
            
            // register session with username
        
                    $_SESSION['firstname'] = $row1['firstname'];
                                        $_SESSION['lastname'] = $row1['lastname'];

                    }
     
     
      $stmt8 = $con->prepare("SELECT id FROM events WHERE EventTitle='$EventTitle'");
                $stmt8 ->execute();
                $row8 = $stmt8 ->fetch();
                $count8 = $stmt8 ->rowCount();
    
                if ($count8  > 0 ) {
            
            // register session with username
        
                    $_SESSION['id'] = $row8['id'];

                    }
     
     $event_id = $_SESSION['id'];
     
     
     $firstname = $_SESSION['firstname'];
     $lastname = $_SESSION['lastname'];
     
              date_default_timezone_set('Africa/Cairo');

       $message = 'أضاف' . $firstname . ' ' . $lastname . '<a href="event-details.php?id=' . $event_id . '">توجه إليه </a>إيفنت جديد';
         $read_n = 0;
         $current = date('Y-m-d H:i:s');
     
                         

        
        
         $stmtManage = $con->prepare("SELECT follower FROM followers WHERE followed='$followed_id'");
    $stmtManage->execute();
    $followers = $stmtManage->fetchAll();
        
     foreach ( $followers as $follower) {
         
                $followers = $follower['follower'];
         
          
     $noti = $con->prepare(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$followers')");
        $noti->execute(array($message, $read_n, $current, $followers));
         
              }

        
     
     header('location:event-dashboard.php');
     
 }
 
    }
    


?>

    
<?php

} else {
        header('location:add-event.php');
}

?>

