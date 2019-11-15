<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { 

    
   
        
         $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];

         
           $noti = $con->prepare(" INSERT INTO messages ( message, mess_by, mess_to, read_n ) VALUES ('$message', '$mess_by', '2', '$read_n')");
        $noti->execute(array($message, $mess_by, 2, $read_n));

header('Location: ' . $_SERVER['HTTP_REFERER']);

           
      
    }

         
        




} else {
        header('location:add-event.php');
}

?>