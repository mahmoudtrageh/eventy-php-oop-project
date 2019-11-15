<?php 

session_start();


if (isset($_SESSION['usermail'])) { ?>


<?php

     include 'connection.php'; 
    
     include "links.php";

include "header.php";

?>

<div class="container">
<h2 class="event-det mt-4 text-center">جميع الرسائل</h2>
 <?php
    
    $ID = $_SESSION['ID'];
            $stmt3 = $con->prepare("SELECT * FROM messages WHERE read_n = 0 AND mess_to = '$ID'  ORDER BY date DESC");
                $stmt3->execute();
                $messages = $stmt3->fetchAll();
                $countmess = $stmt3->rowCount();
                                   
                $stmt2 = $con->prepare("SELECT * FROM messages WHERE read_n = 1 AND mess_to = '$ID' ORDER BY date DESC ");
                $stmt2->execute();
                $oldmess = $stmt2->fetchAll();
                                   

    foreach($messages as $message) {  
                    echo"<a href='?mess=" . $message['mess_id'] . "' style='font-weight:bold;' class='dropdown-item'>
                            <small><i>" . $message['date'] . "</i></small><br>
                            <p class='noti-box'> " . $message['message'] . "</p>
                        </a>
                        <div class='dropdown-divider'></div>";
                        }
                    
                        foreach($oldmess as $oldmes) {  

                    echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $oldmes['date'] . "</i></small><br>
                <p> " . $oldmes['message'] . "</p>
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

