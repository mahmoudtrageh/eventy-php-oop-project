<?php
// start session
session_start();
// connection to data base
require_once ('modules/Database.php');

require_once ('modules/Event.php');
require_once ('functions.php');

$db = new Database();
$e = new Event();

// check if there is id get by link or not
$id = isset($_GET['id']) ? $_GET['id'] : '';
// if the user signed in
$ID = isset($_SESSION['ID']) ? $_SESSION['ID'] : ''; ?>
    <!-- start header section -->
    <div class="header-back">
    <!-- check if the user signed in -->
    <?php
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
?>  
    </div>
    <!-- start section -->
    <div class='container'>
        <div class='row event-det' style='direction:rtl;'>
        <?php
// get id from events table
$db->query("SELECT id FROM events WHERE postby='$ID'");
$regEvents = $db->resultSet();
foreach ($regEvents as $regEvent)
{
    if ($regEvent->id == $id)
    {
        echo "<div class='col-md-4'>
                         <p class='text-center'>أنت صاحب هذا الإيفنت</p>
                         <a href='one-event-dashboard.php?id=' . $id . ''><button class='btn btn-success'>توجه للوحة التحكم الآن</button></a>
                      </div>";
        //end if
        
    }
    // end foreach
    
}
// get id from users_registered table
$db->query("SELECT events_id FROM users_registered WHERE regby='$ID'");
$usersEvents = $db->resultSet();
foreach ($usersEvents as $usersEvent)
{
    if ($usersEvent->events_id == $id)
    {
        echo "<div class='col-md-4'>
                          <p class='text-center'>أنت مسجل بالفعل</p>
                          <a href='user-event-dashboard.php?id=' . $id . ''><button class='btn btn-success'>توجه لصفحة الإيفنت</button></a>
                      </div>";
    }
}
// get data from events table
$db->query("SELECT * FROM events WHERE id='$id'");
$row = $db->resultSet();
$count1 = $db->rowCount();
if ($count1 > 0)
{
    foreach ($row as $ro)
    {
        $_SESSION['EventTitle'] = $ro->EventTitle;
        $_SESSION['EventImg'] = $ro->EventImg;
        $_SESSION['status'] = $ro->status;
        $_SESSION['member_number'] = $ro->member_number;
        $_SESSION['address'] = $ro->address;
        $_SESSION['map_link'] = $ro->map_link;
        $_SESSION['fb_link'] = $ro->fb_link;
        $_SESSION['tw_link'] = $ro->tw_link;
        $_SESSION['town'] = $ro->town;
        $_SESSION['category'] = $ro->category;
        $_SESSION['postby'] = $ro->postby;
        $_SESSION['event_desc'] = $ro->event_desc;
        $_SESSION['org_desc'] = $ro->org_desc;
        $_SESSION['ticket_price'] = $ro->ticket_price;
        $_SESSION['time'] = $ro->time;
        $_SESSION['finish_time'] = $ro->finish_time;
    }
    // end if
    
}
$organizer_id = $_SESSION['postby'];
$members = $_SESSION['member_number'];
// get firstname and lastname
$db->query("SELECT firstname, lastname FROM users WHERE id='$organizer_id'");
$row7 = $db->single();
$count7 = $db->rowCount();
if ($count7 > 0)
{
    $row7->firstname;
    $row7->lastname;
}
// get data from events table
$db->query("SELECT date, finish_date FROM events WHERE id='$id'");
$rowreg = $db->single();
$countreg = $db->rowCount();
if ($countreg > 0)
{
    $_SESSION['date'] = $rowreg->date;
    $_SESSION['finish_date'] = $rowreg->finish_date;
    // end if
    
}
$event_date = $_SESSION['date'];
$finish_date = $_SESSION['finish_date'];
/* --- start event details part --- */
$e->calculateTime($event_date, $finish_date);

