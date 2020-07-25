<?php session_start();
    ob_start();
 require_once('Database.php'); 
 $db = new Database();

if(isset($_POST['forget-pass'])) {
    if(!empty($_POST['user-mail'])) {
        $email = trim($_POST['user-mail']);
        
    } else {
        $error_message = '<li>الإيميل مطلوب</li>';
    }
    
    if(empty($error_message)) {
        $db->query("SELECT firstname, usermail FROM users WHERE usermail = '$email'");
                $user = $db->resultSet();

    }
    
    if(!empty($user)) {
//        $msg = 'yes';
//        echo '<script>alert("$msg");</script>';
        require_once ('forget-password-mail.php');
    } else {
        $error_message = 'هذا الإيميل غير موجود';
    }
}

require_once ('header2.php');

?>
    




<div class="container">
    
<h3 class="event-det text-center mt-4">استعادة الرقم السري</h3>
  <form name="frm-forget" class="login-form text-right mt-5" style="height:150px;" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
      <?php if(!empty($success_message)) { ?>
      
      <div class="success_message"><?php echo $success_message ?></div>
      <?php } ?>
      
      <?php if(isset($error_message)) { ?>
      <div class="error_message"><?php echo $error_message ?></div>
      
      <?php } ?>
    <div class="input-container">
      <input type="email" name="user-mail" class="form-control text-right" autocomplete="off" onblur="this.placeholder='البريد الإلكتروني'" placeholder="البريد الإلكتروني" onfocus="this.placeholder=''" required />
    </div>
      
      <button name="forget-pass" class="btn btn-success" type="submit">أنشأ رقم سري جديد</button>
    
  </form>
</div>

    

<?php

require_once ('../layouts/footer.php'); 

?>

<script>

    $(document).ready(function(){
        $('input').each(function(){
            if ($(this).attr('required') === 'required') {
                $(this).after('<span class="req">*</span>');
            }
        });
</script>