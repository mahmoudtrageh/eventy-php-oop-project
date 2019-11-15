<?php 

session_start();

?>

<?php if(isset($_SESSION['usermail'])) {
    header('location:index.php');
} 

 include 'connection.php';

   

    if (isset($_POST['action']))
        
    
    {
          $usermail = $_POST['usermail'];  
          $password = $_POST['password'];  
        
        $stmt = $con->prepare("SELECT id, Usermail, Userpic, password FROM users WHERE usermail = ? AND Password = ? LIMIT 1");

        $stmt->execute(array($usermail, $password));

        //fetch data from database
        $row = $stmt->fetch();
       
        $count = $stmt->rowCount();
       
        if ($count > 0 ) {
            
            // register session with username
            $_SESSION['usermail'] = $usermail;
            
            // record session
            $_SESSION['Userpic'] = $row['Userpic'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['ID'] = $row['id'];

            header('location:index.php');
        } else {
            $error_message = 'هذا الحساب غير موجود';
        }
    }


 include "links.php";

?>

<?php
include "header2.php";

?>
    




<div class="container">
    
        <h2 class="event-det text-center">تسجيل الدخول</h2>
    
  <form class="login-form text-right mt-5" method="POST">

      <?php if(!empty($error_message)) { ?>
        <div class="error_message"><?php echo $error_message ?></div>
      <?php } ?>
      
    <div class="input-container">
      <input type="email" name="usermail" class="form-control text-right" autocomplete="off" onblur="this.placeholder='البريد الإلكتروني'" placeholder="البريد الإلكتروني" onfocus="this.placeholder=''" required />
    </div>

    <div class="input-container">
    <input type="password" id="pass" name="password" class="form-control text-right" autocomplete="new-password" onblur="this.placeholder='الرقم السري'" placeholder="الرقم السري" onfocus="this.placeholder=''" required/>
    
    </div>
                 <div class="row">
                     <div class="col-md-6">

      <p><input class="mt-2 ml-2" type="checkbox" id="showpass"><span>أظهر الرقم السري</span></p>
                     </div>
                         
                         <div class="col-md-6">
<p><label>تذكرني</label><input class="mt-2 ml-2" type="checkbox"></p>
                     </div>
      </div>
<p><a href="forget-pass.php">نسيت كلمة السر ؟</a></p>
            
      <button name="action" class="btn btn-success" style='width:50%;' type="submit">الدخول</button>
    

            <p class="float-left mt-2">لا تملك حساب ! <a href="register.php">أنشأ حساب</a></p>  
  </form>
</div>


<?php
    
include 'footer.php';

?>

<script>

    $(document).ready(function(){
        $('input').each(function(){
            if ($(this).attr('required') === 'required') {
                $(this).after('<span class="req">*</span>');
            }
        });
        
           $('#showpass').click(function(){
            $('#pass').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
    });

</script>