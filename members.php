<?php 

session_start();


if (isset($_SESSION['usermail'])) { 
    
    require_once('modules/Database.php');


    $db = new Database();

require_once ('layouts/header.php');
    
$ID = isset($_GET['id']) ? $_GET['id'] : '';
                                    
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

                                   
if ( $do == 'Manage'){

    
    $db->query("SELECT * FROM users");
    $usersRegistered = $db->resultSet();
    
    
?>

<button style="width:30%;margin:0 auto;display:block;" class="btn btn-success mt-5 print-btn" onclick="myFunction()">اطبع القائمة</button>

    
   
    <span class="btn btn-success mess-btn-all mt-4">راسل الجميع</span>

 <form class="mess-form-all" action='send_message.php' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submitAll' class="btn btn-success">راسل الجميع</button>

        </form>



<script>
function myFunction() {
    window.print();
} 
</script>

<style>

    @media print {
   .setting, .mess-btn-all {display:none}
    .print-btn {display:none !important}
    header{display: none}
    footer {display:none}
    }

</style>

<table>
        <tr>
    <td>Id</td> 
    <td>الإسم الأول</td> 
    <td>الإسم الأخير</td> 
    <td>الرقم السري</td> 
    <td>البريد الإللكتروني</td>             
    <td>الصورة الشخصية</td> 
    <td class="setting">إعدادات</td> 
    </tr>
    
                    
        <?php
    
    foreach ((array) $usersRegistered as $Reguser) {
        
        echo "<tr>";
        
        echo "<td>" . $Reguser->id . "</td>";
        echo "<td>" . $Reguser->firstname . "</td>";
        echo "<td>" . $Reguser->lastname . "</td>";

        echo "<td>" . $Reguser->password . "</td>";
        echo "<td>" . $Reguser->usermail . "</td>";
        echo "<td><img src=" . $Reguser->userpic . "></td>";
        echo "<td class='setting'><a class='btn btn-success' href='members.php?do=Edit&id=" . $Reguser->id . "'>تعديل</a> |
        
        <a class='btn btn-danger confirm' href='members.php?do=Delete&id=" . $Reguser->id . "'>حذف</a> |
                
        "; 
    
    ?>
    <span class="btn btn-success mess-btn">رسالة</span>

        <form class="mess-form" action='send_message.php' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <input name='mess_to' type='hidden' value='<?php echo $Reguser['id'] ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit' class="btn btn-primary">أرسل</button>

        </form>

    <?php echo "
        
        </td>";
        
        
        echo "</tr>";
        
    }
    
            
            ?>
    
    

</table>

<?php
    
} else if ($do == 'Edit') { ?>


<?php
    
$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
                                   
        $db->query("SELECT * FROM users WHERE id = '$userId' LIMIT 1");

        $row = $db->single();
       
        $count = $db->rowCount();
                                   
        if ($count > 0 ) { ?>
            
<div class="container">
<h1 class="mt-3 text-center event-det">تعديل بيانات الحساب</h1>
    </div>
<form class="login-form text-right"  enctype="multipart/form-data" action="?do=Update" method="POST">
    
    <input type="hidden" name="id" value="<?php echo $userId ?>" />
    
    <div class="form-group">
      <label>الإسم الأول</label>
      <input type="text"  name="firstname" value="<?php echo $row->firstname ?>" class="form-control" />
    </div>
    
    <div class="form-group">
      <label>الإسم الأخير</label>
      <input type="text"  name="lastname" value="<?php echo $row->lastname ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label>الرقم السري</label>
      <input type="password"  name="password" value="<?php echo $row->password ?>" class="form-control" />
    </div>
      
      <div class="form-group">
      <label>البريد الإلكتروني</label>
      <input type="email"  name="usermail" value="<?php echo $row->usermail ?>" class="form-control" />
    </div>
      
      <div class="form-group">
      <label>الصورة الشخصية</label>
      <input type="file" name="userpic" value="<?php echo $row->userpic ?>" class="form-control" />
    </div>

    <div class="form-button">
      <button name="action" class="btn btn-success" value="save" type="submit">حفظ</button>
    </div>

  </form>
    
    <?php
        
        } else {
            echo "ther is no id";
        }
    
} else if($do == 'Update') {
    echo "<h1 class='text-center event-det'>تعديل الحساب</h1>";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $userId = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname']; 
        $usermail = $_POST['usermail'];
        $password = $_POST['password'];
        
        $filename = $_FILES['userpic']['name'];
$filetype = $_FILES['userpic']['type'];
$filesize = $_FILES['userpic']['size'] / 1024;
$filetmp = $_FILES['userpic']['tmp_name'];
        
        $r = rand();
$d = date("h.i.sa");

$validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    
if ( in_array($filetype, $validTypes ) ) {
    
  
move_uploaded_file($filetmp, './assets/images/uploads/'.$r.$d.$filename);
    
    $finalDes = 'assets/images/uploads/'.$r.$d.$filename;
    
move_uploaded_file($filetmp, '../assets/images/uploads/'.$r.$d.$filename);
                

        $db->query("UPDATE users SET firstname = :firstname, lastname = :lastname, usermail = :usermail, password = :password, userpic = :userpic WHERE id = :id ");        

        $db->bind(':firstname', $firstname);
        $db->bind(':lastname', $lastname);
        $db->bind(':usermail', $usermail);
        $db->bind(':password', $password);
        $db->bind(':userpic', $finalDes);
        $db->bind(':id', $userId);
       

        $db->execute();

        echo "<p class='alert alert-success redirect'>تم التعديل بنجاح سيتم التحديث في غضون 2 ثانية</p>";

 
    ?>
        
<meta http-equiv="refresh" content="3;URL=/eventy/members.php">
     
        <?php
}
        
    } else {
        echo "sorry";
    }
} elseif($do == 'Delete') {
    
    $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
                                   
        $db->query("SELECT * FROM users WHERE id = '$userId' LIMIT 1");

        $count = $db->rowCount();
                                   
        if ($count > 0 ) { 
         
        $db->query("DELETE FROM users WHERE id = '$userId' ");
            
        $stmt->execute();
            

                 echo "<p class='alert alert-success redirect'>تم الحذف بنجاح سيتم التحديث في غضون 2 ثانية</p>";


    ?>
        
<meta http-equiv="refresh" content="3;URL=/eventy/members.php">
     
        <?php
        }
    
} else {
            echo "sorry";

}

} else {
        header('location:login.php');
}

?>

<!-- End projects section -->
<?php require_once ('layouts/footer.php'); ?>

<script>

    $(document).ready(function(){
        $('.confirm').click(function(){
            return confirm('ary you sure?');
        });
        
        
                        
                                $(".mess-form").hide();

                $(".mess-btn").click(function(){
    $(this).nextAll(".mess-form").slice(0, 1).slideToggle();
  });
        
        $(".mess-form-all").hide();

                $(".mess-btn-all").click(function(){
    $(this).nextAll(".mess-form-all").slice(0, 1).slideToggle();
  });

             
    });

</script>