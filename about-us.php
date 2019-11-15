<?php 
// start session
session_start();
// connection to database
include 'connection.php'; 
// import links which have the linked css and other files 
include "links.php";
?>
<!-- the header tag -->
<div class="header-background">

<?php
/* if users signed in */
if (isset($_SESSION['usermail'])) {
    // the header of signed in user
         include "header.php";
                } else {
    // the header of user not signed in
         include "header2.php";
    }
?>
<!--  suppose end of the header tag here  -->
<!-- about us section -->
<div class="container">
    <section id="about" class="about-info text-center">
        <h3>من نحن</h3>
        <p>موقع متخصص في تنظيم الإيفنتات في جمهورية مصر العربية وإتاحة سهولة الوصول إليها ... وقريبًا سيوفر دعم كامل لأصحاب الإيفنتات بتوفير العديد من الخدمات المميزة</p>
    </section>
<!--  end  -->
<?php include'footer.php'; ?>
 