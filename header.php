<?php
ob_start();

if (isset($_SESSION['usermail'])) { ?>



<?php include 'connection.php';
                                   
            include 'functions.php';
?>

<div class="header-back">

    <header>
    

  <div class="container">
    <nav class="navbar navbar-expand-lg" role="navigation">
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
            &#9776;
        </button>
        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
            <ul class="nav navbar-nav my-nav">
                <li class="nav-item my-nav"><a href="index.php" class="nav-link btn btn-success">الرئيسية</a></li>
                <li class="nav-item my-nav"><a href="about-us.php" class="nav-link btn btn-success">عنا</a></li>
            </ul>
            <ul class="nav navbar-nav flex-row justify-content-between mr-auto">
                
                
                
    <?php
                                  
                                   
                                   
                                   $ID = $_SESSION['ID'];
                                   
            $stmt3 = $con->prepare("SELECT * FROM notifications WHERE read_n = 0 AND noti_to = '$ID' ORDER BY id DESC");
                $stmt3->execute();
                $notifications = $stmt3->fetchAll();
                $countnoti = $stmt3->rowCount();
                                   
                $stmt2 = $con->prepare("SELECT * FROM notifications WHERE read_n = 1 ORDER BY id DESC LIMIT 3");
                $stmt2->execute();
                $oldNotifi = $stmt2->fetchAll();
                                   
                                   
                $stmt8 = $con->prepare("SELECT * FROM messages WHERE read_n = 0 AND mess_to = '$ID'  ORDER BY mess_id DESC");
                $stmt8->execute();
                $messages = $stmt8->fetchAll();
                                   
                                   
                                   
                $stmtreg = $con->prepare("SELECT * FROM messages WHERE read_n = 0 AND mess_to = '$ID' ORDER BY mess_id DESC");
                $stmtreg ->execute();
                $rowreg = $stmtreg ->fetch();
                $countMess = $stmtreg ->rowCount();
    
                if($countMess > 0) {
                               $_SESSION['mess_to'] = $rowreg['mess_to'];
                    


                                   }
                                   
                                                                           $mess_to =  $rowreg['mess_to'];

                                  
                                   
                $stmt9 = $con->prepare("SELECT * FROM messages WHERE read_n = 1 ORDER BY mess_id DESC LIMIT 3");
                $stmt9->execute();
                $oldMess = $stmt9->fetchAll();
                                   
            ?>
            
           <li class="nav-item dropdown my-noti">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            
           
            <?php 
                                   
                $followed = $_SESSION['ID'];
                                   
                $stmt2 = $con->prepare("SELECT * FROM users WHERE id='$followed'");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
            // register session with username
                    
                   
                    
                   $_SESSION['firstname'] = $row2['firstname'];
                                      $_SESSION['lastname'] = $row2['lastname'];

                    
                                    }
                                   
