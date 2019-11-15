<?php 
    // start session
    session_start();
    // connection to data base
    include 'connection.php'; 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
    // add links page     
    include "links.php";
    // add header section    
    include "header.php";
    // get data send by edit comment from
    $comment_content = $_POST['comment_content'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $type = $_POST['type'];
    // get event id send by link    
    $comment_event = $_GET['id'];
?>
<!-- start edit form -->
<p class="alert alert-success mt-5 text-center" style="width:50%;margin:0 auto;">قم بتعديل بوست الآن</p>
<form class='edit_form' action="update_comment.php?id=<?php echo $comment_event; ?>" method='POST'>
    <input name='comment_id' type='hidden' value=' <?php echo $comment_id; ?>'>
    <input name='user_id' type='hidden' value=' <?php echo $user_id; ?>'>
    <input name='type' type='hidden' value='<?php echo $type; ?>'>
    <input name='comment_date' type='hidden' value='<?php echo date(' Y-m-d H:i:s '); ?>'>
    <textarea name='comment_content' class='form-control' rows='5'><?php echo $comment_content; ?></textarea>
    <button class='btn btn-outline-secondary mt-2' name='action' type='submit'>تعديل</button>
</form>
<!-- end check loged in -->
<?php 
    } else {
        header('location:login.php');
    }

    include 'footer.php';
?>