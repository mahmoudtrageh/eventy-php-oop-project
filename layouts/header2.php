<?php
            if(!isset($page_title)) {$page_title = 'الرئيسية'; }

            
?>

<!DOCTYPE html>
<html>

<head>
<title>كوبيديا - <?php echo $page_title; ?></title>

    <meta charset="utf-8" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/fontawesome-all.css">
    <link rel="stylesheet" href="./assets/css/index.css">

    
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
                <li class="nav-item"><a href="./index.php" class="nav-link btn btn-success">الرئيسية</a></li>
                <li class="nav-item"><a href="./about-us.php" class="nav-link btn btn-success">عنا</a></li>
            </ul>
            <ul class="nav navbar-nav flex-row justify-content-between mr-auto">
                <li class="dropdown order-1">
                    <a href="./auth/login.php"><button type="button" class="btn btn-success dropdown-toggle">الدخول </button></a>
                   
                </li>
                
                      <li class="dropdown order-1">
                          <a href="./auth/register.php"><button type="button" class="btn btn-success dropdown-toggle">التسجيل </button></a>
                   
                </li>
                
                 <li class="dropdown order-1">
    <a href="./add-event.php"><button class="btn btn-success add-event">أضف فعاليتك الآن</button></a>
                   
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