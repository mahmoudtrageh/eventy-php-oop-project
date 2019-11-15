<?php 

session_start();


if (isset($_SESSION['usermail'])) { ?>


<?php

     include 'connection.php'; 
    
     include "links.php";

include "header.php";

?>
<div class="container">

<h2 class="event-det mt-4 text-center">جميع الاشعارات</h2>

 <?php
    
    $ID = $_SESSION['ID'];
            $stmt3 = $con->prepare("SELECT * FROM notifications WHERE read_n = 0 AND noti_to = '$ID' ORDER BY date DESC");
                $stmt3->execute();
                $notifications = $stmt3->fetchAll();
                $countnoti = $stmt3->rowCount();
                                   
                $stmt2 = $con->prepare("SELECT * FROM notifications WHERE read_n = 1 AND noti_to = '$ID' ORDER BY date DESC ");
                $stmt2->execute();
                $oldNotifi = $stmt2->fetchAll();
                                   

    foreach($notifications as $notification) {  
                    echo"<a href='?notf=" . $notification['id'] . "' style='font-weight:bold;' class='dropdown-item'>
                            <small><i>" . $notification['date'] . "</i></small><br>
                            <p class='noti-box'> " . $notification['message'] . "</p>
                        </a>
                        <div class='dropdown-divider'></div>";
                        }
                    
                        foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $notifi['date'] . "</i></small><br>
                <p> " . $notifi['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                        
  ?>
    
    </div>
<?php
               

} else {
        header('location:login.php');
}

?>

<!-- End projects section -->
<?php include 'footer.php' ?>

