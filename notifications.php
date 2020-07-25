<?php

session_start();

if (isset($_SESSION['usermail']))
{

    require_once ('modules/Database.php');

    $db = new Database();

    require_once ('layouts/header.php');

?>

<div class="container">

<h2 class="event-det mt-4 text-center">جميع الاشعارات</h2>

 <?php
    $usermail = $_SESSION['usermail'];

    $db->query("SELECT id FROM users WHERE usermail = '$usermail'");
    $current_user = $db->single();

    $db->query("SELECT * FROM notifications WHERE read_n = 0 AND noti_to = '$current_user->id' ORDER BY date DESC");
    $notifications = $db->resultSet();
    $countnoti = $db->rowCount();

    $db->query("SELECT * FROM notifications WHERE read_n = 1 AND noti_to = '$current_user->id' ORDER BY date DESC ");
    $oldNotifi = $db->resultSet();

    foreach ($notifications as $notification)
    {
        echo "<a href='?notf=" . $notification->id . "' style='font-weight:bold;' class='dropdown-item'>
                            <small><i>" . $notification->date . "</i></small><br>
                            <p class='noti-box'> " . $notification->message . "</p>
                        </a>
                        <div class='dropdown-divider'></div>";
    }

    foreach ($oldNotifi as $notifi)
    {

        echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $notifi->date . "</i></small><br>
                <p> " . $notifi->message . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

    }

?>
    
    </div>
<?php

}
else
{
    header('location:login.php');
}

?>

<!-- End projects section -->
<?php require_once ('layouts/footer.php'); ?>
