<?php 
    // start session
    session_start();
    // connection to data base
    include 'connection.php'; 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
    // get id of event sent by link    
        $comment_event = $_GET['id'];
    // get data send by delete form    
        $comment_id = $_POST['comment_id'];
        $reply_id = $_POST['reply_id'];
        $query = $con->prepare("DELETE FROM replies WHERE comment_id = '$comment_id' AND reply_id = '$reply_id'");
        $query->execute();  
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>