<?php 
// start session
session_start();
// connection to data base
include 'connection.php'; 
// when the user signed in
if (isset($_SESSION['usermail'])) { 
    // get the id sent by link
    $id = $_GET['id'];
    // data send by form 
    $comment_id = $_POST['comment_id'];
    $reply = $_POST['reply_content'];
    $new_reply_code = $_POST['code'];
    $reply_date = $_POST['reply_date'];
    // data of user signed in
    $fullname = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
    $user_id = $_SESSION['ID'];
    // put replies data in the database         
    $query = $con->prepare("INSERT INTO replies (reply, comment_id, date, comment_name, user_id, reply_event) VALUES ('$reply', '$comment_id', '$reply_date', '$fullname', '$user_id', '$id')");
        $query->execute(array($reply, $comment_id, $reply_date, $fullname, $user_id, $id));  
    // redirect back one page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>