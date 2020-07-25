<?php 
    // start session
    session_start();
    // connection to data base
    require_once('modules/Database.php');

    $db = new Database();
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 

    // add header section    
    require_once ('layouts/header.php');
    // get data by edit reply form
    $reply = $_POST['reply_content'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $reply_id = $_POST['reply_id'];
    $type = $_POST['type'];
    // get id of event sent by link
    $comment_event = $_GET['id'];
?>
<!-- start edit reply form -->
<p class="alert alert-success mt-5 text-center" style="width:50%;margin:0 auto;">قم بتعديل بوست الآن</p>
<form class='edit_form' action="update_reply.php?id=<?php echo $comment_event; ?>" method='POST'>
    <input name='comment_id' type='hidden' value=' <?php echo $comment_id; ?>'>
    <input name='user_id' type='hidden' value=' <?php echo $user_id; ?>'>
    <input name='type' type='hidden' value='<?php echo $type; ?>'>
    <input name='reply_id' type='hidden' value=' <?php echo $reply_id; ?>'>
    <input name='reply_date' type='hidden' value='<?php echo date(' Y-m-d H:i:s '); ?>'>
    <textarea name='reply_content' class='form-control' rows='5'><?php echo $reply; ?></textarea>
    <button class='btn btn-outline-secondary mt-2' name='action' type='submit'>تعديل</button>
</form>
<!-- end check loged in -->
 <?php
    } else {
        header('location:login.php');
    }
    require_once ('layouts/footer.php');
?>