/* end event details part */
// start register ability part
if (countItem2('regId', $id) < $members && ($e->event_finish - $e->my_current) > 0)
{
    echo "<div class='col-md-4 reg-det' style='background-color:#27ae60;'>
                    <p>التسجيل مفتوح</p>
                  </div>";
}
else if ((countItem2('regId', $id) > $members || ($e->event_finish - $e->my_current) < 0) || ($e->event_finish - $e->my_current) == 0)
{
    echo "<div class='col-md-4 reg-det' style='background-color:#c0392b;'>
                    <p>للأسف التسجيل مغلق <br> اضغط متابعة لتعرف موعد الإيفنت القادم</p>
                  </div>";
}
// start follow part
echo "<div class='col-md-4 follow'>";
$db->query("SELECT followed_event, follower FROM follow_event WHERE followed_event = '$id' AND follower = '$ID'");
$row = $db->single();
$count = $db->rowCount();
if ($count > 0)
{
    $_SESSION['followed_event'] = $row->followed_event;
    $_SESSION['follower'] = $row->follower;
}
// make unfollow button
if (isset($row->followed_event) && ($row->followed_event == $id) && ($row->follower == $_SESSION['ID']))
{ ?>
            <form action="delete_follow.php?id=<?php echo $id ?>" method="POST">
                <button name="follow-event" type="submit" id="my_btn" class="btn btn-primary follow-event">
                        Followed
                    <span><?php echo $count; ?> </span>
                </button>
            </form>      
    <?php
}
else
{

?>      
            <!-- make follow button -->
            <form action="follow-event.php?id=<?php echo $id ?>" method="POST">
                <button name="follow-event" type="submit" id="my_btn1" class="btn btn-primary follow-event">
                    Follow
                    <span><?php echo $count; ?> </span>
                </button>
            </form>
    <?php
}
// end container and row and follow
echo "</div></div></div>"; ?>
    <!-- start second section -->
    <div class="event-detail">
        <div class="container home-stats">
        <div class="row">
            <!-- first half -->
            <div class='col-md-6'>
            <?php
echo "<h2 class='fixed-menu'>" . $_SESSION['EventTitle'] . "</h2>
                      <img alt='an example' class='img-fluid event-img' src=' " . $_SESSION['EventImg'] . " '/>";
?>
                <div class="pocket">
                    <h3>معلومات الإيفنت </h3>
                    <ul>
                        <li><p>تصنيف الإيفنت : <?php echo $_SESSION['category']; ?></p></li>
                        <li><p>المدينة : <?php echo $_SESSION['town']; ?></p></li>
                        <li><p>العنوان بالتفصيل : <?php echo $_SESSION['address']; ?></p></li>
                        <li><p> <a target='_blank' href='<?php echo $_SESSION['map_link']; ?>'>خريطة المكان</a></p></li>
                        <li><p>زمن البداية : <?php echo $_SESSION['time']; ?></p></li>
                        <li><p>زمن النهاية : <?php echo $_SESSION['finish_time'] ?></p></li>
                    </ul>
                </div>
            
                <div class="pocket">
                    <h3>وصف الإيفنت</h3>
                    <p><?php echo $_SESSION['event_desc']; ?></p>
                </div>
            
                <div class="pocket">
                    <h3>منظم الإيفنت</h3>
                    <ul>
                        <li><a href=""> <?php echo $row7->firstname . ' ' . $row7->lastname;; ?></a></li>
                    </ul>

                    <p><?php echo $_SESSION['org_desc']; ?></p>
                </div>

            </div>
            <!-- second half -->
            <div class="col-md-6">
                <a class="fixed-btn" href="register-event.php?id=<?php echo $id ?>"><button class="btn btn-success mb-5">احجز الآن</button></a>
                <!-- start event details part -->
                <h2>تفاصيل الإيفنت</h2>
                <div class="stat st-members text-right">
                    <div class="row">
                        <div class="col-md-6 details">
                            يحدث بتاريخ<br><?php echo $event_date;
echo '<br>'; ?>
                        </div>
                        <div class="col-md-6 details">
                            وينتهي في<br><?php echo $finish_date; ?>

                        </div>
                    </div>
                    <?php
