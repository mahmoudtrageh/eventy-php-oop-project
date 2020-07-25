<?php 
    // start session
    session_start();
    // connection to data base
require_once('modules/Database.php');
    $db = new Database();
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
    // get id of event sent by link    
        $comment_event = $_GET['id'];
    // get data send by delete form    
        $comment_id = $_POST['comment_id'];
        $reply_id = $_POST['reply_id'];
        $db->query("DELETE FROM replies WHERE comment_id = '$comment_id' AND reply_id = '$reply_id'");
        $db->execute();  
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>