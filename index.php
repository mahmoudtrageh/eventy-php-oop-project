<?php 

session_start();

 include 'connection.php'; 

 include "links.php";

?>

<div class="header-background">


<?php
    

if (isset($_SESSION['usermail'])) {
         include "header.php";
                } else {
         include "header2.php";
    }


?>
    
    
    <div class="container">
     <form class="search-form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="GET">
      
      <div class="row" style="direction:rtl;">
    
    <div class="col-md-4">
        
  <select id="filter" name="search" class="select-search">
    <option>اختر المحافظة</option>
    <option value="القاهرة">القاهرة</option>
    <option value="الغربية">الغربية</option>
          <option value="الإسماعيلية">الإسماعيلية</option>
          <option value="الأسكندرية">الأسكندرية</option>
                <option value="أسوان">أسوان</option>
                <option value="أسيوط">أسيوط</option>
                <option value="البحر الأحمر">البحر الأحمر</option>
                <option value="الأقصر">الأقصر</option>
                <option value="البحيرة">البحيرة</option>
                <option value="الجيزة">الجيزة</option>
                <option value="الدقهلية">الدقهلية</option>
                <option value="السويس">السويس</option>
                <option value="الشرقية">الشرقية</option>
                <option value="الفيوم">الفيوم</option>
                <option value="القليوبية">القليوبية </option>
                <option value="المنوفية">المنوفية</option>
                <option value="المنيا">المنيا</option>
                <option value="الوادي الجديد">الوادي الجديد</option>
                <option value="بني سويف">بني سويف</option>
                <option value="بورسعيد">بورسعيد </option>
                <option value="جنوب سيناء">جنوب سيناء</option>
                <option value="دمياط">دمياط </option>
                <option value="سوهاج">سوهاج </option>
                <option value="شمال سيناء">شمال سيناء</option>
                <option value="قنا">قنا</option>
                <option value="كفر الشيخ">كفر الشيخ</option>
                <option value="مرسى مطروح">مرسى مطروح</option>
                <option value="السادس من أكتوبر">السادس من أكتوبر</option>
       
  </select>
        </div>
          
              <div class="col-md-4">

      
      <select id="my-select" name="category" class="select-search">
    <option>اختر التصنيف</option>
    <option  value="عام">عام</option>
    <option  value="علمي">علمي</option>
    <option  value="تعليمي">تعليمي</option>
    <option value="ثقافة وأدب">ثقافة وأدب</option>
          <option value="تقني">تقني</option>
          <option value="ديني إسلامي">ديني إسلامي</option>
          <option value="تنمية ذاتية">تنمية ذاتية</option>
          <option value="توظيف">توظيف</option>
            </select>
          </div>
          
          
<div class="col-md-2">
      <button name="submit" type="submit" value="submit" class="btn btn-success bn-search">ابحث</button>          
</div>
          
                      
        <div class="col-md-2 mt-1">
     <a href="events-gallery.php"><span class="btn btn-success">جميع الإيفنتات</span></a>
          </div>
          
          </div>
      
      
      
    </form>
</div>
</div>



