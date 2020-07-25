<?php 
    // start session
    session_start();
    // connection to data base
require_once('modules/Database.php');
    $db = new Database();
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
// if get submit by a follow user form 
        if(isset($_POST['follow'])) {
// get from stored session    
        $followed = $_SESSION['id'];
        $ID = $_SESSION['ID'];

        $db->query("DELETE FROM followers WHERE follower = '$ID' AND followed='$followed'");
                $db->execute();
        // redirect back to specific page        
        header('location:user-profile.php?id=' . $followed . '');
// if get submit by a follow event form 
        } else if(isset($_POST['follow-event'])) {

                 $followed = $_SESSION['id'];
        $ID = $_SESSION['ID'];
        var_dump($ID);
        var_dump($followed);

// get id of event sent by a link 
            $id = $_GET['id'];
// get id of current user stored in a session
            $ID = $_SESSION['ID'];
            $db->query("DELETE FROM follow_event WHERE follower = '$ID' AND followed_event='$id'");
             $db->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);   
// end follow event if        
        }
// end check if user signed in        
    }
?>