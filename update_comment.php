<?php 

session_start();

 include 'connection.php'; 

if (isset($_SESSION['usermail'])) { ?>


<?php 
    
                
                $comment_event = $_GET['id'];

        $comment_content = $_POST['comment_content'];
        $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $type = $_POST['type'];
         $query = $con->prepare("UPDATE comments SET comment = '$comment_content' WHERE comment_id='$comment_id' AND user_id='$user_id'");
        $query->execute();  

    if($type == 'user'){
             header('location:user-event-dashboard.php?id=' . $comment_event . '');
        
    } else {
                     header('location:one-event-dashboard.php?id=' . $comment_event . '');

    }

}

?>