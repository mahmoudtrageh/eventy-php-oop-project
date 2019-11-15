<?php 
session_start();


if (isset($_SESSION['usermail'])) { 
    
    
    $id = isset($_GET['id']) ? $_GET['id'] : '';


 include 'connection.php'; 
?>

<?php include "links.php" ?>

<?php include "header.php" ?>

<div class='card card1' style='width: 18rem;'>
    
    <?php
     
     
     
         if(isset($id) && ($_SESSION['id'] = $id)) {
             
             

    $stmtreg = $con->prepare("SELECT * FROM users WHERE id='$id'");
                $stmtreg ->execute();
                $rowreg = $stmtreg ->fetch();
                $countreg = $stmtreg ->rowCount();
    
                if ($countreg  > 0 ) {
            
            // register session with username

                    $_SESSION['pic'] = $rowreg['userpic'];
                    $_SESSION['usermail'] = $rowreg['usermail'];
                $_SESSION['user_desc'] = $rowreg['user_desc'];
                    $_SESSION['firstname'] = $rowreg['firstname'];
                    $_SESSION['lastname'] = $rowreg['lastname'];
         ?>
    
  <img class='card-img-top' src='<?php echo $_SESSION['pic'] ?>'>
  <div class='card-body'>
    <h5 class='card-title1'> <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']  ?> </h5>
      <p class='card-text'> <?php echo $_SESSION['user_desc'] ?></p>
      
      
      
      
      <?php
         
                             $id = $_GET['id'];
                        $ID = $_SESSION['ID'];

          $stmt = $con->prepare("SELECT followed, follower FROM followers WHERE followed = '$id' AND follower = '$ID'");
                $stmt ->execute();
                $row = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
            
                    $_SESSION['followed'] = $row['followed'];
                                        $_SESSION['follower'] = $row['follower'];

                         } 

         if(isset($row['followed']) && ($row['followed'] == $id) && ($row['follower'] == $_SESSION['ID'])){
      
      ?>
      <form action="delete_follow.php" method="POST">
      
            <button name="follow" type="submit" id="my_btn" class="btn btn-primary follow-event">
                Followed
                        <span><?php echo $count; ?> </span>
          </button>
            </form>
      
      
     
      <?php
       } else {
         ?>
      
      <form action="follow.php?id='<?php echo $id; ?>'" method="POST">
      
            <button name="follow" type="submit" id="my_btn1" class="btn btn-primary follow-event">
                Follow
                        <span><?php echo $count; ?> </span>
          </button>
            </form>
      
      
      
      
      <?php
        
        }
                         

      
      ?>
      
      <?php
                             }
             
             
                                                                                      
                                   

                                   
$stmt4 = $con->prepare("SELECT EventTitle, EventImg, id, status FROM events WHERE postby='$id'");
$stmt4->execute();
$events = $stmt4->fetchAll();
                                   ?>

            <section class="portfolio text-center" style="direction:rtl;">
                    <div class="container">
                        
                               <h2 class="reg-ev text-center">الإيفنتات التي نشرها</h2>

                    <div class="row mt-4">
                        
                        
                            <?php
             
             if($events){
    
    foreach ((array) $events as $event) {
                    echo "<div class='col-md-3'>";
        
         if($event['status'] == 'مجاني'){
                                echo"<span class='home-stat alert alert-success'>مجاني</span>";
                        } else if($event['status'] == 'مدفوع'){
                                echo"<span class='home-stat alert alert-success'>مدفوع</span>";
                        } else {
                                echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";
                        }
                    echo "<div class='port-img'>";
                    
                    echo "<a href='one-event-dashboard.php?id=" . $event['id'] . "'><img alt='an example' class='img-fluid' src='" .  $event['EventImg'] . "' /></a>";
                    echo "<div class='caption'>";
                    echo "<h3><a href='one-event-dashboard.php?id=" . $event['id'] . "'>" . $event['EventTitle'] . "</a></h3>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
        
          
    }
             } else {
        echo "<h2 class='alert alert-danger mt-5' style='margin: 0 auto 85px;'>لا يوجد إيفنتات منشورة له </h2>";
    }
    
?>
                                
                            

</div>
</div>
</section>
      
      <?php


    } else {
             
                              $usermail = $_SESSION['usermail'];

              $stmt2 = $con->prepare("SELECT * FROM users WHERE usermail = '$usermail'");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
            // register session with username

                    $_SESSION['userpic'] = $row2['userpic'];
                    $_SESSION['user_desc'] = $row2['user_desc'];
                    $_SESSION['firstname'] = $row2['firstname'];
                    $_SESSION['lastname'] = $row2['lastname'];


         ?>
      <img class='card-img-top' src='<?php echo $_SESSION['userpic'] ?>'>
  <div class='card-body'>
    <h5 class='card-title1'> <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']  ?> </h5>
            <p class='card-text'> <?php echo $_SESSION['user_desc'] ?></p>

      <?php
                                 }

       
     if($_SESSION['ID'] == '2') {
         
            echo " <a href='dashboard.php' class='btn btn-success'>لوحة التحكم الموقع</a>";
         
         echo " <a href='event-dashboard.php' class='btn btn-success'>لوحة تحكم البروفايل</a>";

     } else {
                     echo " <a href='event-dashboard.php' class='btn btn-success'>لوحة تحكم البروفايل</a>";

     }
             
             
             
             $stmtreg = $con->prepare("SELECT follower FROM followers WHERE followed = '$ID'");
                $stmtreg ->execute();
                $rowreg = $stmtreg ->fetch();
                $countreg = $stmtreg ->rowCount();
    
               
                                   
                                   ?>
        
                
                <a class="btn btn-primary " href='followers.php?id=<?php echo $ID; ?>'>المتابعين</a><span style="border:1px solid;padding:10px;"><?php echo $countreg; ?> </span>
                      
  </div>
