<?php 
    // start session
    session_start();
    // connection to data base
    include 'connection.php'; 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
// get event id send by link
//    $comment_event = $_GET['id'];
// get comment id sent by form
    $comment_id = $_POST['comment_id'];
// delete from database 
    $query = $con->prepare("DELETE FROM comments WHERE comment_id = '$comment_id'");
    $query->execute();  
// redirect back one page 
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    } 
?>