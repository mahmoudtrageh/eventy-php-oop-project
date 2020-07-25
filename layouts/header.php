<?php
ob_start();

if(!isset($page_title)) {$page_title = 'الرئيسية'; }

if (isset($_SESSION['usermail'])) { 
    
   require_once('modules/Database.php');
                 
   $db = new Database();
?>

<!DOCTYPE html>
<html>

<head>
    <title>كوبيديا - <?php echo $page_title; ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/css/index.css">

    
</head>

<body>

<div class="header-back">

    <header>
    

  <div class="container">
    <nav class="navbar navbar-expand-lg" role="navigation">
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
            &#9776;
        </button>
        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
            <ul class="nav navbar-nav my-nav">
                <li class="nav-item my-nav"><a href="./index.php" class="nav-link btn btn-success">الرئيسية</a></li>
                <li class="nav-item my-nav"><a href="./about-us.php" class="nav-link btn btn-success">عنا</a></li>
            </ul>
            <ul class="nav navbar-nav flex-row justify-content-between mr-auto">
                
                
                
    <?php
                                  
                                   
                $usermail = $_SESSION['usermail'];

                $db->query("SELECT id FROM users WHERE usermail = '$usermail'"); 
                $current_user = $db->single();            


                $db->query("SELECT * FROM notifications WHERE read_n = 1 AND noti_to = '$current_user->id' ORDER BY id DESC"); 
                $oldNotifi = $db->resultSet();            
                $countnoti = $db->rowCount();
                             
                $db->query("SELECT * FROM notifications WHERE read_n = 0 AND noti_to = '$current_user->id' ORDER BY id DESC LIMIT 3");
                $db->resultSet();           
                $notifications = $db->resultSet(); 
                               $countnoti = $db->rowCount();

                $db->query("SELECT * FROM messages WHERE read_n = 1 AND mess_to = '$current_user->id'  ORDER BY mess_id DESC"); 
                $oldMess = $db->resultSet();   
                
                $countOldMess = $db->rowCount();

                $db->query("SELECT * FROM messages WHERE read_n = 0 AND mess_to = '$current_user->id' ORDER BY mess_id DESC"); 
                $rowreg = $db->resultSet();     
                            
                $countMess = $db->rowCount();
                                       
            ?>
            
           <li class="nav-item dropdown my-noti">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            
            <?php 
             
                $followed = $_SESSION['usermail'];

                $db->query("SELECT * FROM users WHERE usermail='$followed'");
                
                $followedUsers = $db->resultSet(); 
                $count2 = $db->rowCount();

                if ($count2  > 0 ) {
                
                foreach((array) $followedUsers as $followedUser) {
            
                // register session with username
                      
                $_SESSION['firstname'] = $followedUser->firstname;
                $_SESSION['lastname'] = $followedUser->lastname;
                    
                }
                    
                }
                       
                $usermail = $_SESSION['usermail'];

                $db->query("SELECT id FROM users WHERE usermail='$usermail'");
                $user = $db->single();
                        
                                               
                $db->query("SELECT follower FROM follow_event WHERE follow_id='$user->id'");
                $followerEvents = $db->resultSet(); 
                $count2 = $db->rowCount();
 foreach((array) $followerEvents as $followerEvent ){
                                     
            if($user->id == $followerEvent->follower ) {

  
                if ($countnoti > 0 ) {
                   
                echo "<span class='badge badge-light'>$countnoti</span>";    
                    
                   
                    
                    ?>
            
                    </a>
               
               <?php
                    
                    $read_n= 1;
                    
                    if(isset($_GET['notf'])) {
                        $n_id = $_GET['notf'];
                        $db->query("UPDATE notifications SET read_n = :read_n WHERE id= :id");
                        $db->bind(':read_n', $read_n);
                        $db->bind(':id', $n_id);
                        $db->execute();
                        header("location:notifications.php");
                    }
                    
                    ?>
               
        <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
            
            <?php
                    
                    ?>
                                             
            <?php foreach($notifications as $notification) {  
                    echo"<a href='?notf=" . $notification->id . "' class='dropdown-item'>اقرأ  </a>
                                                                    <small><i>" . $notification->date . "</i></small><br>
                            <p class='noti-box'> " . $notification->message . "</p>
                       
                        <div class='dropdown-divider'></div>";
                        
                        }
                    
                        foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a class='dropdown-item'>
                <small><i>" . $notifi->date . "</i></small><br>
                <p> " . $notifi->message . "</p>
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
                <small><i>" . $notifi->date . "</i></small><br>
                <p> " . $notifi->message . "</p>
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
                <small><i>" . $notifi->date . "</i></small><br>
                <p> " . $notifi->message . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الاشعارات</a>  
                
               </div> 
               
               
            <?php
            }
        }

        ?>

         <div class='dropdown-menu my-menu' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد اشعارات جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldNotifi as $notifi) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                <small><i>" . $notifi->date . "</i></small><br>
                <p> " . $notifi->message . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الاشعارات</a>  
                
               </div> 
        
        
               
                           </li>
            
            
            
            <li class="nav-item dropdown my-noti2">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope"></i>   

            
            <?php 
                echo "<span class='badge badge-light'>$countMess</span>";    

            foreach((array) $rowreg as $rowr) {    
                
            
                if($current_user->id == $rowr->mess_to ) {


if ($countMess > 0 ) {
                    
                $db->query("SELECT mess_id FROM messages");
                $row1 = $db->resultSet();
                $count1 = $db->rowCount();
    
                                   
                    
                    ?>
            
                    </a>
               
               <?php
                    
                    $read_n= 1;
                    
                    if(isset($_GET['mess'])) {
                        $n_id = $_GET['mess'];
                        $db->query("UPDATE messages SET read_n = :read_n WHERE mess_id= :mess_id");
                        $db->bind(':read_n', $read_n);
                        $db->bind(':mess_id', $n_id);
                        $db->execute();
                        header("location:messages.php");
                    }
                    
                    ?>
               
        <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                                             
            <?php foreach($rowreg as $messa) {  
                    echo"<a href='?mess=" . $messa->mess_id ."' class='dropdown-item'>اقرأ  </a>
                            <small><i>" . $messa->date . "</i></small><br>
                            <p class='noti-box'> " . $messa->message . "</p>
                       
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
                                         <small><i>" . $notMess->date . "</i></small><br>

                <p> " . $notMess->message . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الرسائل</a>  
                
               </div> 
               
               
            <?php
            }

            // end if equal 
        }

        // end foreach 
                

                    // start if count mess 
                    
                 if($countOldMess > 0) { 
                
                echo "<span style='display:none;' class='badge badge-light'> </span>";
                                  ?> 
                
            <div class='dropdown-menu my-menu text-right' aria-labelledby='navbarDropdown'>
                
                <?php

                    echo "<p>لا يوجد رسائل جديدة</p>
                    <div class='dropdown-divider'></div>";
                    
                foreach($oldMess as $notMess) {  

                    echo "
                    
            
             <a style='cursor:pointer'; class='dropdown-item'>
                                         <small><i>" . $notMess->date . "</i></small><br>

                <p> " . $notMess->message . "</p>
            </a>
            
            <div class='dropdown-divider'></div>";

                    
   
                }
                    
                                   
            ?>
              
                 <a style="overflow-y: hidden;position: fixed;top: 429px;background-color: #fff;padding: 8px;width: 100%;
    border-top: 1px solid;text-decoration:none;" href="notifications.php">جميع الرسائل</a>  
                
               </div> 
               
            <?php
            }

            // end if count mess 

          
            ?>
               
                           </li>
            
            
            
            
         
         <?php
         
            $db->query("SELECT userpic FROM users where usermail = '$followed'");
            $userpic = $db->single();

         ?>
            
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="user-profile.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         
          <img src='<?php echo  $userpic->userpic; ?>'>
                
                </a>
                
                <?php
                
                $db->query("SELECT id FROM users");
                $row = $db->resultSet();
                $count1 = $db->rowCount();
    
                if ($count1 > 0 ) {
            
            // register session with username
        foreach((array) $row as $ro) {
                    $_SESSION['ID'] = $ro->id;

                    }
                }
                ?>
        <div class="dropdown-menu dropdown-second" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="user-profile.php"> <?php echo  $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></a>
          <a class="dropdown-item" href="members.php?do=Edit&id=<?php echo $_SESSION['ID'] ?>">تعديل الحساب</a>
          <a class="dropdown-item" href="./auth/logout.php">الخروج</a>
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
        header('location:./auth/login.php');
}

?>