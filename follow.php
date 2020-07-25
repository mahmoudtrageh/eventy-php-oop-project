<?php

session_start();

require_once ('modules/Database.php');

$db = new Database();

if (isset($_SESSION['usermail']))
{

    $id = $_SESSION['id'];

    if (isset($_POST['follow']))
    {

        $db->query("SELECT * FROM users");
        $row2 = $db->single();
        $count2 = $db->rowCount();

        if ($count2 > 0)
        {

            // register session with username
            

            $follower = $_SESSION['ID'];
            $follower_name = $_SESSION['firstname'];
            $followed = $_SESSION['id'];

        }

        $db->query("SELECT * FROM users WHERE id='$id'");
        $row = $db->single();
        $count = $db->rowCount();

        if ($count > 0)
        {

            // register session with username
            $_SESSION['firstname'] = $row->firstname;
            $_SESSION['lastname'] = $row->lastname;

        }

        $followed_name = $_SESSION['firstname'];

        $db->query(" INSERT INTO followers (follower, followed, follower_name, followed_name ) VALUES ('$follower', '$followed', '$follower_name', '$followed_name')");
        $db->execute();

        header('location:user-profile.php?id=' . $followed . '');

        date_default_timezone_set('Africa/Cairo');

        $db->query("SELECT * FROM users WHERE id='$follower'");
        $row1 = $db->single();
        $count = $db->rowCount();

        if ($count > 0)
        {

            // register session with username
            $_SESSION['firstname'] = $row1->firstname;
            $_SESSION['lastname'] = $row1->lastname;

        }

        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];

        $message = 'قام' . $firstname . $lastname . 'بمتابعتك';
        $read_n = 0;
        $current = date('Y-m-d H:i:s');

        $db->query(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$followed')");
        $noti->execute();

    }
}

?>