$followed_name = $_SESSION['firstname'];
                                   
                                   $stmt = $con->prepare("SELECT follower FROM followers WHERE follower_name='$followed_name'");
                $stmt ->execute();
                $row = $stmt ->fetch();
                $count = $stmt ->rowCount();
    
                if ($count  > 0 ) {
            
                    $_SESSION['follower'] = $row['follower'];

                         } 
                                   
                $stmt2 = $con->prepare("SELECT follower FROM follow_event WHERE follower_name='$followed_name'");
                $stmt2 ->execute();
                $row2 = $stmt2 ->fetch();
                $count2 = $stmt2 ->rowCount();
    
                if ($count2  > 0 ) {
            
                    $_SESSION['follower'] = $row2['follower'];

                         } 
                         
            if($_SESSION['ID'] == $row2['follower'] ) {

  
                if ($countnoti > 0 ) {
                   
                echo "<span class='badge badge-light'>$countnoti</span>";    
                    
                   
                    
                    ?>
            
                    </a>
               
               <?php
                    
                    $read_n= 1;
                    
                    if(isset($_GET['notf'])) {
                        $n_id = $_GET['notf'];
                        $stmt6 = $con->prepare("UPDATE notifications SET read_n = ? WHERE id= ?");
                        $stmt6->execute(array($read_n, $n_id));
                        header("location:notifications.php");
                    }
                    
                    ?>
               
        <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
            
            <?php
                    
                    ?>
                                             
            <?php foreach($notifications as $notification) {  
                    echo"<a href='?notf=" . $notification['id'] . "' class='dropdown-item'>اقرأ  </a>
                                                                    <small><i>" . $notification['date'] . "</i></small><br>
                            <p class='noti-box'> " . $notification['message'] . "</p>
                       
                        <div class='dropdown-divider'></div>";
                        
                        }
                    
                        foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $notifi['date'] . "</i></small><br>
                <p> " . $notifi['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                      
                    
                    
                    ?>
            
                <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الاشعارات</a>  

        </div>
               

               
               <?php
                    
                    
                } else { 
                
                echo "<span style='display:none;' class='badge badge-light'> </span>";
                                  ?> 
                
            <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد اشعارات جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                <small><i>" . $notifi['date'] . "</i></small><br>
                <p> " . $notifi['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الاشعارات</a>  
                
               </div> 
               
            <?php
            }
            } else {
         
          
            ?>
               
        <div class='dropdown-menu my-menu' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد اشعارات جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                <small><i>" . $notifi['date'] . "</i></small><br>
                <p> " . $notifi['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الاشعارات</a>  
                
               </div> 
               
               
            <?php
            }
            ?>
               
                           </li>
            
            
            
            <li class="nav-item dropdown my-noti2">
                   

                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope"></i>   
            
            <?php 
                                
  
     if($_SESSION['ID'] == $mess_to ) {

                
                if ($countMess > 0 ) {

                    $stmt1 = $con->prepare("SELECT mess_id FROM messages");
                $stmt1 ->execute();
                $row1 = $stmt1 ->fetch();
                $count1 = $stmt1 ->rowCount();
    
                if ($count1  > 0 ) {
            
            // register session with username
        
                    $_SESSION['mess_id'] = $row1['mess_id'];

                    }
                
        $mess_id = $_SESSION['mess_id'];     
                   
                echo "<span class='badge badge-light'>$countMess</span>";    
                    
                    ?>
            
                    </a>
               
               <?php
                    
                    $read_n= 1;
                    
                    if(isset($_GET['mess'])) {
                        $n_id = $_GET['mess'];
                        $stmt6 = $con->prepare("UPDATE messages SET read_n = ? WHERE mess_id= ?");
                        $stmt6->execute(array($read_n, $n_id));
                        header("location:messages.php");
                    }
                    
                    ?>
               
        <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                                             
            <?php foreach($messages as $messa) {  
                    echo"<a href='?mess=" . $messa['mess_id'] ."' class='dropdown-item'>اقرأ  </a>
                            <small><i>" . $messa['date'] . "</i></small><br>
                            <p class='noti-box'> " . $messa['message'] . "</p>
                       
                        <div class='dropdown-divider'></div>";
                        
                        }
                    
                        foreach($oldMess as $mess) {  

                    echo "
                    
            
             <a class='dropdown-item'>
                                         <small><i>" . $mess['date'] . "</i></small><br>

                <p> " . $mess['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                        
                    
                    ?>
            
                <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الرسائل</a>  

        </div>
               

               
               <?php
                    
                } else { 
                
                echo "<span style='display:none;' class='badge badge-light'> </span>";
                                  ?> 
                
            <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد رسائل جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldMess as $notMess) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                                         <small><i>" . $notMess['date'] . "</i></small><br>

                <p> " . $notMess['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الرسائل</a>  
                
               </div> 
               
            <?php
            }
            } else {
         
          
            ?>
               
        <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد رسائل جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldMess as $notMess) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                                         <small><i>" . $notMess['date'] . "</i></small><br>

                <p> " . $notMess['message'] . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الرسائل</a>  
                
               </div> 
               
               
            <?php
            }
            ?>
               
                           </li>
            
            
            
            
                
            
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="user-profile.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src='<?php echo  $_SESSION['Userpic']; ?>'>
                
                </a>
                
                <?php
                
                $stmt2 = $con->prepare("SELECT id FROM users");
                $stmt2->execute();
                $row = $stmt2->fetch();
                $count1 = $stmt2->rowCount();
    
                if ($count1 > 0 ) {
            
            // register session with username
        
                    $_SESSION['id'] = $row['id'];

                    }
                
                ?>
        <div class="dropdown-menu dropdown-second" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="user-profile.php"> <?php echo  $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></a>
          <a class="dropdown-item" href="members.php?do=Edit&id=<?php echo $_SESSION['ID'] ?>">تعديل الحساب</a>
          <a class="dropdown-item" href="logout.php">الخروج</a>
        </div>
      </li>
                
                <li class="dropdown order-1">
    <a href="add-event.php"><button class="btn btn-success add-event">أضف فعاليتك الآن</button></a>
                   
                </li>
                
            </ul>
            

    
        </div>
</nav>
      
       <div class="logo">
        <img src="./assets/images/logo.png">
        </div>
      
  </div>
        
        </header>
</div>
    
<?php

} else {
        header('location:login.php');
}

?>