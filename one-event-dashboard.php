<?php

session_start();

if (isset($_SESSION['usermail']))
{

    require_once ('modules/Database.php');
    require_once ('functions.php');

    $db = new Database();

?>
<div class="header-back">


<?php
    require_once ('layouts/header.php');

    $id = $_GET['id'];

?>
</div>
    

<!--    start dashboard -->
    

<?php

?>
                                   
    
    <div class="container home-stats text-center">
        
                    <?php

    $db->query("SELECT follower FROM follow_event WHERE followed_event = '$id'");
    $rowreg = $db->single();
    $countreg = $db->rowCount();

?>
        
        
        
        
                
          <div class="row">
            
            <div class="col-md-3 mt-5">
                
                <a class="btn btn-primary " href='event_followers.php?id=<?php echo $id; ?>'>المتابعين</a><span style="border:1px solid;padding:10px;"><?php echo $countreg; ?> </span>
        
                                                            
                        <div class="stat st-members" style="direction:rtl;">
                            يحدث بتاريخ <br>
                            
                            <?php
    $db->query("SELECT date, finish_date, EventTitle FROM events WHERE id='$id'");
    $rowreg = $db->single();
    $countreg = $db->rowCount();

    if ($countreg > 0)
    {

        // register session with username
        $_SESSION['date'] = $rowreg->date;
        $_SESSION['finish_date'] = $rowreg->finish_date;
        $_SESSION['EventTitle'] = $rowreg->EventTitle;

    }

    $event_date = $_SESSION['date'];
    $finish_date = $_SESSION['finish_date'];

    echo $event_date;
    echo '<br>';

    echo 'وينتهي في' . '<br>';
    echo $finish_date;

    $event_day = date("d", strtotime($event_date));
    $event_month = date("m", strtotime($event_date)) * 30;

    $finish_day = date("d", strtotime($finish_date));
    $finish_month = date("m", strtotime($finish_date)) * 30;

    echo '<br>';

    $event_start = $event_month + $event_day;

    $event_finish = $finish_month + $finish_day;

    $current_day = date('d');
    $current_month = date('m') * 30;

    $my_current = $current_month + $current_day;

    if (($event_start - $my_current) == 0)
    {

        echo "
                                       <h2>يحدث اليوم </h2>
                                       ";

        echo " <p>ويستمر لمدة ... </p>";
?>
                                       
                                              <span> <?php echo ($event_finish - $event_start); ?> أيام</span><br>
                                       
                                  
                                       
                                       <?php
    }
    else if (($event_finish - $my_current) < 0)
    {

        echo 'انتهي' . '<br>' . 'ترقب موعد الايفنت القادم بضغط متابعة';

    }
    else if (($event_start - $my_current) > 0)
    {
        echo " <p>متبقي على بداية الإيفنت </p>";
?>
                            
                            <span> <?php echo ($event_start - $my_current); ?> يوم</span><br>                       
                       <?php
        echo " <p> مدة الإيفنت</p>";
?>
                            
                            <span> <?php echo ($event_finish - $event_start); ?> يوم</span><br>                       
                       <?php

    }
    else if (($event_start - $my_current) < 0)
    {

        echo " <p>يحدث منذ </p>";
?>
                                    
                                       <span> <?php echo ($my_current - $event_start); ?> يوم</span><br>                       

                <?php

        echo " <p> مدة الإيفنت</p>";
?>
                            
                            <span> <?php echo ($event_finish - $event_start); ?> يوم</span><br>                       
                       <?php

    }

?>
                           
                                   
                        </div>
        
            
           
                    
                    
                    <?php

    $db->query("SELECT status FROM events WHERE id='$id'");
    $row = $db->single();
    $count1 = $db->rowCount();

    if ($count1 > 0)
    {

        // register session with username
        $_SESSION['status'] = $row->status;

    }

    if (($_SESSION['status']) == 'الدفع ضروري')
    {

?>
                    
                     <div class="col-md-12">
                
                 <div class="stat st-registered">
                           المسجلين المفعلين
                    <span><a href="one-event-members.php?id=<?php echo $id ?>"><?php echo count(countItem2('regId', $id)); ?></a></span>
                </div>
            
            </div>
                    
                    <div class="col-md-12">
                
                 <div class="stat st-registered">
                         المسجلين الغير مفعلين
                    <span><a href="one-event-members.php?id=<?php echo $id ?>&page=pending"><?php echo count(countItem4('regId', 'الدفع ضروري', 0)); ?></a></span>
                </div>
            
            </div>
                    
                    <?php
    }
    else
    { ?>
                    
                    <div class="col-md-12">
                
                 <div class="stat st-registered">
                          Total Registers
                    <span><a href="one-event-members.php?id=<?php echo $id ?>"><?php echo count(countItem2('regId', $id)) ?></a></span>
                </div>
            
            </div>
                    
                    <?php
    } ?>
                    
        
    </div>
            
            
               
                        <div class="col-md-9">
                            
                                            <h3 class="event-det text-center mt-5"><?php echo $_SESSION['EventTitle']; ?></h3>


                <p class="alert alert-success mt-5">قم بنشر بوست الآن</p>

                <form id='comment_form' enctype='multipart/form-data' action="add_comment.php?id=<?php echo $id; ?>" method='POST'>
                    <input name='comment_date' type='hidden' value='<?php echo date(' Y-m-d H:i:s '); ?>'>
                    <textarea name='comment_content' id='comment_content' placeholder='أكتب تعليقك هنا' class='form-control' rows='5'></textarea>
                    <button class='btn btn-outline-secondary mt-2' name='action' type='submit'>نشر</button>

                </form>

                <?php

    $db->query(" SELECT * FROM comments WHERE comment_event='$id' ORDER BY comment_id DESC");
    $comments = $db->resultSet();
    $countreg = $db->rowCount();

?>
                
                <h1 class="comment_det"> (<?php echo $countreg; ?>)عدد التعليقات </h1>
                <?php
    $db->query(" SELECT * FROM replies WHERE reply_event = '$id'");
    $replies = $db->resultSet();
    $count = $db->rowCount();

    foreach ($comments as $comment)
    {

        echo "<div class='event-post'>";

        $IDD = $comment->user_id;

        $db->query(" SELECT firstname, lastname FROM users WHERE id='$IDD'");
        $users = $db->resultSet();

        foreach ($users as $user)
        {
            echo "<a href='user-profile.php?id=" . $comment->user_id . "'><p>" . $user->firstname . ' ' . $user->lastname . "</p></a>";

        }

        echo "<p>" . $comment->date . "</p>";
        echo nl2br("<p>" . $comment->comment . "</p>");

        echo '  <h3 class="add-com-btn">أضف رد</h3>';

        echo ' <form class="reply_form" enctype="multipart/form-data" action="add_reply.php?id=' . $comment->comment_event . '" method="POST">
         
                             <input name="comment_id" type="hidden" value="' . $comment->comment_id . '">
                    <input name="reply_date" type="hidden" value="' . date(" Y-m-d H:i:s ") . '">
                    <textarea name="reply_content" placeholder="أكتب ردك هنا" class="form-control" rows="2"></textarea>
                    <button class="btn btn-outline-secondary mt-2 reply" name="action" type="submit">تعليق</button>

        </form>
    ';

        $comment_id = $comment->comment_id;

        $db->query(" SELECT * FROM replies WHERE reply_event='$id' AND comment_id='$comment_id'");
        $replies = $db->resultSet();
        $count = $db->rowCount();

?>
                <h3 class="reply_det"> (<?php echo $count; ?>)عدد الردود </h3>
                <?php
        $db->query(" SELECT * FROM replies ORDER BY date DESC");
        $replies = $db->resultSet();
        $count = $db->rowCount();

        foreach ($replies as $reply)
        {

            if ($comment->comment_id == $reply->comment_id)
            {
                echo "<div class='event-reply'>";

                $IDD = $reply->user_id;

                $db->query(" SELECT firstname, lastname FROM users WHERE id='$IDD'");
                $users = $db->resultSet();

                foreach ($users as $user)
                {
                    echo "<a href='user-profile.php?id=" . $reply->user_id . "'><p>" . $user->firstname . ' ' . $user->lastname . "</p></a>";

                }

                echo "<p>" . $reply->date . "</p>";
                echo nl2br("<p>" . $reply->reply . "</p>");

                if ($reply->user_id == $_SESSION['ID'])
                {
                    echo "
                    
                    <form action='edit_reply.php?id=$id' method='POST' class='edit-reply'>
                    <input name='comment_id' type='hidden' value=' " . $reply->comment_id . " '>
                    <input name='reply_date' type='hidden' value=' " . $reply->date . " '>
                                        <input name='reply_id' type='hidden' value=' " . $reply->reply_id . " '>
                                                            <input name='type' type='hidden' value='admin'>


                                        <input name='user_id' type='hidden' value=' " . $reply->user_id . " '>
                    <textarea style='display:none;' name='reply_content' class='form-control' rows='5'>" . $reply->reply . "</textarea>
                    <button class='btn btn-outline-secondary'>Edit</button>
                    </form>
                    
                    <form action='delete_reply.php?id=$id' method='POST' class='delete-reply'>
                    <input name='reply_id' type='hidden' value=' " . $reply->reply_id . " '>
                    <input name='comment_id' type='hidden' value=' " . $reply->comment_id . " '>
                    <button class='btn btn-outline-secondary'>Delete</button>
                    </form>
                    ";

                }
                //
                echo "</div>";

            }

        }

        if ($comment->user_id == $_SESSION['ID'])
        {
            echo "
                    
                    <form action='edit_comment.php?id=$id' method='POST' class='edit-form'>
                    <input name='comment_id' type='hidden' value=' " . $comment->comment_id . " '>
                    <input name='comment_content' type='hidden' value=' " . $comment->date . " '>
                                        <input name='user_id' type='hidden' value=' " . $comment->user_id . " '>
                                        <input name='type' type='hidden' value='admin'>

                    <textarea style='display:none;' name='comment_content' class='form-control' rows='5'>" . $comment->comment . "</textarea>
                    <button class='btn btn-outline-secondary'>Edit</button>
                    </form>
                    
                    <form action='delete_comment.php?id=$id' method='POST' class='delete-form'>
                    <input name='comment_id' type='hidden' value=' " . $comment->comment_id . " '>
                    <button class='btn btn-outline-secondary'>Delete</button>
                    </form>
                    ";

        }

        echo "</div>";

    }

?>

            </div>





        </div>
           
            
        </div>

<!--    end dashboard-->

<?php
}
else
{
    header('location:login.php');
}

?>

<?php require_once ('layouts/footer.php'); ?>

 <script>
        
            $(document).ready(function(){
                
                                $(".event-reply").hide();

                $(".reply_det").click(function(){
    $(this).nextAll(".event-reply").slice(0, <?php echo $count ?>).slideToggle();
  });

    $(".event-post").hide();

                $(".comment_det").click(function(){
    $(this).nextAll(".event-post").slice(0, <?php echo $countreg ?>).slideToggle();
  });
                
                
                $('.reply_form').hide();
              
                                $(".add-com-btn").click(function(){
    $(this).nextAll(".reply_form").slice(0, 2).slideToggle();
  });

            });
        
        </script>
