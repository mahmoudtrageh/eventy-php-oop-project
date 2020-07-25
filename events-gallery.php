<?php
session_start();

require_once ('modules/Event.php');

?>


<div class="header-back">


<?php
$e = new Event();

if (isset($_SESSION['usermail']))
{
    // the header of signed in user
    require_once ('layouts/header.php');
}
else
{
    // the header of user not signed in
    require_once ('layouts/header2.php');
}

$freeEvents = $e->getEventByStatus('مجاني');
$paidevents = $e->getEventByStatus('مدفوع');
$requirePaids = $e->getEventByStatus('الدفع ضروري');
$allEvents = $e->getEvents();

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
            aria-selected="true">الجميع</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
            aria-selected="false">مدفوع</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
            aria-selected="false">مجاني</a>
        </li>
          
       
          
      </ul>

      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">

          <section class="portfolio text-center">
            <div class="row">

    <?php

foreach ((array)$allEvents as $allEvent)
{

    $event_date = $allEvent->date;

    $finish_date = $allEvent->finish_date;

    $e->calculateTime($event_date, $finish_date);

    echo "<div class='col-md-4'>";
    echo "<span class='home-stat alert alert-success'>" . $allEvent->status . "</span>";
    echo "<div class='port-img'>";

    echo "<a href='event-details.php?id=" . $allEvent->id . "'><img alt='an example' class='img-fluid' src='" . $allEvent->EventImg . "' /></a>";
    echo "<h3><a href='event-details.php?id=" . $allEvent->id . "'>" . $allEvent->EventTitle . "</a></h3>";

    if (($e->event_start - $e->my_current) < 0)
    {

        echo " <p> انتهي </p>";
    }
    else if (($e->event_start - $e->my_current) == 0)
    {
        echo "<p> يحدث اليوم </p>";
    }
    else
    {
?>
                            <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>  
                            <?php
    }

    echo "</div>";
    echo "</div>";
}

?>
                                
                  
                  </div>                

          </section>
        </div>
        


        <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
          <section class="portfolio text-center">
            <div class="row">

    <?php
if ($paidevents || $requirePaids)
{
    foreach ((array)$paidevents as $paidevent)
    {

        $event_date = $paidevent->date;
        $finish_date = $paidevent->finish_date;

        $e->calculateTime($event_date, $finish_date);

        echo "<div class='col-md-4'>";
        echo "<span class='home-stat alert alert-success'>مدفوع</span>";

        echo "<div class='port-img'>";

        echo "<a href='event-details.php?id=" . $paidevent->id . "'><img alt='an example' class='img-fluid' src='" . $paidevent->EventImg . "' /></a>";
        echo "<h3><a href='event-details.php?id=" . $paidevent->id . "'>" . $paidevent->EventTitle . "</a></h3>";
        if (($e->event_start - $e->my_current) < 0)
        {

            echo " <p> انتهي </p>";
        }
        else if (($e->event_start - $e->my_current) == 0)
        {
            echo "<p> يحدث اليوم </p>";
        }
        else
        {
?>
                            <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p> 
                            <?php
        }
        echo "</div>";
        echo "</div>";

    }

    foreach ((array)$requirePaids as $requirePaid)
    {

        $event_date = $requirePaid->date;
        $finish_date = $requirePaid->finish_date;

        $e->calculateTime($event_date, $finish_date);

        echo "<div class='col-md-4'>";
        echo "<span class='home-stat alert alert-success'>ضروري الدفع</span>";

        echo "<div class='port-img'>";

        echo "<a href='event-details.php?id=" . $requirePaid->id . "'><img alt='an example' class='img-fluid' src='" . $requirePaid->EventImg . "' /></a>";
        echo "<h3><a href='event-details.php?id=" . $requirePaid->id . "'>" . $requirePaid->EventTitle . "</a></h3>";
        if (($e->event_start - $e->my_current) < 0)
        {

            echo " <p> انتهي </p>";
        }
        else if (($e->event_start - $e->my_current) == 0)
        {
            echo "<p> يحدث اليوم </p>";
        }
        else
        {
?>
                            <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p> 
                            <?php
        }
        echo "</div>";
        echo "</div>";
    }

}
else
{

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

if ($freeEvents)
{
    foreach ((array)$freeEvents as $freeEvent)
    {

        $event_date = $freeEvent->date;
        $finish_date = $freeEvent->finish_date;

        $e->calculateTime($event_date, $finish_date);

        echo "<div class='col-md-4'>";
        echo "<span class='home-stat alert alert-success'>" . $freeEvent->status . "</span>";

        echo "<div class='port-img'>";

        echo "<a href='event-details.php?id=" . $freeEvent->id . "'><img alt='an example' class='img-fluid' src='" . $freeEvent->EventImg . "' /></a>";
        echo "<h3><a href='event-details.php?id=" . $freeEvent->id . "'>" . $freeEvent->EventTitle . "</a></h3>";
        if (($e->event_start - $e->my_current) < 0)
        {

            echo " <p> انتهي </p>";
        }
        else if (($e->event_start - $e->my_current) == 0)
        {
            echo "<p> يحدث اليوم </p>";
        }
        else
        {
?>
                            <p> يحدث بعد : <?php echo ($e->event_start - $e->my_current); ?> يوم</p>
                            <?php
        }
        echo "</div>";
        echo "</div>";

    }
}
else
{

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
if (isset($_SESSION['usermail']))
{

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
<?php require_once ('layouts/footer.php'); ?>
