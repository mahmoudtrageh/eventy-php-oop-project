<?php

session_start();

require_once ('modules/Database.php');

$db = new Database();

if (isset($_SESSION['usermail']))
{

    $id = $_GET['id'];

    if (isset($_POST['follow-event']))
    {

        $db->query("SELECT * FROM users");
        $row2 = $db->single();
        $count2 = $db->rowCount();

        if ($count2 > 0)
        {

            // register session with username
            

            $follower = $_SESSION['ID'];
            $follower_name = $_SESSION['firstname'];

        }

        $db->query("SELECT EventTitle FROM events WHERE id='$id'");
        $row = $db->single();
        $count = $db->rowCount();

        if ($count > 0)
        {

            // register session with username
            $followed_name_event = $_SESSION['EventTitle'];
            $followed_event = $id;
        }

        $db->query(" INSERT INTO follow_event (follower, followed_event, follower_name, followed_name ) VALUES ('$follower', '$followed_event', '$follower_name', '$followed_name_event')");
        $db->execute();

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }
}

?>