<?php 
      
    if(isset($_GET['submit'])) {
    
        
    $search = $_GET['search'];
    $category = $_GET['category'];
    
            
                                   
 $stmt2 = $con->prepare("SELECT * FROM events WHERE status = 'مجاني' AND town = ? AND category = ?");

    $stmt2->execute(array($search, $category));
$events = $stmt2->fetchAll();



        
 $stmt3 = $con->prepare("SELECT * FROM events WHERE status = 'مدفوع' AND town = ? AND category = ?");
$stmt3->execute(array($search, $category));
$paidevents = $stmt3->fetchAll();
   

        
 $stmt4 = $con->prepare("SELECT * FROM events WHERE status = 'الدفع ضروري' AND town = ? AND category = ?");
$stmt4->execute(array($search, $category));
$requirePaids = $stmt4->fetchAll();


                

    
    ?>


<div class="container">

    
        
      <section id="gallery">


      <h3 class="text-center last-events"> <span> (<?php echo $search; ?> - <?php echo $category; ?> ) </span> الفعاليات</h3> 
 
      
    <div class="container">
      <ul class=" nav nav-tabs text-center" id="myTab" role="tablist">
          
          
          <li class="nav-item">
          <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
            aria-selected="true">(<?php echo countItem5('id', 'مجاني', $search, $category) + countItem5('id', 'مدفوع', $search, $category) + countItem5('id', 'الدفع ضروري', $search, $category) ?>) الجميع</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
            aria-selected="false">(<?php echo countItem5('id', 'مدفوع', $search, $category) + countItem5('id', 'الدفع ضروري', $search, $category)  ?>) المدفوعة</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
            aria-selected="false">(<?php echo countItem5('id', 'مجاني', $search, $category)  ?>) المجانية</a>
        </li>
          
       
          
      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">

          <section class="portfolio text-center">
            <div class="row">

    <?php

        
            if($paidevents || $events || $requirePaids) {

                foreach ((array) $paidevents as $paidevent) {
                    
                    
                    $event_date = $paidevent['date'];
                    $finish_date = $paidevent['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;
                    

                    echo "<div class='col-md-4'>";
                    echo"<span class='home-stat alert alert-success'>مدفوع</span>";
                    echo "<div class='port-img'>";
                    
                    echo "<a href='event-details.php?id=" . $paidevent['id'] . "'><img alt='an example' class='img-fluid' src='" .  $paidevent['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $paidevent['id'] . "'>" . $paidevent['EventTitle'] . "</a></h3>";
                    
                        if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p>  
                            <?php
                        }
                                    
                    echo "</div>";
                    echo "</div>";
                }
        
    

       foreach ((array) $events as $event) {
$event_date = $event['date'];
                    $finish_date = $event['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;
           
                    echo "<div class='col-md-4'>";
                               echo"<span class='home-stat alert alert-success'>مجاني</span>";

                    echo "<div class='port-img'>";
                    echo "<a href='event-details.php?id=" . $event['id'] . "'><img alt='an example' class='img-fluid' src='" .  $event['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $event['id'] . "'>" . $event['EventTitle'] . "</a></h3>";
           if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p> 
                            <?php
                        }
                    echo "</div>";
                    echo "</div>";
           

//                       }
                }
                
                foreach ((array) $requirePaids as $requirePaid) {
$event_date = $requirePaid['date'];
                    $finish_date = $requirePaid['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;
                    echo "<div class='col-md-4'>";
                                        echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";

                    echo "<div class='port-img'>";
                    echo "<a href='event-details.php?id=" . $requirePaid['id'] . "'><img alt='an example' class='img-fluid' src='" .  $requirePaid['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $requirePaid['id'] . "'>" . $requirePaid['EventTitle'] . "</a></h3>";
                    if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p> 
                            <?php
                        }
                    echo "</div>";
                    echo "</div>";
           

        
                }
//                }
                
            }else {
                
             echo "  <h1 class='text-center alert alert-danger not-find'>لا يوجد ايفنتات الآن</h1>";
                    echo "<a class='btn btn-success' href='add-event.php'>أضف فعاليتك الآن</a>";
                
            }

    ?>
                                
                  
                  </div>                

          </section>
        </div>
        


        <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
          <section class="portfolio text-center">
            <div class="row">

    <?php
        
         if($paidevents || $requirePaids){
                foreach ((array) $paidevents as $paidevent) {
                    
                    $event_date = $paidevent['date'];
                    $finish_date = $paidevent['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;

                    echo "<div class='col-md-4'>";
                                                                                echo"<span class='home-stat alert alert-success'>مدفوع</span>";

                    echo "<div class='port-img'>";

                    
                    echo "<a href='event-details.php?id=" . $paidevent['id'] . "'><img alt='an example' class='img-fluid' src='" .  $paidevent['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $paidevent['id'] . "'>" . $paidevent['EventTitle'] . "</a></h3>";
                    if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p> 
                            <?php
                        }
                    echo "</div>";
                    echo "</div>";

                }
             
             foreach ((array) $requirePaids as $requirePaid) {

                 $event_date = $rquirePaid['date'];
                    $finish_date = $requirePaid['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;
                    echo "<div class='col-md-4'>";
                                                                             echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";

                    echo "<div class='port-img'>";

                    echo "<a href='event-details.php?id=" . $requirePaid['id'] . "'><img alt='an example' class='img-fluid' src='" .  $requirePaid['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $requirePaid['id'] . "'>" . $requirePaid['EventTitle'] . "</a></h3>";
                 if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p> 
                            <?php
                        }
                    echo "</div>";
                    echo "</div>";
                                 }

        
             
         }else {
             
             echo "  <h1 class='text-center alert alert-danger not-find'>لا يوجد ايفنتات الآن</h1>";
                    echo "<a class='btn btn-success' href='add-event.php'>أضف فعاليتك الآن</a>";
             
         }

?>
                
                  </div>                

          </section>
        </div>

        <div class="tab-pane fade" id="free" role="tabpanel" aria-labelledby="free-tab">
          <section class="portfolio text-center">
            <div class="row">


               <?php     
    if($events) {
                foreach ((array) $events as $event) {
                    
                    $event_date = $event['date'];
                    $finish_date = $event['finish_date'];
                    
                     $event_day = date("d", strtotime($event_date));
                                    $event_month = date("m", strtotime($event_date)) * 30;

                                   
                                   $finish_day = date("d", strtotime($finish_date));
                                $finish_month = date("m", strtotime($finish_date)) * 30;
                                   
                                   $event_start = $event_month + $event_day;
                                   
                                   $event_finish = $finish_month + $finish_day;
                                   

                                     $current_day = date('d'); 
                                    $current_month = date('m') * 30; 
                                   
                                   $my_current = $current_month + $current_day;

                    echo "<div class='col-md-4'>";
                                                                                echo"<span class='home-stat alert alert-success'>مجاني</span>";

                    echo "<div class='port-img'>";
                    
                    echo "<a href='event-details.php?id=" . $event['id'] . "'><img alt='an example' class='img-fluid' src='" .  $event['EventImg'] . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $event['id'] . "'>" . $event['EventTitle'] . "</a></h3>";
                    if (($event_start - $my_current) < 0) {
                
                                       echo " <p> انتهي </p>";
                        } else if (($event_start - $my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                            <p> يحدث بعد : <?php echo ($event_start - $my_current); ?> يوم</p>
                            <?php
                        }
                    echo "</div>";
                    echo "</div>";

        
                }
        }else {
             
             echo "  <h1 class='text-center alert alert-danger not-find'>لا يوجد ايفنتات الآن</h1>";
                    echo "<a class='btn btn-success' href='add-event.php'>أضف فعاليتك الآن</a>";
             
         }
    
    ?>
                
              </div>
            </section>
          </div>
        </div>
          </div>
    </section>
    </div>

<?php
                                
                } else {
        ?>
    

 
           <section id="about" class="info">
        <p class="text-center">لماذا تستخدم نظم ؟</p>

        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <div class="info-element">
                        <i class="fas fa-sitemap"></i>
                        <h3>تنظيم</h3>
                        <ul>
                            <li><p>ترتيب كل تفاصيل الإيفنت بشكل مميز يسهل قراءته </p></li>
                            <li><p>لوحة تحكم لصاحب الإيفنت وللزائر لتسهيل عملية إدارة والتسجيل في الإيفنت</p></li>
                            <li><p>تنظيم عملية الإشعارات والرسائل ليبقي أطراف الإيفنت على إطلاع</p></li>
                            <li><p>تنظيم عملية الحضور بإنشاء تذكرة لكل عضو مسجل في أي إيفنت وإرفاقها ضمن قائمة صاحب الإيفنت، وبذلك يضمن سهولة عملية تسجيل الحضور</p></li>
                        </ul>
                        
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="info-element">
                            <i class="fas fa-search"></i>
                        <h3>سهولة وصول</h3>
                            <ul>
                            <li><p>بحث ذكي يسهل عملية الوصول للإيفنت حسب المكان والتصنيف الخاص به</p></li>
       
                        </ul>                    </div>
                </div>

                <div class="col-md-4">


                    <div class="info-element">
                       <i class="fas fa-user-circle"></i>
                        <h3>متابعة وتفاعل</h3>
<ul>
                            <li><p>لوحة تحكم لكل من صاحب الإيفنت والمسجلين في الإيفنت</p></li>
                            <li><p>نظام تعليقات للتفاعل بين صاحب الإيفنت والحضور لضمان إجابة كل التساؤلات</p></li>
                            <li><p>نظام إشعارات ورسائل لإبقاء المسجلين على اطلاع بكل التحديثات</p></li>
                        </ul>                    </div>
                </div>
            </div>
        </div>

    </section>



<section id="about" class="info" style="background-color:#fff;">
        <p class="text-center">قريبًا !!</p>

        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <div class="info-element">
                        <i class="fab fa-android"></i>
                        <h3>تطبيق موبايل</h3>
                        <p>قريبًا جدًا تطبيق موبايل لضمان سهولة ومرونة التفاعل مع الإيفنتات</p>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="info-element">
                        <i class="fas fa-dollar-sign"></i>
                        <h3>خدمات دفع</h3>
                        <p>بأكثر من طريقة متنوعة إلكتروني، كاش ..</p>
                    </div>
                </div>

                <div class="col-md-4">


                    <div class="info-element">
                       <i class="fas fa-search"></i>
                        <h3>إمكانية وصول</h3>
                        <p>إضافة إمكانية الوصول لمتحدثين لفعاليتك وكذلك مكان مناسب لإقامتها فيه</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
          
          
<?php
    }
    
           
           if(isset($_SESSION['usermail'])) {
               ?>

                       <button type="button" class="btn btn-success send-admin" data-toggle="modal" data-target="#exampleModal">
  راسل الإدارة
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">رسالتك</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="float-right" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
        <form action='send_message.php' method='POST'>
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit4' class="btn btn-success">أرسل </button>

        </form>
      </div>
    </div>
  </div>
</div>

<?php
           }
    ?>

          <?php include'footer.php'; ?>
 