<?php

session_start();

if (isset($_SESSION['usermail']))
{ ?>



<?php
    require_once ('modules/Database.php');

    $db = new Database();

    $id = $_GET['id'];

    $db->query("SELECT * FROM events WHERE id='$id' ");
    $row = $db->single();
    $count1 = $db->rowCount();

    if ($count1 > 0)
    {

        // register session with username
        $_SESSION['EventTitle'] = $row->EventTitle;
        $_SESSION['EventImg'] = $row->EventImg;
        $_SESSION['status'] = $row->status;
        $_SESSION['member_number'] = $row->member_number;
        $_SESSION['address'] = $row->address;
        $_SESSION['map_link'] = $row->map_link;
        $_SESSION['fb_link'] = $row->fb_link;
        $_SESSION['tw_link'] = $row->tw_link;
        $_SESSION['town'] = $row->town;
        $_SESSION['category'] = $row->category;
        $_SESSION['postby'] = $row->postby;
        $_SESSION['event_desc'] = $row->event_desc;
        $_SESSION['org_desc'] = $row->org_desc;
        $_SESSION['ticket_price'] = $row->ticket_price;
        $_SESSION['voda_num'] = $row->voda_num;

    }

?>

<?php require_once ('layouts/header.php'); ?>


<div class="register-event">
  <div class="container">
    <h2 class="text-center">سجل الآن</h2>
    <div class="row">
      <div class="col-md-6">
         <div class="pocket mt-3">
          <h3>معلومات الإيفنت </h3>
            <ul>
            <li><p>تصنيف الإيفنت : <?php echo $_SESSION['category']; ?></p></li>
            <li><p>المدينة : <?php echo $_SESSION['town']; ?></p></li>
            <li><p>العنوان بالتفصيل : <?php echo $_SESSION['address']; ?></p></li>
            <p><?php echo $_SESSION['address'] ?></p>
            <li><p> <a target='_blank' href='<?php echo $_SESSION['map_link']; ?>'>خريطة المكان</a></p></li>
            </ul>
        </div>

       <div class="pocket">
              <p>نوع الإيفنت :<span class="alert alert-success mr-1"><?php echo $_SESSION['status'] ?></span></p>
                <?php if ($_SESSION['status'] == 'مدفوع')
    {
        echo "<p>ثمن التذكرة : " . $_SESSION['ticket_price'] . " جنيه </p>";
        echo "<p>* يمكنك الدفع عند الحضور</p>";

    }
    else if ($_SESSION['status'] == 'الدفع ضروري')
    {
        echo "<p>ثمن التذكرة : " . $_SESSION['ticket_price'] . " جنيه </p>";
        echo "<p>* يجب الدفع قبل الحضور وإنتهاء التسجيل</p>";
    }
    else if ($_SESSION['status'] == 'مجاني')
    {
        echo "<p>* يشرفنا حضورك مجانًا</p>";
    }

?>
        


        </div>
          
        <div class="pocket">
          <h3>ملاحظات هامة</h3>
            <ul>
            <li>لا تقم بالتسجيل إلا إذا كنت متأكد من الحضور</li>
            <li>لا تبخل بالتقييم على الإيفنت بعد الحضور</li>
            </ul>
        </div>
          
      </div>
        


      <div class="col-md-6">
          <form class="text-right" enctype="multipart/form-data" action="saveRegMember.php" method="post" >
               <input type="hidden" name="myid" value="<?php echo $id ?>" />
                <input type="hidden" name="reg_code">
        <input name="firstname" class="form-control mb-4 mt-3" type="text" placeholder="اسمك الأول">
        <input name="lastname" class="form-control mb-4" type="text" placeholder="اسمك الأخير">
        <input name="regmail" class="form-control mb-4" type="email" placeholder="بريدك الإلكتروني">
        
        
              <?php

    if ($_SESSION['status'] == 'الدفع ضروري')
    {
        echo "<p>يمكنك تحويل المبلغ المطلوب على الرقم : <span class='alert alert-success'>" . $_SESSION['voda_num'] . "</span></p>";
        echo "
                    <label>قم بإضافة رقمك الخاص بالتحويل</label>
                   <input name='vodNumber' class='form-control mb-4 mt-4' type='tel' placeholder='رقم هاتفك'>



           ";

    }
    else if ($_SESSION['status'] == 'مدفوع')
    {
        echo '<p>بإمكانك التسجيل والدفع عند الحضور</p>';
    }
    else if ($_SESSION['status'] == 'مجاني')
    {
        echo '<p>يشرفنا تسجيلك وحضورك مجانًا</p>';
    }

?>
                        
    <button name="action" type="submit" class="btn btn-success">سجل</button>
        </form>
                 
           </div>
    </div>

  </div>
</div>

<?php
}
else
{
    header('location:login.php');
}

?>

<?php require_once ('layouts/footer.php'); ?>
