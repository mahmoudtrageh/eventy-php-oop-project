<?php 

session_start();

if(isset($_SESSION['usermail'])) {
    header('location:index.php');
} 


require_once('Database.php'); 
$db = new Database();

    
    if (isset($_POST['register-user']) && isset($_FILES['userpic'])) {


$usermail = $_POST['usermail'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$filename = $_FILES['userpic']['name'];
$filetype = $_FILES['userpic']['type'];
$filesize = $_FILES['userpic']['size'] / 1024;
$filetmp = $_FILES['userpic']['tmp_name'];
    

// create random number 
$r = rand();

// date
$d = date("h.i.sa");

//img validation

$validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    
if ( in_array($filetype, $validTypes ) ) {
    
  
        // add img to uploads file 
move_uploaded_file($filetmp, './assets/images/uploads/'.$r.$d.$filename);
    
    // make source of img 
$finalDes = 'assets/images/uploads/'.$r.$d.$filename;
    
move_uploaded_file($filetmp, '../assets/images/uploads/'.$r.$d.$filename);

                      
    if($password == $cpassword) {
        
        $db->query("SELECT usermail FROM users WHERE usermail = '$usermail'");
                $user = $db->resultSet();

                var_dump($user);
    
    if(empty($user)) {
       

        $db->query(" INSERT INTO users (usermail, password, cpassword, userpic, firstname, lastname) VALUES ('$usermail', '$password', '$cpassword', '$finalDes', '$firstname', '$lastname')");
        $db->bind(':usermail', $usermail);
        $db->bind(':password', $password);
        $db->bind(':cpassword', $cpassword);
        $db->bind(':userpic', $finalDes);
        $db->bind(':firstname', $firstname);
        $db->bind(':lastname', $lastname);

                $db->execute();

        $success_message = "تم التسجيل بنجاح.<br> سوف يتم توجيهك لصفحة تسجيل الدخول الآن";
                    header("Refresh:3; url=login.php");
        
    } else {
         $error_message = 'هذا الإيميل مسجل بالفعل. <br> سوف يتم توجيهك لصفحة تسجيل الدخول الآن';
                            header("Refresh:3; url=login.php");
    }
    } else {
        $error_message = "الباسورد غير متطابق";
    }
                
    }
}

require_once ('header2.php');

?>



<div class="container">
    
    <h2 class="event-det text-center">عضو جديد</h2>

  <!--  send data to the page itself  -->
  <form class="login-form text-right mt-5" name='register-user' enctype="multipart/form-data" method="post">

      
        <?php if(!empty($success_message)) { ?>
        <div class="success_message"><?php echo $success_message ?></div>
      <?php } ?>
      
       <?php if(!empty($error_message)) { ?>
        <div class="error_message"><?php echo $error_message ?></div>
      <?php } ?>
      
    <div class="input-container">
      <input type="email" name="usermail" id="usermail" class="form-control text-right" onblur="this.placeholder='name@example.com'" placeholder="name@example.com" onfocus="this.placeholder=''" required autocomplete="new-usermail" />
    </div>

      <div class="input-container">

      <input type="text" id="firstname"  name="firstname" class="form-control text-right" onblur="this.placeholder='محمود'" placeholder="محمود" onfocus="this.placeholder=''" required onkeyup="lettersOnly(this)" />
          
    </div>

      <div class="input-container">

      <input type="text"  name="lastname" class="form-control text-right" onblur="this.placeholder='طه'" placeholder="طه" onfocus="this.placeholder=''" required onkeyup="lettersOnly(this)" />
    </div>


    <div class="input-container">
        <input id="pass" type="password" name="password" class="form-control text-right" onblur="this.placeholder='الرقم السري'" placeholder="الرقم السري" onfocus="this.placeholder=''" required autocomplete="new-password"/>        
    </div>
      
      
    <div class="input-container">
        <input id="pass" type="password" name="cpassword" class="form-control text-right" onblur="this.placeholder='الرقم السري مرة أخري'" placeholder="الرقم السري مرة أخري" onfocus="this.placeholder=''" required autocomplete="new-password"/>        
    </div>
      
      <div class="input-container">
      <label>صورة البروفايل</label>
      <input type="file"  name="userpic" class="form-control" required/>
    </div>

      <button name="register-user" class="btn btn-success" style="width:50%;" type="submit">التسجيل</button>
      
<p class="float-left mt-2">تملك حساب بالفعل ! <a href="login.php">تسجيل الدخول</a></p>  

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
        
        $('#showpass').click(function(){
            $('#pass').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
        
        
     
    });
    
    function lettersOnly(input) {
        var regex = /[^ أ-ي]/gi;
        input.value = input.value.replace(regex, "");
    }

</script>