<?php 
// start session
session_start();
// connection to database 
include 'connection.php'; 
// part of where the users signed in with mail
if (isset($_SESSION['usermail'])) {
// end
// get data from the forms 
    $comment_event = $_GET['id'];
// the id of the current signed in user 
    $user_id = $_SESSION['ID'];
    $fullname = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
    $comment_date = $_POST['comment_date'];
    $comment_content = $_POST['comment_content'];
// put the comments in the database 
    $query = $con->prepare("INSERT INTO comments (user_id, comment, date, comment_event, comment_name ) VALUES ('$user_id', '$comment_content', '$comment_date', '$comment_event', '$fullname')");
    $query->execute(array($user_id, $comment_content, $comment_date, $comment_event, $fullname));  
// redirect back on page 
    header('Location: ' . $_SERVER['HTTP_REFERER']);
// message put into notifications 
    $message = 'قام' . $fullname . 'بالتعليق في الإيفنت الخاص بك <a href="http://localhost/eventy/one-event-dashboard.php?id=' . $comment_event .'">توجه إليه</a>';
    $read_n = 0;
    date_default_timezone_set('Africa/Cairo');
    $current = date('Y-m-d H:i:s');
// get from database the session as one to otherthing
    $stmt1 = $con->prepare("SELECT postby FROM events WHERE id='$comment_event'");
        $stmt1 ->execute();
        $row1 = $stmt1 ->fetch();
        $count1 = $stmt1 ->rowCount();
        if ($count1  > 0 ) {
            $_SESSION['postby'] = $row1['postby'];
        }
    $post_by = $_SESSION['postby'];        
// put the notifications in the database 
    $noti = $con->prepare(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$post_by')");
    $noti->execute(array($message, $read_n, $current, $post_by));
}
?>