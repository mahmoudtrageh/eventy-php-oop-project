<?php

session_start();

require_once ('modules/Database.php');

$db = new Database();

if (isset($_SESSION['usermail']))
{

    if (isset($_POST['submit']))
    {
        $id = $_GET['id'];

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $mess_to = $_POST['mess_to'];
        date_default_timezone_set('Africa/Cairo');

        $current = date('Y-m-d H:i');

        $read_n = 0;

        $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
        $noti->execute();

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    if (isset($_POST['submitAll']))
    {

        $db->query("SELECT id FROM users");
        $users = $db->resultSet();

        foreach ($users as $user)
        {
            $mess_to = $user->id;

            $message = $_POST['message'];
            $mess_by = $_POST['mess_by'];
            $current = date('Y-m-d H:i');

            $read_n = 0;

            $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
            $db->execute();

        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    if (isset($_POST['submitAllReg']))
    {

        $db->query("SELECT regby FROM users_registered");
        $userRegistereds = $db->resultSet();

        foreach ($userRegistereds as $userRegistered)
        {
            $mess_to = $userRegistered->regby;

            $message = $_POST['message'];
            $mess_by = $_POST['mess_by'];

            date_default_timezone_set('Africa/Cairo');

            $current = date('Y-m-d H:i');

            $read_n = 0;

            $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
            $noti->execute();

        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    if (isset($_POST['submit2']))
    {

        $ID = $_POST['events_id'];

        $db->query("SELECT * FROM users_registered WHERE events_id='$ID'");
        $usersRegistered = $db->resultSet();

        date_default_timezone_set('Africa/Cairo');

        $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i');

        foreach ($usersRegistered as $Reguser)
        {

            $mess_to = $Reguser['regby'];

            $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
            $noti->execute();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    }

    if (isset($_POST['submit3']))
    {

        $ID = $_POST['events_id'];

        $db->query("SELECT * FROM follow_event WHERE followed_event='$ID'");
        $usersRegistered = $db->resultSet();

        date_default_timezone_set('Africa/Cairo');

        $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i:s');
        foreach ($usersRegistered as $Reguser)
        {

            $mess_to = $Reguser->follower;

            $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '$mess_to', '$read_n', '$current')");
            $db->execute();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    }

    if (isset($_POST['submit4']))
    {

        date_default_timezone_set('Africa/Cairo');

        $read_n = 0;

        $message = $_POST['message'];
        $mess_by = $_POST['mess_by'];
        $current = date('Y-m-d H:i:s');

        $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$mess_by', '2', '$read_n', '$current')");
        $db->execute();

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    if (isset($_POST['submit5']))
    {

        $ID = $_POST['mess_by'];
        $db->query("SELECT follower FROM followers WHERE followed='$ID'");
        $followers = $db->resultSet();

        date_default_timezone_set('Africa/Cairo');

        $read_n = 0;

        $message = $_POST['message'];
        $mess_to = $_POST['mess_by'];

        $current = date('Y-m-d H:i:s');

        foreach ($followers as $follower)
        {

            $follower = $follower->follower;

            $db->query(" INSERT INTO messages ( message, mess_by, mess_to, read_n, date ) VALUES ('$message', '$ID', '$follower', '$read_n', '$current')");
            $noti->execute();

            header('Location: ' . $_SERVER['HTTP_REFERER']);

        }

    }

}
else
{
    header('location:add-event.php');
}

?>
