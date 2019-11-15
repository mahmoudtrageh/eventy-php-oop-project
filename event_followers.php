<?php 
    // start session
    session_start();
    // connection to data base
    include 'connection.php'; 
    // when the user signed in
    if (isset($_SESSION['usermail'])) { 
    // add links page     
    include "links.php";
    // add header section    
    include "header.php";
    // check if we get id by link or not    
    $ID = isset($_GET['id']) ? $_GET['id'] : '';
    // get all data from follow event table                                 
    $stmtpaid = $con->prepare("SELECT * FROM follow_event WHERE followed_event='$ID'");
    $stmtpaid->execute();
    $eventFollowers = $stmtpaid->fetchAll();
?>
<!-- start event followers -->
<div class="container text-center">
    <h2 class="event-det text-center">المتابعين</h2>
<!-- start send to all form -->
    <form action='send_message.php' method='POST' enctype="multipart/form-data">
        <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
        <input name='events_id' type='hidden' value='<?php echo $ID ?>'>
        <textarea name='message' class='form-control' rows='5'></textarea>  
        <button type="submit" name ='submit3' class="btn btn-primary">راسل الجميع</button>
    </form>
    <table>
        <tr>
            <td>Id</td> 
            <td>الإسم</td> 
            <td>مراسلة</td>
        </tr>
<?php
    foreach ((array) $eventFollowers as $eventFollower) {
        echo "<tr>
                <td>" . $eventFollower['follow_id'] . "</td>
                <td>" . $eventFollower['follower_name'] . "</td>
                <td>"; 
?>
<!-- start send to each user form -->
    <form action='send_message.php?id=<?php echo $eventFollower['followed_event'] ?>' method='POST' enctype="multipart/form-data">
        <input name='mess_by' type='hidden' value='<?php echo $_SESSION['ID']; ?>'>
        <input name='mess_to' type='hidden' value='<?php echo $eventFollower['follower'] ?>'>
        <textarea name='message' class='form-control' rows='5'></textarea>  
        <button type="submit" name ='submit' class="btn btn-primary">أرسل</button>
    </form>
<?php       
                echo "</td>";
        echo "</tr>";
    }
?>
    </table>
<!-- end check logged in -->
<?php                               
    } else {
            header('location:login.php');
    }
    include 'footer.php';
?>