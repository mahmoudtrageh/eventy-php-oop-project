<?php 

session_start();


if (isset($_SESSION['usermail'])) { ?>


<?php include 'connection.php'; ?>
    
    <?php include "links.php" ?>

<?php include "header.php" ?>

<?php 
    

$ID = isset($_GET['id']) ? $_GET['id'] : '';

    
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

                                   
if ( $do == 'Manage'){
    
    $query = '';
    
    if(isset($_GET['page']) && $_GET['page'] == 'pending') {
        $query = 'AND reg_status=0';
    }
    
    $stmtManage = $con->prepare("SELECT * FROM users_registered $query");
    $stmtManage->execute();
    $usersRegistered = $stmtManage->fetchAll();
    
?>

<button style="width:30%;margin:0 auto;display:block;" class="btn btn-success mt-5 print-btn" onclick="myFunction()">اطبع القائمة</button>

    
   <span class="mess-btn-all btn btn-success mt-4">راسل الجميع</span>


 <form class="mess-form-all" action='send_message.php' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>

            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submitAllReg' class="btn btn-primary">راسل الجميع</button>

        </form>



<script>
function myFunction() {
    window.print();
} 
</script>

<style>

    @media print {
   .setting {display:none}
    .print-btn {display:none !important}
    header{display: none}
    footer {display:none}
    }

</style>

<table>
        <tr>
    <td>Id</td> 
    <td>FirstName</td> 
    <td>LastName</td>         
    <td>Email</td>             
    <td>الهاتف</td> 
    <td class="info">التذكرة</td> 
    <td class="setting">setting</td> 
    <td>حالة التسجيل</td> 
    <td>الحضور</td> 
    </tr>
    
                    
        <?php
    
    foreach ((array) $usersRegistered as $Reguser) {
        
        echo "<tr>";
        
        echo "<td>" . $Reguser['regId'] . "</td>";
        echo "<td>" . $Reguser['firstname'] . "</td>";
        echo "<td>" . $Reguser['lastname'] . "</td>";
        echo "<td>" . $Reguser['regmail'] . "</td>";
                echo "<td>" . $Reguser['phone_num'] . "</td>";
                echo "<td class='info'>" . $Reguser['reg_code'] . "</td>";
        echo "<td class='setting'><a class='btn btn-success' href='one-event-members.php?do=Edit&regId=" . $Reguser['regId'] . "&id=$ID'>Edit</a> |
        
        <a class='btn btn-danger confirm' href='one-event-members.php?do=Delete&regId=" . $Reguser['regId'] . "'>حذف</a> |
        
        ";
        ?>
    
    <span class="mess-btn btn btn-success mt-4">رسالة</span>

      <form class="mess-form" action='send_message.php?id=<?php echo $Reguser['events_id'] ?>' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <input name='mess_to' type='hidden' value='<?php echo $Reguser['regby'] ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit' class="btn btn-primary">أرسل</button>

        </form>
    
    <?php
        
        echo"
        
        </td>";
        
            if($Reguser['reg_status'] == 0) {
                  echo "<td><a class='btn btn-success not-activate' href='one-event-members.php?do=Active&regId=" . $Reguser['regId'] . "'>Activate</a></td>"; 

        } else {
            
            
            echo "<td><p class='alert alert-success'>Activated</p></td>"; 

        }
        
        ?>
    
    
    <?php
        
        
                echo "<td></td>";

        echo "<td></td>";

        echo "</tr>";
        
    }
    
            
            ?>
    
    

</table>

<?php
    
} else if ($do == 'Edit') { ?>


<?php
    
    $regUserId = isset($_GET['regId']) && is_numeric($_GET['regId']) ? intval($_GET['regId']) : 0;
                                   
        $stmt = $con->prepare("SELECT * FROM users_registered WHERE regId = ? LIMIT 1");

        $stmt->execute(array($regUserId));

        $row = $stmt->fetch();
       
        $count = $stmt->rowCount();
                                   
        if ($count > 0 ) { ?>
            
<h1 class="text-center">Edit Page</h1>
<form class="login-form"  enctype="multipart/form-data" action="?do=Update" method="POST">
    
    <input type="hidden" name="regId" value="<?php echo $regUserId ?>" />
    
    <div class="form-group">
      <label>Firstname:</label>
      <input type="text"  name="firstname" value="<?php echo $row['firstname'] ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label>LastName:</label>
      <input type="text"  name="lastname" value="<?php echo $row['lastname'] ?>" class="form-control" />
    </div>
      
      <div class="form-group">
      <label>Mail:</label>
      <input type="email"  name="regmail" value="<?php echo $row['regmail'] ?>" class="form-control" />
    </div>
      
      <div class="form-group">
      <label>Info:</label>
      <textarea type="text" name="reginfo" class="form-control"><?php echo $row['reginfo'] ?></textarea>
    </div>

    <div class="form-button">
      <button name="action" class="btn btn-primary" value="save" type="submit">save</button>
    </div>

  </form>
    
    <?php
        
        } else {
            echo "ther is no id";
        }
    
} else if($do == 'Update') {
    echo "<h1 class='text-center'>Update</h1>";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $regUserId = $_POST['regId'];
        $firstname = $_POST['firstname']; 
        $lastname = $_POST['lastname'];
        $regmail = $_POST['regmail'];
        $reginfo = $_POST['reginfo'];
        
       
                
        $stmt = $con->prepare("UPDATE users_registered SET firstname = ?, lastname = ?, regmail = ?, reginfo = ? WHERE regId = ? ");
        $stmt->execute(array($firstname, $lastname, $regmail, $reginfo, $regUserId));
        

          echo "<p class='alert alert-success'>تم التعديل بنجاح</p>";
            echo "<p class='alert alert-success'>سوف يتم الرجوع للخلف في غضون 2 ثانية</p>";
        
           $url = 'regMembers.php';
            echo '<meta http-equiv="refresh" content="2;URL=' . $url . '">';

        
    } else {
        echo "sorry";
    }
                                   
} elseif($do == 'Delete') {
    
    $regUserId = isset($_GET['regId']) && is_numeric($_GET['regId']) ? intval($_GET['regId']) : 0;
                                   
        $stmt = $con->prepare("SELECT * FROM users_registered WHERE regId = ? LIMIT 1");

        $stmt->execute(array($regUserId));
       
        $count = $stmt->rowCount();
                                   
        if ($count > 0 ) { 
         
        $stmt = $con->prepare("DELETE FROM users_registered WHERE regId = :regId ");
            
        $stmt->bindParam(":regId", $regUserId);

        $stmt->execute();
            
            
        echo "<p class='alert alert-success'>تم الحذف بنجاح</p>";
            echo "<p class='alert alert-success'>سوف يتم الرجوع للخلف في غضون 2 ثانية</p>";


           $url = $_SERVER['HTTP_REFERER'];
            echo '<meta http-equiv="refresh" content="2;URL=' . $url . '">';


        }
    

    
    
} else {
    
            echo "sorry";

    
}
    

} else {
        header('location:login.php');
}

?>

<!-- End projects section -->
<?php include 'footer.php' ?>

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