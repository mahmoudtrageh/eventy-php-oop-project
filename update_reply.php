<?php

session_start();

require_once ('modules/Database.php');

$db = new Database();

if (isset($_SESSION['usermail']))
{ ?>


<?php

    $comment_event = $_GET['id'];

    $reply = $_POST['reply_content'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $type = $_POST['type'];

    $reply_id = $_POST['reply_id'];

    $db->query("UPDATE replies SET reply = '$reply' WHERE comment_id='$comment_id' AND user_id='$user_id' AND reply_id='$reply_id'");
    $db->execute();

    if ($type == 'user')
    {
        header('location:user-event-dashboard.php?id=' . $comment_event . '');

    }
    else
    {
        header('location:one-event-dashboard.php?id=' . $comment_event . '');

    }

}

?>
