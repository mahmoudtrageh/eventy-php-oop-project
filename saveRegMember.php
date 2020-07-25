<!-- main in all pages -->

<?php

session_start();

require_once ('modules/Database.php');

$db = new Database();

require_once ('functions.php');

if (isset($_SESSION['usermail']))
{ ?>


<?php

    $id = $_POST['myid'];

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $reginfo = $_POST['reginfo'];

    $regmail = $_POST['regmail'];

    $events_status = $_SESSION['status'];
    $phone_num = $_POST['vodNumber'];
    $reg_code = 'ev' . generateRandomString();

    if (isset($_POST['action']))
    {

        $db->query("SELECT id FROM users");
        $rowreg = $db->single();
        $countreg = $db->rowCount();

        if ($countreg > 0)
        {

            // register session with username
            $_SESSION['id'] = $rowreg->id;

        }

        $regby = $_SESSION['ID'];

        $db->query(" INSERT INTO users_registered (firstname, lastname, regmail, reginfo, regby, events_status, events_id, reg_status, phone_num, reg_code ) VALUES ('$firstname', '$lastname', '$regmail', '$reginfo', '$regby', '$events_status', '$id', 0, '$phone_num', '$reg_code')");
        $db->execute();
        header('location:user-event-dashboard.php?id=' . $id . '');

        date_default_timezone_set('Africa/Cairo');

        $message = ' قام' . $firstname . $lastname . ' بالتسجيل في الإيفنت الخاص بك <a href="http://localhost/eventy/event-details.php?id=' . $id . '"> توجه إليه</a>';
        $read_n = 0;
        $current = date('Y-m-d H:i:s');

        $db->query("SELECT postby FROM events WHERE id='$id'");
        $row1 = $db->single();
        $count1 = $db->rowCount();

        if ($count1 > 0)
        {

            // register session with username
            $_SESSION['postby'] = $row1->postby;

        }

        $post_by = $_SESSION['postby'];

        $db->query(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$post_by')");
        $db->execute();
    }

?>

    
<?php
}
else
{
    header('location:add-event.php');
}

?>
