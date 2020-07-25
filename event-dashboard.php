<?php
// start session
session_start();
// connection to data base
require_once ('modules/Database.php');

$db = new Database();
// when the user signed in
if (isset($_SESSION['usermail']))
{

    // add header section
    require_once ('layouts/header.php');
    // check if we have page
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    // if we have manage page
    if ($do == 'Manage')
    { ?>
<!-- start section -->
    <div class="container">
           <div class="home-stats text-center">
            <!-- if we have reach there by submit -->
            <?php
        if (isset($_POST['submit']))
        {
            echo "<p class='alert alert-success mt-4'>لقد تم تسجيل الإيفنت بنجاح</p>";
        }
        // get id of user stored in session
        $postBy = $_SESSION['ID'];
        $db->query("SELECT * FROM events WHERE postby='$postBy'");
        $events = $db->resultSet();
        $count3 = $db->rowCount();
?>
                <h1 class="reg-ev">سجلت (<?php echo $count3; ?>) إيفنت</h1>
                <table>
                    <tr>
                        <td>Id</td>
                        <td>Title</td> 
                        <td>Img</td> 
                        <td>Town</td>         
                        <td>Status</td> 
                        <td>By</td> 
                        <td>setting</td>
                    </tr>
             <?php
        foreach ((array)$events as $event)
        {
            echo "<tr>
                            <td>" . $event->id . "</td>
                            <td><a href='one-event-dashboard.php?id=" . $event->id . "'>" . $event->EventTitle . "</td>
                            <td><img class='dash-img' src='" . $event->EventImg . "'></img></td>
                            <td>" . $event->town . "</td>
                            <td>" . $event->status . "</td>
                            <td>" . $event->postby . "</td>
                            <td><a class='btn btn-success' href='event-dashboard.php?do=EditEvent&id=" . $event->id . "'>Edit</a> |
                        <a class='btn btn-danger confirm' href='event-dashboard.php?do=DeleteEvent&id=" . $event->id . "'>Delete</a>
                            </td>
                        </tr>";
        }
?>
               </table>
               
            <?php
        // if we have Edit Page
        
    }
    else if ($do == 'EditEvent')
    {
        // check if we get id by edit link
        $EventId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        // get data from events where id = ...
        $db->query("SELECT * FROM events WHERE id = :id");
        $db->bind(':id', $EventId);
        $row = $db->single();
        $count = $db->rowCount();

        // if there is id
        if ($count > 0)
        { ?>
        <!-- Edit Form -->
        <form style="direction:rtl;" class="text-right" enctype="multipart/form-data" action="?do=UpdateEvent" method="POST">
            <div class="container">
                <h1 class="text-center reg-ev">تعديل الإيفنت</h1>
                <div class="row">
                    <!-- first half -->
                    <div class="col-md-6">
                        
                        <input type="hidden" name="id" value="<?php echo $EventId ?>" />
                        
                        <input class="form-control mt-4 mb-4" type="text" name="EventTitle" placeholder="عنوان الإيفنت" value="<?php echo $row->EventTitle ?>">
                        
                        <select id="my-select" name="category" class="mb-4">
                            <option selected value="<?php echo $row->category ?>"><?php echo $row->category ?></option>
                            <option  value="علمي">علمي</option>
                            <option value="ثقافة وأدب">ثقافة وأدب</option>
                            <option value="تقني">تقني</option>
                            <option value="ديني إسلامي">ديني إسلامي</option>
                            <option value="تنمية ذاتية">تنمية ذاتية</option>
                            <option value="توظيف">توظيف</option>
                        </select>
                        
                        <label>صورة الإيفنت</label>
                        <input class="form-control mb-4" type="file" name="EventImg" value="<?php echo $row->EventImg ?>" >
                        
                        <select name="status" class="mb-4">
                            <option selected class="free" value="<?php echo $row->status ?>"><?php echo $row->status ?></option>
                            <option value="مدفوع"> مدفوع</option>
                            <option value="الدفع ضروري">الدفع ضروري</option>
                            <option value="مجاني">مجاني </option>
                        </select>

                        <ul class=" nav nav-tabs text-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
                                aria-selected="true"> مجاني</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
                                aria-selected="false">مدفوع</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="requirePaid-tab" data-toggle="tab" href="#requirePaid" role="tab" aria-controls="requirePaid"
                                aria-selected="false">الدفع ضروري</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="free" role="tabpanel" aria-labelledby="free-tab">
                                <p class="mt-3">التذكرة مجانية</p>
                            </div>
                            <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                                <input name="ticket_price" class="form-control mb-4 mt-4" id="ticket_price" type="number" onblur="this.placeholder='سعر التذكرة ( ج.م )'" placeholder="سعر التذكرة ( ج.م )" onfocus="this.placeholder=''" value="<?php echo $row->ticket_price ?>">
                            </div>
                            <div class="tab-pane fade" id="requirePaid" role="tabpanel" aria-labelledby="requirePaid-tab">
                                <input name="ticket_price" class="form-control mb-4 mt-4" type="number" onblur="this.placeholder='سعر التذكرة ( ج.م )'" placeholder="سعر التذكرة ( ج.م )" onfocus="this.placeholder=''" value="<?php echo $row->ticket_price ?>">
                                <input name="voda_num" class="form-control mb-4" type="tel" onblur="this.placeholder='رقم تحويل فودافون كاش'" placeholder="رقم تحويل فودافون كاش" onfocus="this.placeholder=''" value="<?php echo $row->voda_num ?>">
                            </div>
                        </div>

                        <label>وصف الإيفنت</label>
                        <textarea name='event_desc' class='form-control mb-4' rows='5'><?php echo $row->event_desc ?></textarea>  

                        <label>وصف المنظم</label>
                        <textarea name='org_desc' class='form-control mb-4' rows='5'><?php echo $row->org_desc ?></textarea>  

                        <label>تاريخ البدء</label>
                        <input name="date" class="form-control mb-4" type="date" value="<?php echo $row->date ?>"><br>

                        <label>زمن البدء</label>
                        <input name="time" class="form-control mb-4" type="time" value="<?php echo $row->time ?>"><br>

                        <label>تاريخ الانتهاء</label>
                        <input name="finish_date" class="form-control mb-4" type="date" value="<?php echo $row->finish_date ?>">
                    </div>
                    <!-- second half -->
                    <div class="col-md-6">
                        
                        <select name="town" class="mb-4">
                            <option selected class="free" value="<?php echo $row->town ?>"><?php echo $row->town ?></option>
                            <option  value="القاهرة">القاهرة</option>
                            <option value="طنطا">طنطا</option>
                            <option value="أسوان">أسوان</option>
                            <option value="الأسكندرية">الأسكندرية</option>
                            <option value="الإسماعيلية">الإسماعيلية</option>
                        </select>          

                        <label>زمن الإنتهاء</label>
                        <input name="finish_time" class="form-control mb-4" type="time" value="<?php echo $row->finish_time ?>"><br>

                        <label>عدد الأعضاء المطلوب</label>
                        <input name="member_number" class="form-control mb-4" type="number" value="<?php echo $row->member_number ?>"><br>

                        <label>العنوان بالتفصيل</label>
                        <input name="address" class="form-control mb-4" placeholder="المحافظة، المدينة، علامة مميزة" value="<?php echo $row->address ?>"><br>

                        <label>خريطة الموقع</label>
                        <input name="map_link" class="form-control mb-4" placeholder="قم بلصق رابط خريطة جوجل إن وُجد" value="<?php echo $row->map_link ?>"><br>

                        <label>رابط الفيس بوك</label>
                        <input name="fb_link" class="form-control mb-4" placeholder="قم بلصق رابط صفحة الفيس بوك إن وُجد" value="<?php echo $row->fb_link ?>"><br>

                        <label>رابط تويتر</label>
                        <input name="tw_link" class="form-control mb-4" placeholder="قم بلصق رابط تويتر إن وُجد" value="<?php echo $row->tw_link ?>">
                        
                        <button name="action" class="btn btn-primary" value="save" type="submit">save</button>

                    </div>
                </div>
            </div>
      </form>
    <!-- if there is not id -->
    <?php
        }
        else
        {
            echo "ther is no id";
        }
        // if there is Update Page
        
    }
    else if ($do == 'UpdateEvent')
    {
        echo "<div class='container'>
             <h1 class='text-center event-det'>تعديل الإيفنت</h1>
             </div>";
        // if reach page by submit action
        if (isset($_POST['action']))
        {

            // set the date zone
            date_default_timezone_set('Africa/Cairo');
            // get data by edit form
            $EventTitle = $_POST['EventTitle'];
            $EventId = $_POST['id'];
            $status = $_POST['status'];
            $town = $_POST['town'];
            $category = $_POST['category'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $finish_date = $_POST['finish_date'];
            $finish_time = $_POST['finish_time'];
            $members = $_POST['member_number'];
            $address = $_POST['address'];
            $map_link = $_POST['map_link'];
            $fb_link = $_POST['fb_link'];
            $tw_link = $_POST['tw_link'];
            $event_desc = $_POST['event_desc'];
            $org_desc = $_POST['org_desc'];
            $ticket_price = $_POST['ticket_price'];
            $voda_num = $_POST['voda_num'];

            // get data of image
            $filename = $_FILES['EventImg']['name'];
            $filetype = $_FILES['EventImg']['type'];
            $filesize = $_FILES['EventImg']['size'] / 1024;
            $filetmp = $_FILES['EventImg']['tmp_name'];

            $r = rand();
            $d = date("h.i.sa");
            $validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];

            if (in_array($filetype, $validTypes))
            {
                move_uploaded_file($filetmp, './assets/images/uploads/' . $r . $d . $filename);
                $finalDes = 'assets/images/uploads/' . $r . $d . $filename;
                move_uploaded_file($filetmp, '../assets/images/uploads/' . $r . $d . $filename);
                // send data to database
                

                $db->query("UPDATE events SET EventTitle = :EventTitle, EventImg = :EventImg, town = :town, status = :status, category = :category, date= :date, time= :time, finish_date= :finish_date, finish_time= :finish_time, member_number= :member_number, address= :address, map_link= :map_link, fb_link= :fb_link, tw_link= :tw_link, event_desc= :event_desc, org_desc= :org_desc, ticket_price= :ticket_price, voda_num= :voda_num  WHERE id = :id ");

                $db->bind(':EventTitle', $EventTitle);
                $db->bind(':EventImg', $finalDes);
                $db->bind(':town', $town);
                $db->bind(':status', $status);
                $db->bind(':category', $category);
                $db->bind(':date', $date);
                $db->bind(':time', $time);
                $db->bind(':finish_date', $finish_date);
                $db->bind(':finish_time', $finish_time);
                $db->bind(':member_number', $members);
                $db->bind(':address', $address);
                $db->bind(':map_link', $map_link);
                $db->bind(':fb_link', $fb_link);
                $db->bind(':tw_link', $tw_link);
                $db->bind(':event_desc', $event_desc);
                $db->bind(':org_desc', $org_desc);
                $db->bind(':ticket_price', $ticket_price);
                $db->bind(':voda_num', $voda_num);
                $db->bind(':id', $EventId);

                $db->execute();

                // get event title from events table
                $db->query("SELECT EventTitle FROM events WHERE id='$EventId'");
                $db->bind(':id', $EventId);
                $row2 = $db->single();
                $count2 = $db->rowCount();

                // get regby id from users_registered table
                $db->query("SELECT regby FROM users_registered WHERE events_id='$EventId'");
                $row8 = $db->single();
                $count8 = $db->rowCount();
                if ($count8 > 0)
                {
                    $_SESSION['regby'] = $row8->regby;
                }

                $regby = isset($_SESSION['regby']) ? $_SESSION['regby'] : '';

                // get followed_event id from follow_event table
                $db->query("SELECT followed_event FROM follow_event WHERE followed_name='$row2->EventTitle'");
                $row = $db->single();
                $count = $db->rowCount();
                if ($count > 0)
                {
                    $_SESSION['followed_event'] = $row->followed_event;
                }

                if ($EventId == $_SESSION['followed_event'])
                {

                    // get follower id id from follow_event table
                    $db->query("SELECT follower FROM follow_event WHERE followed_event='$EventId'");
                    $followers = $db->resultSet();
                    foreach ($followers as $follower)
                    {
                        // data to put into notifications
                        $followers = $follower->follower;
                        $message = 'تم تعديل إيفنت <a href="event-details.php?id=' . $EventId . '">' . $followed_name . '</a>';
                        $read_n = 0;
                        date_default_timezone_set('Africa/Cairo');
                        $current = date('Y-m-d H:i:s');
                        // insert data in notifications from follower
                        $db->query(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$followers')");
                        $db->execute(array(
                            $message,
                            $read_n,
                            $current,
                            $followers
                        ));
                        // end of foreach
                        
                    }
                    // insert data in notifications from registered
                    $db->query(" INSERT INTO notifications ( message, read_n, date, noti_to ) VALUES ('$message', '$read_n', '$current', '$regby')");
                    $db->execute(array(
                        $message,
                        $read_n,
                        $current,
                        $regby
                    ));
                    // end of follow event  == followe event session
                    
                }
                // redirect back to specific page
                echo "<p class='alert alert-success text-center'>تم التعديل بنجاح سيتم التحديث في غضون 2 ثانية</p>
        <meta http-equiv='refresh' content='3;URL=/eventy/event-dashboard.php?id=$EventId'>";
                // end of image part
                
            }
            // if not reach by submit action
            
        }
        else
        {
            echo "sorry";
        }
        // if page is Delete
        
    }
    elseif ($do == 'DeleteEvent')
    {
        $EventId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // get all data from event table
        $db->query("SELECT * FROM events WHERE id = '$EventId' LIMIT 1");
        $db->single();
        $count = $db->rowCount();
        if ($count > 0)
        {
            // delete all data from event table
            $db->query("DELETE FROM events WHERE id = :id ");
            $db->bind(":id", $EventId);
            $db->execute();
            echo "<p class='alert alert-success text-center'>تم الحذف بنجاح سيتم التحديث في غضون ثانية</p>
            <meta http-equiv='refresh' content='1;URL=/eventy/event-dashboard.php?id=$EventId'>";
            // end of if table events empty
            
        }
        // end of delete page
        
    }
?>


        </div>
    </div>
<!-- end of check logged in -->
<?php
}
else
{
    header('location:login.php');
}

require_once ('layouts/footer.php');
?>
<!-- start js part -->
<script>
    $(document).ready(function(){
        $('.confirm').click(function(){
            return confirm('ary you sure?');
        });
    });
</script>
