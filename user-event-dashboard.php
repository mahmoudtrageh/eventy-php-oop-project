<?php 

session_start();


if (isset($_SESSION['usermail'])) { ?>


<?php include 'connection.php'; 
                                   

    include "links.php";

    include "header.php";
                                                                                                         
                                
            $id = $_GET['id'];
                                                                                              

                                   ?>


    <div class="container home-stats text-center">

                    <?php 
                           
$ID = isset($_SESSION['ID']) ? $_SESSION['ID'] : '';
                                   
                           
                             $stmt = $con->prepare("SELECT reg_code FROM users_registered WHERE regby='$ID' AND events_id='$id'");
                $stmt ->execute();
                $row = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
                    
                    $_SESSION['reg_code'] = $row['reg_code'];


                    }
                                   
                                    $stmt2 = $con->prepare("SELECT EventTitle FROM events WHERE id='$id'");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count  > 0 ) {
                    
                    $_SESSION['EventTitle'] = $row2['EventTitle'];


                    }
                                   
                                   ?>

            
        
        <div class="row">

            <div class="col-md-3">
                
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-5 print-tick" data-toggle="modal" data-target="#exampleModal">
قم بطباعة التذكرة الآن</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="end" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <img class="tick-logo" src="assets/images/logo.png"><br>
          <span>اسم الايفنت</span><p><b><?php echo $_SESSION['EventTitle']; ?></b></p>
          <span>رقم التذكرة</span><p><b><?php echo $_SESSION['reg_code']; ?></b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pri" data-dismiss="modal" onclick="myFunction()">اطبع التذكرة</button>

      </div>
    </div>
  </div>
</div>
        
        <script>
function myFunction() {
    window.print();
} 
</script>
        
        <style>

    @media print {
   .home-stats h1, .print-tick {display:none}
   .stat {display:none}
    .posts {display:none}
   .latest {display:none}
   footer {display:none}
           header {display:none}
   .end, .pri {display:none}

    }

