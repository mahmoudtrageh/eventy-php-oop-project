<?php 

session_start();

 include 'connection.php'; 
 include "links.php";

?>


<div class="header-back">


<?php
    

if (isset($_SESSION['usermail'])) {
         include "header.php";
                } else {
         include "header2.php";
    }

?>

<!--   start projects section     -->        
  
        
        <?php
      
    if(!isset($_POST['submit'])) {
     
$ID = isset($_SESSION['ID']) ? $_SESSION['ID'] : '';


        $stmt2 = $con->prepare("SELECT * FROM events WHERE status = 'مجاني'");
$stmt2->execute();
$events = $stmt2->fetchAll();
        
 $stmt3 = $con->prepare("SELECT * FROM events WHERE status = 'مدفوع'");
$stmt3->execute();
$paidevents = $stmt3->fetchAll();
        
        $stmt4 = $con->prepare("SELECT * FROM events WHERE status = 'الدفع ضروري'");
$stmt4->execute();
$requirePaids = $stmt4->fetchAll();
        
    }

    
    ?>
        
        
        </div>
    
    
  <section id="gallery">
      <div class="container">
      
      <h3 class="text-center last-events">جميع الفعاليات</h3> 
      </div>
      
    <div class="container">
      <ul class=" nav nav-tabs text-center" id="myTab" role="tablist">
          
          
           <li class="nav-item">
          <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
            aria-selected="true">(<?php echo countItem('id', 'events', 'مدفوع') + countItem('id', 'events', 'مجاني') + countItem('id', 'events', 'الدفع ضروري') ?>) الجميع</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
            aria-selected="false">(<?php echo countItem('id', 'events', 'مدفوع') + countItem('id', 'events', 'الدفع ضروري') ?>) المدفوعة</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
            aria-selected="false">(<?php echo countItem('id', 'events', 'مجاني') ?>) المجانية</a>
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
                
                 echo "  <h1 class='text-center alert alert-danger'>لا يوجد محتوي</h1>";
                    echo "<a class='btn btn-outline-secondary' style='display:block;margin:0 auto;margin:20px 0 20px;' href='add-event.php'>أضف فعاليتك الآن</a>";
                
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
             
             echo "  <h1 class='text-center'>لا يوجد محتوي</h1>";
                    echo "<a class='btn btn-outline-secondary' style='display:block;margin:0 auto;margin:20px 0 20px;' href='add-event.php'>أضف فعاليتك الآن</a>";
             
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
             
             echo "  <h1 class='text-center alert alert-danger'>لا يوجد محتوي</h1>";
                    echo "<a class='btn btn-outline-secondary' style='display:block;margin:0 auto;margin:20px 0 20px;' href='add-event.php'>أضف فعاليتك الآن</a>";
             
         }
    
    ?>
            
          

                                 
                  </div>                

          </section>
</div>
          
                 
          
        </div>
      </div>
</section>
        
        <?php
        
        if (isset($_SESSION['usermail'])) {

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
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
        <form action='send_message.php' method='POST'>
            <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name ='submit4' class="btn btn-primary">أرسل </button>

        </form>
      </div>
    </div>
  </div>
</div>
        <?php
            
        }
        ?>
        
<!-- End projects section -->
<?php include 'footer.php' ?>