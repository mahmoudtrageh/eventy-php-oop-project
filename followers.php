<?php

session_start();

if (isset($_SESSION['usermail']))
{

    require_once ('modules/Database.php');

    require_once ('layouts/header.php');

    $db = new Database();

?>
    
   <div class="container text-center">

       <h2 class="event-det text-center">المتابعين</h2>
                                             
    <?php

    $ID = isset($_GET['id']) ? $_GET['id'] : '';

?>
  

<div class="row">
   
    
    <div class="col-md-12">
        
        <span class="mess-btn-all btn btn-success mt-4">راسل الجميع</span>

 <form action='send_message.php' class="mess-form-all" method='POST' enctype="multipart/form-data">
            <input name='mess_by' type='hidden' value='<?php echo $ID; ?>'>

            <textarea name='message' class='form-control' rows='5'></textarea>  
            <button type="submit" name='submit5' class="btn btn-success">راسل الجميع</button>

        </form>
        
        
        <?php
    $id = $_GET['id'];

    $db->query("SELECT * FROM followers WHERE followed='$ID'");
    $Followers = $db->resultSet();

?>
  

<table>
                <tr>
    <td>Id</td> 
    <td>الإسم</td> 

    </tr>
    
                    
        <?php
    foreach ((array)$Followers as $Follower)
    {

        echo "<tr>";
        echo "<td>" . $Follower->follow_id . "</td>";

        echo "<td>" . $Follower->follower_name . "</td>";

        echo "</tr>";

    }

?>

</table>
        
        
        
    </div>
       </div>
        
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
            
            $(".mess-form-all").hide();

                $(".mess-btn-all").click(function(){
    $(this).nextAll(".mess-form-all").slice(0, 1).slideToggle();
  }); 
        });
       
       </script>