</style>


                   <div class="stat st-members" style="direction:rtl;">
                            يحدث بتاريخ <br>
                            
                            <?php
                                   
                               $stmtreg = $con->prepare("SELECT date, finish_date, EventTitle FROM events WHERE id='$id'");
                $stmtreg ->execute();
                $rowreg = $stmtreg ->fetch();
                $countreg = $stmtreg ->rowCount();
    
                if ($countreg  > 0 ) {
            
            // register session with username
        
                    $_SESSION['date'] = $rowreg['date'];
                                        $_SESSION['finish_date'] = $rowreg['finish_date'];
                                        $_SESSION['EventTitle'] = $rowreg['EventTitle'];


                    }
                
        $event_date = $_SESSION['date'];    
        $finish_date = $_SESSION['finish_date'];    
                                   
                                   
                                                               echo $event_date; echo '<br>';
                                   
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
                                   
                                   
                                   if(($event_start - $my_current) == 0){
                                       
                                       echo"
                                       <h2>يحدث اليوم </h2>
                                       ";
                                       
                                        echo " <p>ويستمر لمدة ... </p>";
?>
                                       
                                             <span> <?php echo ($event_finish - $event_start); ?> أيام</span><br>
                                       
                                  
                                       
                                       <?php
                                       
                                   } else if(($event_finish - $my_current ) < 0) {
                                       
                                       echo 'انتهي' . '<br>' . 'ترقب موعد الايفنت القادم بضغط متابعة';
                                       
                                   }  else if (($event_start - $my_current) > 0) {
                                  
                                       echo " <p>متبقي على بداية الإيفنت </p>";
                                       ?>
                            
                            <span> <?php echo ($event_start- $my_current); ?> يوم</span><br>                       
                       <?php
                                       
                                         echo " <p> مدة الإيفنت</p>";
                                       ?>
                            
                            <span> <?php echo ($event_finish - $event_start); ?> يوم</span><br>                       
                       <?php
                                       
                                       echo " <p>متبقي على نهاية الإيفنت </p>";
                                       ?>
                            
                            <span> <?php echo ($event_finish - $my_current); ?> يوم</span><br>                       
                       <?php


                                   } else if (($event_start - $my_current) < 0) {
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




                        <div class="stat st-registered">
                            Total Registers
                            <span><?php echo countItem2('regId',  $id) ?></span>

                        </div>


            </div>
            
                

            <div class="col-md-9 posts">
                
                <h3 class="event-det text-center mt-5"><?php echo $_SESSION['EventTitle']; ?></h3>

                <p class="alert alert-success mt-5">قم بنشر بوست الآن</p>


                <form id='comment_form' enctype='multipart/form-data' action="add_comment.php?id=<?php echo $id; ?>" method='POST'>
                    <input name='comment_date' type='hidden' value='<?php echo date(' Y-m-d H:i:s '); ?>'>
                    <textarea name='comment_content' id='comment_content' placeholder='أكتب تعليقك هنا' class='form-control' rows='5'></textarea>
                    <button class='btn btn-outline-secondary mt-2' name='action' type='submit'>نشر</button>

                </form>

                <?php

             
                    $query = $con->prepare(" SELECT * FROM comments WHERE comment_event='$id' ORDER BY comment_id DESC");
                    $query->execute();
                    $comments = $query->fetchAll();
                    $countreg = $query ->rowCount();
                                   
                                   ?>
                
                <h1 class="comment_det"> (<?php echo $countreg; ?>)عدد التعليقات </h1>
                <?php
                                   
                                   
        foreach($comments as $comment) {
            
           
                                
                    echo "<div class='event-post'>";
            
            $IDD = $comment['user_id'];
            
            $query = $con->prepare(" SELECT firstname, lastname FROM users WHERE id='$IDD'");
                    $query->execute();
                    $users = $query->fetchAll();
            
            foreach($users as $user) {
                    echo "<a href='user-profile.php?id=". $comment['user_id'] ."'><p>" . $user['firstname'] . ' ' . $user['lastname'] . "</p></a>";

            }
                        echo "<p>" . $comment['date'] . "</p>";
                        echo nl2br ( "<p>" . $comment['comment'] . "</p>");
            
                          echo'  <h3 class="add-com-btn">أضف رد</h3>';

            
            echo ' <form class="reply_form" enctype="multipart/form-data" action="add_reply.php?id=' .$id .'" method="POST">
         
                             <input name="comment_id" type="hidden" value="'. $comment['comment_id'] .'">
                    <input name="reply_date" type="hidden" value="' . date(" Y-m-d H:i:s ") . '">
                    <textarea name="reply_content" placeholder="أكتب ردك هنا" class="form-control" rows="2"></textarea>
                    <button class="btn btn-outline-secondary mt-2 reply" name="action" type="submit">تعليق</button>

        </form>
    ';
            
            
             $comment_id=$comment['comment_id'];
            
             $query = $con->prepare(" SELECT * FROM replies WHERE reply_event='$id' AND comment_id='$comment_id'");
                    $query->execute();
                    $replies = $query->fetchAll();
                                $count = $query ->rowCount();
            
             ?>
                <h3 class="reply_det"> (<?php echo $count; ?>)عدد الردود </h3>
                <?php
            
             $query = $con->prepare(" SELECT * FROM replies ORDER BY date DESC");
                    $query->execute();
                    $replies = $query->fetchAll();
                                $count = $query ->rowCount();
            
                                            
            foreach($replies as $reply) {                                    
                
                if($comment['comment_id'] == $reply['comment_id']){
                     echo "<div class='event-reply'>";
                    
                    $IDD = $reply['user_id'];
            
            $query = $con->prepare(" SELECT firstname, lastname FROM users WHERE id='$IDD'");
                    $query->execute();
                    $users = $query->fetchAll();
            
            foreach($users as $user) {
                    echo "<a href='user-profile.php?id=". $reply['user_id'] ."'><p>" . $user['firstname'] . ' ' . $user['lastname'] . "</p></a>";

            }
                    
                        echo "<p>" . $reply['date'] . "</p>";
                        echo nl2br ( "<p>" . $reply['reply'] . "</p>");
                    
                    if($reply['user_id'] == $_SESSION['ID'] ) {
                    echo "
                    
                    <form action='edit_reply.php?id=$id' method='POST' class='edit-reply'>
                    <input name='comment_id' type='hidden' value=' ". $reply['comment_id'] ." '>
                    <input name='reply_date' type='hidden' value=' ". $reply['date'] ." '>
                                        <input name='reply_id' type='hidden' value=' ". $reply['reply_id'] ." '>
                                                            <input name='type' type='hidden' value='user'>

                    <input name='user_id' type='hidden' value=' ". $reply['user_id'] ." '>
                    <textarea style='display:none;' name='reply_content' class='form-control' rows='5'>" . $reply['reply'] ."</textarea>
                    <button class='btn btn-outline-secondary'>Edit</button>
                    </form>
                    
                    <form action='delete_reply.php?id=$id' method='POST' class='delete-reply'>
                    <input name='reply_id' type='hidden' value=' ". $reply['reply_id'] ." '>
                    <input name='comment_id' type='hidden' value=' ". $reply['comment_id'] ." '>
                    <button class='btn btn-outline-secondary'>Delete</button>
                    </form>
                    ";
                        
                
            }
//                
             echo "</div>";
                    
                    
                }
                
                
                
                
                            
            }
            
                   
            
            if($comment['user_id'] == $_SESSION['ID'] ) {
                    echo "
                    
                    <form action='edit_comment.php?id=$id' method='POST' class='edit-form'>
                    <input name='comment_id' type='hidden' value=' ". $comment['comment_id'] ." '>
                    <input name='comment_content' type='hidden' value=' ". $comment['date'] ." '>
                    <input name='user_id' type='hidden' value=' ". $comment['user_id'] ." '>
                    <input name='type' type='hidden' value='user'>
                    <textarea style='display:none;' name='comment_content' class='form-control' rows='5'>" . $comment['comment'] ."</textarea>
                    <button class='btn btn-outline-secondary'>Edit</button>
                    </form>
                    
                    <form action='delete_comment.php?id=$id' method='POST' class='delete-form'>
                    <input name='comment_id' type='hidden' value=' ". $comment['comment_id'] ." '>
                    <button class='btn btn-outline-secondary'>Delete</button>
                    </form>
                    ";
                
            }
           
             
            
            echo "</div>";
   
           
        }
                                   
                                   
                                               

       ?>

            </div>





        </div>


       
        <!--    end dashboard-->




        <?php
    
} else {
        header('location:login.php');
}

?>

            <?php include 'footer.php' ?>
        
        
        

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