</div>
</div>




 <?php

                
        $regby = $_SESSION['ID'];
    
    
  $stmtt2 = $con->prepare("SELECT * FROM events, users_registered WHERE events.id = users_registered.events_id AND users_registered.regby = '$regby' AND users_registered.events_status = events.status");
$stmtt2->execute();
$events = $stmtt2->fetchAll();
    
       

                                   ?>

            <section class="portfolio text-center" style="direction:rtl;">
                    <div class="container">
                        <h2 class="reg-ev text-center">الإيفنتات التي سجلت بها</h2>

                    <div class="row">
                        
                   <?php

        
                    if($events) {

    
    foreach ($events as $event) {
                    echo "<div class='col-md-3'>";
        
         if($event['status'] == 'مجاني'){
                                echo"<span class='home-stat alert alert-success'>مجاني</span>";
                        } else if($event['status'] == 'مدفوع'){
                                echo"<span class='home-stat alert alert-success'>مدفوع</span>";
                        } else {
                                echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";
                        }
                    echo "<div class='port-img'>";
                    
                    echo "<a href='user-event-dashboard.php?id=" . $event['events_id'] . "'><img alt='an example' class='img-fluid' src='" .  $event['EventImg'] . "' /></a>";
                    echo "<div class='caption'>";
                    echo "<h3><a href='user-event-dashboard.php?id=" . $event['events_id'] . "'>" . $event['EventTitle'] . "</a></h3>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
        
       
                }
        
        
    } else {
        echo "<h2 class='alert alert-danger mt-5' style='margin: 0 auto 85px;'>لا يوجد إيفنتات مسجل بها </h2>";
    }
    
    
        
?>

</div>
</div>
</section>




 <?php

                
        $postBy = $_SESSION['ID'];
                                                                      
                                   

                                   
$stmt4 = $con->prepare("SELECT EventTitle, EventImg, id, status FROM events WHERE postby='$postBy'");
$stmt4->execute();
$events = $stmt4->fetchAll();
                                   ?>

            <section class="portfolio text-center" style="direction:rtl;">
                    <div class="container">
                        
                               <h2 class="reg-ev text-center">الإيفنتات التي نشرتها</h2>

                    <div class="row">
                        
                        
                            <?php
             
             if($events){
    
    foreach ((array) $events as $event) {
                    echo "<div class='col-md-3'>";
        
         if($event['status'] == 'مجاني'){
                                echo"<span class='home-stat alert alert-success'>مجاني</span>";
                        } else if($event['status'] == 'مدفوع'){
                                echo"<span class='home-stat alert alert-success'>مدفوع</span>";
                        } else {
                                echo"<span class='home-stat alert alert-success'>ضروري الدفع</span>";
                        }
                    echo "<div class='port-img'>";
                    
                    echo "<a href='one-event-dashboard.php?id=" . $event['id'] . "'><img alt='an example' class='img-fluid' src='" .  $event['EventImg'] . "' /></a>";
                    echo "<div class='caption'>";
                    echo "<h3><a href='one-event-dashboard.php?id=" . $event['id'] . "'>" . $event['EventTitle'] . "</a></h3>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
        
          
    }
             } else {
        echo "<h2 class='alert alert-danger mt-5' style='margin: 0 auto 85px;'>لا يوجد إيفنتات منشورة لك </h2>";
    }
    
?>
                                
                            

</div>
</div>
</section>



<?php      }
?>


<?php include "footer.php" ?>


        
<?php    
    
    
} else {
        header('location:login.php');
}

?>