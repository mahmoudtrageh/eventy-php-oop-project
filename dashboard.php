<?php 
    // start session
    session_start();
    // connection to data base
require_once('modules/Database.php');
        require_once('functions.php');
    $db = new Database(); 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
    require_once ('layouts/header.php');
?>  
<!-- start dashboard -->
<div class="container home-stats text-center">
    <h1 class="event-det text-center">لوحة التحكم الرئيسية</h1>
    <div class="row">
<!-- first quarter -->
        <div class="col-md-4">
            <div class="stat st-members">
                جميع الأعضاء 
                <span><a href="members.php"><?php echo count(countItem3('id', 'users'))?></a></span>
            </div>
        </div>
<!-- second quarter -->
        <div class="col-md-4">
            <div class="stat st-members">
                جميع الإيفنتات
                <span><?php echo count(countItem('id', 'events', 'مجاني')) + count(countItem('id', 'events', 'مدفوع')) + count(countItem('id', 'events', 'الدفع ضروري')) ?></span>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat st-members">
                            مجاني
                            <span><a href="events.php?status=مجاني"><?php echo count(countItem('id', 'events', 'مجاني')) ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat st-members">
                            مدفوع
                            <span><a href="events.php?status=مدفوع"><?php echo count(countItem('id', 'events', 'مدفوع')) ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat st-members">
                            الدفع ضروري
                            <span><a href="events.php?status=الدفع ضروري"><?php echo count(countItem('id', 'events', 'الدفع ضروري')) ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- third quarter -->
        <div class="col-md-4">
            <div class="stat st-members">
                الأعضاء المسجلين
                <span><a href="regMembers.php"><?php echo count(countItem3('regId', 'users_registered')) ?></a></span>
            </div>
        </div>
    </div>
</div>  
<!-- end dashboard-->
<?php
// end check logged in        
    } else {
        header('location:login.php');
    }
    require_once ('layouts/footer.php'); ?>