if (($e->event_start - $e->my_current) == 0)
{
    echo "<div class='row'>
                                    <div class='col-md-6 details'>
                                        <h2>يحدث اليوم </h2>
                                    </div>
                                    <div class='col-md-6 details'>
                                        <p>ويستمر لمدة ... </p>";
?>
                                        <span> <?php echo ($e->event_finish - $e->event_start); ?> أيام</span><br>
                                     <?php echo '</div></div>';

}
else if (($e->event_finish - $e->my_current) < 0)
{
    echo 'انتهي' . '<br>' . 'ترقب موعد الايفنت القادم بضغط متابعة';

}
else if (($e->event_start - $e->my_current) > 0)
{
    echo '<div class="row">
                                    <div class="col-md-6 details">
                                        <p>متبقي على بداية الإيفنت </p>';
?>
                                        <span> <?php echo ($event_start - $my_current); ?> يوم</span><br>                       
                                        <?php
    echo '</div>
                                    <div class="col-md-6 details">
                                        <p> مدة الإيفنت</p>';
?>
                                        <span> <?php echo ($event_finish - $event_start); ?> يوم</span><br>                       
                                        <?php
    echo '</div>';
    echo '</div>';

}
else if (($event_start - $my_current) < 0)
{
    echo '<div class="row">
                                    <div class="col-md-6 details">
                                        <p>يحدث منذ </p>';
?>
                                        <span> <?php echo ($my_current - $event_start); ?> يوم</span><br>                       
                                        <?php
    echo '</div>
                                    <div class="col-md-6 details">
                                        <p> مدة الإيفنت</p>';
?>
                                        <span> <?php echo ($event_finish - $event_start); ?> يوم</span><br>                       
                                        <?php
    echo '</div>';
    echo '</div>';
}
?>
            </div>
            <div class="pocket">
                <p>نوع الإيفنت :<span class="alert alert-success mr-1"><?php echo $_SESSION['status'] ?></span></p>
                <?php if ($_SESSION['status'] == 'مدفوع')
{
    echo "<p>ثمن التذكرة : " . $_SESSION['ticket_price'] . " جنيه </p>
                    <p>* يمكنك الدفع عند الحضور</p>";
}
else if ($_SESSION['status'] == 'الدفع ضروري')
{
    echo "<p>ثمن التذكرة : " . $_SESSION['ticket_price'] . " جنيه </p>
                    <p>* يجب الدفع قبل الحضور وإنتهاء التسجيل</p>";
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

            <div class="pocket">
                <h3>تابع صفحات الإيفنت</h3>
                <div class="row">
                    <div class="col-md-6">
                        <a target="_blank" href="<?php echo $_SESSION['fb_link']; ?>"><i class="fab fa-facebook-square"></i></a>
                    </div>
                    <div class="col-md-6">
                        <a target="_blank" href="<?php echo $_SESSION['tw_link']; ?>"><i class="fab fa-twitter-square"></i></a>
                    </div>
                </div>
            </div>

            <div class="pocket">
                <h3> شارك الإيفنت</h3>
                <?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . ":// " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "";
?>
                <div class="row">
                    <!-- facebook share button -->
                    <div class="col-md-6">
                        <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2';
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-share-button" data-href="<?php echo $actual_link; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fmahmoudtaha.ga%2Fmy-port%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                    </div>
                    <!-- twitter share button -->
                    <div class="col-md-6">
                        <script>window.twttr = (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0],
                        t = window.twttr || {};
                        if (d.getElementById(id)) return t;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                        t._e = [];
                        t.ready = function(f) {
                        t._e.push(f);
                        };
                          return t;
                        }(document, "script", "twitter-wjs"));</script>
                        <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=Hello%20world">Tweet</a>
                    </div>
                  </div>
            </div>

            <div class="pocket">
                <h3>فعاليات أخرى قد تهمك</h3>
                <?php
$db->query("SELECT status, category FROM events WHERE id='$id'");
$row1 = $db->single();
$count1 = $db->rowCount();
if ($count1 > 0)
{
    $_SESSION['status'] = $row1->status;
    $_SESSION['category'] = $row1->category;
}
$status = $_SESSION['status'];
$category = $_SESSION['category'];

$db->query("SELECT * FROM events WHERE status = '$status' AND category = '$category' AND id != '$id'");
$events = $db->resultSet();
?>

                <section class="portfolio text-center">
                    <div class="container">
                        <div class="row" style='direction:rtl;'>
                            <?php
foreach ($events as $event)
{
    echo "<div class='col-md-6'>
                                              <div class='port-img'>";
    // type of pay
    if ($_SESSION['status'] == 'مجاني')
    {
        echo "<span class='details-stat alert alert-success'>مجاني</span>";
    }
    else if ($_SESSION['status'] == 'مدفوع')
    {
        echo "<span class='details-stat alert alert-success'>مدفوع</span>";
    }
    else
    {
        echo "<span class='details-stat alert alert-success'>ضروري الدفع</span>";
        // end if
        
    }
    echo "<a href='event-details.php?id=" . $event->id . "'><img alt='an example' class='img-fluid' src='" . $event->EventImg . "' /></a>
                                                    <div class='caption'>
                                                        <h3><a href='event-details.php?id=" . $event->id . "'>" . $event->EventTitle . "</a></h3>
                                                    </div>
                                                </div>
                                        </div>";
    // end foreach
    
}
?>
                        </div>
                    </div>
                </section>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php require_once ('layouts/footer.php'); ?>
