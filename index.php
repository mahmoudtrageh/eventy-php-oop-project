<?php 
   session_start();
   
   require_once('modules/Database.php');
   
   require_once('modules/Event.php');
   
   ?>
<div class="header-background">
   <?php
      if (isset($_SESSION['usermail'])) {
        // the header of signed in user
         require_once ('layouts/header.php');
                } else {
      // the header of user not signed in
         require_once ('layouts/header2.php');
      }
      
          $page_title = 'الرئيسية'; 
      
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
   
           $e = new Event();
   
    $freeEvents = $e->getEventsHome('مجاني', $search, $category);
    $countFree = $e->rowCount();
    $paidevents = $e->getEventsHome('مدفوع', $search, $category);
      $countPaid = $e->rowCount();
    $requirePaids = $e->getEventsHome('الدفع ضروري', $search, $category);
    $countRequire = $e->rowCount();
    $allEvents = $e->getEventsHomeAll($search, $category);
    $countAll = $e->rowCount();
   
   ?>
<!-- start container -->
<div class="container">
   <section id="gallery">
      <h3 class="text-center last-events"> <span> (<?php echo $search; ?> - <?php echo $category; ?> ) </span> الفعاليات</h3>
      <div class="container">
         <ul class=" nav nav-tabs text-center" id="myTab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
                  aria-selected="true">(<?php echo $countAll ?>) الجميع</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
                  aria-selected="false">(<?php echo $countRequire + $countPaid ?>) المدفوعة</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
                  aria-selected="false">(<?php echo $countFree ?>) المجانية</a>
            </li>
         </ul>
         <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
               <section class="portfolio text-center">
                  <div class="row">
                     <?php
                        if($allEvents) {
                        
                             foreach ((array) $allEvents as $allEvent) {
                        
                        
                        $event_date = $allEvent->date;
                        
                        $finish_date = $allEvent->finish_date;
                        
                        $e->calculateTime($event_date, $finish_date);
                        
                        
                        echo "<div class='col-md-4'>";
                        echo"<span class='home-stat alert alert-success'>" . $allEvent->status . "</span>";
                        echo "<div class='port-img'>";
                        
                        echo "<a href='event-details.php?id=" . $allEvent->id . "'><img alt='an example' class='img-fluid' src='" .  $allEvent->EventImg . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $allEvent->id . "'>" . $allEvent->EventTitle . "</a></h3>";
                        
                        if (($e->event_start - $e->my_current) < 0) {
                        
                                       echo " <p> انتهي </p>";
                        } else if (($e->event_start - $e->my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                     <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>
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
            <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
               <section class="portfolio text-center">
                  <div class="row">
                     <?php
                        if($paidevents || $requirePaids){
                                foreach ((array) $paidevents as $paidevent) {
                        
                        
                        
                        $event_date = $paidevent->date;
                        $finish_date = $paidevent->finish_date;
                        
                        $e->calculateTime($event_date, $finish_date);
                        
                        echo "<div class='col-md-4'>";
                                                                                echo"<span class='home-stat alert alert-success'>مدفوع</span>";
                        
                        echo "<div class='port-img'>";
                        
                        
                        echo "<a href='event-details.php?id=" . $paidevent->id . "'><img alt='an example' class='img-fluid' src='" .  $paidevent->EventImg . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $paidevent->id . "'>" . $paidevent->EventTitle . "</a></h3>";
                        if (($e->event_start - $e->my_current) < 0) {
                        
                                       echo " <p> انتهي </p>";
                        } else if (($e->event_start - $e->my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                     <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>
                     <?php
                        }
                        echo "</div>";
                        echo "</div>";
                        
                        }
                        
                        foreach ((array) $requirePaids as $requirePaid) {
                        
                        $event_date = $requirePaid->date;
                        $finish_date = $requirePaid->finish_date;
                        
                        $e->calculateTime($event_date, $finish_date);
                        
                        echo "<div class='col-md-4'>";
                                                                             echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";
                        
                        echo "<div class='port-img'>";
                        
                        echo "<a href='event-details.php?id=" . $requirePaid->id . "'><img alt='an example' class='img-fluid' src='" .  $requirePaid->EventImg . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $requirePaid->id . "'>" . $requirePaid->EventTitle . "</a></h3>";
                        if (($e->event_start - $e->my_current) < 0) {
                        
                                       echo " <p> انتهي </p>";
                        } else if (($e->event_start - $e->my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                     <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>
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
                        if($freeEvents) {
                                    foreach ((array) $freeEvents as $freeEvent) {
                        
                        $event_date = $freeEvent->date;
                        $finish_date = $freeEvent->finish_date;
                        
                        $e->calculateTime($event_date, $finish_date);
                        
                        echo "<div class='col-md-4'>";
                                                                                echo"<span class='home-stat alert alert-success'>" . $freeEvent->status ."</span>";
                        
                        echo "<div class='port-img'>";
                        
                        echo "<a href='event-details.php?id=" . $freeEvent->id . "'><img alt='an example' class='img-fluid' src='" .  $freeEvent->EventImg . "' /></a>";
                        echo "<h3><a href='event-details.php?id=" . $freeEvent->id . "'>" . $freeEvent->EventTitle . "</a></h3>";
                        if (($e->event_start - $e->my_current) < 0) {
                        
                                       echo " <p> انتهي </p>";
                        } else if (($e->event_start - $e->my_current) == 0) {
                            echo "<p> يحدث اليوم </p>";
                        } else {
                            ?>
                     <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>
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
<!-- end container -->
<?php
   } else {
   ?>
<!-- start about -->
<section id="about" class="info">
   <p class="text-center">لماذا تستخدم نظم ؟</p>
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <div class="info-element">
               <i class="fas fa-sitemap"></i>
               <h3>تنظيم</h3>
               <ul>
                  <li>
                     <p>ترتيب كل تفاصيل الإيفنت بشكل مميز يسهل قراءته </p>
                  </li>
                  <li>
                     <p>لوحة تحكم لصاحب الإيفنت وللزائر لتسهيل عملية إدارة والتسجيل في الإيفنت</p>
                  </li>
                  <li>
                     <p>تنظيم عملية الإشعارات والرسائل ليبقي أطراف الإيفنت على إطلاع</p>
                  </li>
                  <li>
                     <p>تنظيم عملية الحضور بإنشاء تذكرة لكل عضو مسجل في أي إيفنت وإرفاقها ضمن قائمة صاحب الإيفنت، وبذلك يضمن سهولة عملية تسجيل الحضور</p>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-4">
            <div class="info-element">
               <i class="fas fa-search"></i>
               <h3>سهولة وصول</h3>
               <ul>
                  <li>
                     <p>بحث ذكي يسهل عملية الوصول للإيفنت حسب المكان والتصنيف الخاص به</p>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-4">
            <div class="info-element">
               <i class="fas fa-user-circle"></i>
               <h3>متابعة وتفاعل</h3>
               <ul>
                  <li>
                     <p>لوحة تحكم لكل من صاحب الإيفنت والمسجلين في الإيفنت</p>
                  </li>
                  <li>
                     <p>نظام تعليقات للتفاعل بين صاحب الإيفنت والحضور لضمان إجابة كل التساؤلات</p>
                  </li>
                  <li>
                     <p>نظام إشعارات ورسائل لإبقاء المسجلين على اطلاع بكل التحديثات</p>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end about -->
<!-- start about -->
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
<!-- end about -->
<?php
   }
   
    if(isset($_SESSION['usermail'])) {
   ?>
<button type="button" class="btn btn-success send-admin" data-toggle="modal" data-target="#exampleModal">
راسل الإدارة
</button>
<!-- start Modal -->
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
<!-- end modal -->
<?php
   }
   ?>
<?php require_once ('layouts/footer.php'); ?>