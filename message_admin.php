<?php 

session_start();

 require_once('modules/Database.php');
 
 $db = new Database();

if (isset($_SESSION['usermail'])) { 
        
         $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
         
        $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n ) VALUES ('$message', '$mess_by', '2', '$read_n')");
        $db->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

else {
        header('location:add-event.php');
}

?>