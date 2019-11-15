<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['usermail'])) {?>


<?php include 'connection.php'; ?>
    
    <?php include "links.php" ?>

<?php include "header.php" ;


$ID = isset($_GET['id']) ? $_GET['id'] : '';
                                    
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

                                   
if ( $do == 'Manage'){
    
    $query = '';
    
    if(isset($_GET['page']) && $_GET['page'] == 'pending') {
        $query = 'AND reg_status=0';
    }
    
    $stmtManage = $con->prepare("SELECT * FROM users_registered WHERE events_id='$ID' $query");
    $stmtManage->execute();
    $usersRegistered = $stmtManage->fetchAll();
    
    
    $stmtManage1 = $con->prepare("SELECT * FROM users_registered WHERE events_id='$ID'");
    $stmtManage1->execute();
    $usersRegistered1 = $stmtManage1->fetchAll();
    
    
    
?>

<button style="width:30%;margin:0 auto;display:block;" class="btn btn-success mt-5 print-btn" onclick="myFunction()">اطبع القائمة</button>

    
   
<span class="mess-btn-all btn btn-success mt-4">راسل الجميع</span>
 <form class="mess-form-all" action='send_message.php' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
                 <input name='events_id' type='hidden' value='<?php echo $ID ?>'>

            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit2' class="btn btn-primary">راسل الجميع</button>

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

<a href="one-event-members.php?do=DeleteAll&id=<?php echo $ID; ?>" class="mess-delete-all btn btn-success mt-4 float-right">حذف الجميع</a>


<?php if( $_SESSION['status'] == 'الدفع ضروري') { ?>

<table style="direction:rtl;">
    
        <tr>
    <td>الترتيب</td> 
    <td>الإسم الأول</td> 
    <td>الإسم الأخير</td>         
    <td>البريد الإلكتروني</td>             
    <td>الهاتف</td> 
    <td class="info">التذكرة</td> 
    <td class="setting">اعدادات</td> 
                <td>الحالة</td> 
    <td>الحضور</td> 
    </tr>
    
                    
        <?php
    
    foreach ((array) $usersRegistered as $Reguser) {
        
        echo "<tr>";
        
        echo "<td>"
        
        ?>
    
    <script>
    
        for(i=1; i<$Reguser.length; i++) {
            return i;
        }
    
    </script>
    
    <?php
            
            "</td>";
        echo "<td>" . $Reguser['firstname'] . "</td>";
        echo "<td>" . $Reguser['lastname'] . "</td>";
        echo "<td>" . $Reguser['regmail'] . "</td>";
                echo "<td>" . $Reguser['phone_num'] . "</td>";
                echo "<td class='info'>" . $Reguser['reg_code'] . "</td>";
        echo "<td class='setting'>
        
        <a class='btn btn-danger confirm' href='one-event-members.php?do=Delete&regId=" . $Reguser['regId'] . "'>حذف</a> |
        
        ";
        ?>
    
        <span class="btn btn-success mess-btn">رسالة</span>

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
                  echo "<td><a class='btn btn-success not-activate' href='one-event-members.php?do=Active&regId=" . $Reguser['regId'] . "'>تفعيل</a></td>"; 
                                echo "<td></td>";


        } else {
            
            
            echo "<td><p class='alert alert-success'>مفعل</p></td>"; 
                echo "<td></td>";

        }
        
        ?>
    
    
    <?php
        
        


        echo "</tr>";
        
    }
    
            
            ?>
    
    

</table>


<?php } else { ?>

<table style="direction:rtl;">
        <tr>
    <td>الترتيب</td> 
    <td>الإسم الأول</td> 
    <td>الإسم الأخير</td>         
    <td>البريد الإلكتروني</td>             
    <td class="info">التذكرة</td> 
    <td class="setting">إعدادات</td> 
    <td>الحضور</td> 
    </tr>
    
                    
        <?php
    
    foreach ((array) $usersRegistered1 as $Reguser1) {
        
        echo "<tr>";
        
 echo "<td>1</td>";
        echo "<td>" . $Reguser1['firstname'] . "</td>";
        echo "<td>" . $Reguser1['lastname'] . "</td>";
        echo "<td>" . $Reguser1['regmail'] . "</td>";
        echo "<td class='info'>" . $Reguser1['reg_code'] . "</td>";
        echo "<td class='setting'>
        <a class='btn btn-danger confirm' href='one-event-members.php?do=Delete&regId=" . $Reguser1['regId'] . "'>حذف</a> |
                
        "; 
    
    ?>
    
    <span class="btn btn-success mess-btn">رسالة</span>
                
        <form class="mess-form" action='send_message.php?id=<?php echo $Reguser1['events_id'] ?>' method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <input name='mess_to' type='hidden' value='<?php echo $Reguser1['regby'] ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit' class="btn btn-primary">أرسل</button>

        </form>


    <?php echo "
        
        </td>";
        
        
                echo "<td></td>";


        echo "</tr>";
        
    }
    
            
            ?>
    
    

</table>

<?php } ?>

<?php
    
    
    } else if($do == 'Active') {
    
    $ID = isset($_GET['id']) ? $_GET['id'] : '';

    
    echo "<h1 class='text-center'>Active</h1>";
    

    $regId = $_GET['regId'];
    
    
     $stmt = $con->prepare("SELECT reg_status FROM users_registered WHERE regId = '$regId'");
                $stmt->execute();
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
    
                if ($count > 0 ) {
            
        
                    $_SESSION['reg_status'] = $row['reg_status'];

                    }
    
                   
             if($_SESSION['reg_status'] == 0) {
                 
                         $regStatus = 1;

        $stmt = $con->prepare("UPDATE users_registered SET reg_status = ? WHERE regId = ? ");
        $stmt->execute(array($regStatus, $regId));
        
                    
   header('Location: ' . $_SERVER['HTTP_REFERER']);

             
             } else {
                 echo 'sorry';

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
            
   header('Location: ' . $_SERVER['HTTP_REFERER']);


            
    
} else {
    
            echo "sorry";
}

    
} elseif($do == 'DeleteAll') {
                
    
    $regDeleteId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
                                   
        $stmt = $con->prepare("SELECT * FROM users_registered WHERE events_id = ? LIMIT 1");

        $stmt->execute(array($regDeleteId));
       
        $count = $stmt->rowCount();
                                   
        if ($count > 0 ) { 
         
        $stmt = $con->prepare("DELETE FROM users_registered WHERE events_id = :events_id ");
            
        $stmt->bindParam(":events_id", $regDeleteId);

        $stmt->execute();
            
   header('Location: ' . $_SERVER['HTTP_REFERER']);


            
        }
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
            return confirm('هل أنت متأكد من عملية الحذف؟');
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