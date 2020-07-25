<?php

session_start();

if (isset($_SESSION['usermail']))
{

    require_once ('modules/Database.php');

    $db = new Database();

    require_once ('layouts/header.php');

?>

<div class="container">
<h2 class="event-det mt-4 text-center">جميع الرسائل</h2>
 <?php

    $usermail = $_SESSION['usermail'];

    $db->query("SELECT id FROM users WHERE usermail = '$usermail'");
    $current_user = $db->single();

    $db->query("SELECT * FROM messages WHERE read_n = 0 AND mess_to = '$current_user->id'  ORDER BY date DESC");
    $messages = $db->resultSet();
    $countmess = $db->rowCount();

    $db->query("SELECT * FROM messages WHERE read_n = 1 AND mess_to = '$current_user->id' ORDER BY date DESC ");
    $oldmess = $db->resultSet();

    foreach ($rowreg as $message)
    {
        echo "<a href='?mess=" . $message->mess_id . "' style='font-weight:bold;' class='dropdown-item'>
                            <small><i>" . $message->date . "</i></small><br>
                            <p class='noti-box'> " . $message->message . "</p>
                        </a>
                        <div class='dropdown-divider'></div>";
    }

    foreach ($oldmess as $oldmes)
    {

        echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $oldmes->date . "</i></small><br>
                <p> " . $oldmes->message . "</p>
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
