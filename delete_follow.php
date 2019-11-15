<?php 
    // start session
    session_start();
    // connection to data base
    include 'connection.php'; 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
// if get submit by a follow user form 
        if(isset($_POST['follow'])) {
// get from stored session    
        $followed = $_SESSION['id'];
        $ID = $_SESSION['ID'];
        $query = $con->prepare("DELETE FROM followers WHERE follower = '$ID' AND followed='$followed'");
        $query->execute();  
// redirect back to specific page        
        header('location:user-profile.php?id=' . $followed . '');
// if get submit by a follow event form 
        } else if(isset($_POST['follow-event'])) {
// get id of event sent by a link 
            $id = $_GET['id'];
// get id of current user stored in a session
            $ID = $_SESSION['ID'];
            $query = $con->prepare("DELETE FROM follow_event WHERE follower = '$ID' AND followed_event='$id'");
            $query->execute();  
            header('Location: ' . $_SERVER['HTTP_REFERER']);   
// end follow event if        
        }
// end check if user signed in        
    }
?>