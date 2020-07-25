<?php 
// start session
session_start();
// connection to data base

require_once('modules/Database.php');

// when the user signed in
if (isset($_SESSION['usermail'])) { 

// add header section    
require_once ('layouts/header.php');?>
<!-- start add event section -->
<div class="register-event text-right">
  <div class="container">
    <h2 class="text-center">أضف الإيفنت الخاص بك</h2>
    <form class="login-form" style="width:100%;" enctype="multipart/form-data" action="saveEvent.php" method="post">
    <div class="row">
<!--    the first half    -->
    <div class="col-md-6">
        <input class="form-control mb-4" type="text" name="EventTitle" placeholder="عنوان الإيفنت">
        
        <select id="my-select" name="category" class="mb-4">
            <option>اختر التصنيف</option>
            <option value="عام">عام</option>
            <option value="علمي">علمي</option>
            <option value="تعليمي">تعليمي</option>
            <option value="ثقافة وأدب">ثقافة وأدب</option>
            <option value="تقني">تقني</option>
            <option value="ديني إسلامي">ديني إسلامي</option>
            <option value="تنمية ذاتية">تنمية ذاتية</option>
            <option value="توظيف">توظيف</option>
        </select>
              
        <label>صورة الإيفنت</label>
        <input class="form-control mb-4" type="file" name="EventImg">
              
        <select name="status" class="mb-4">
            <option>اختر التكلفة</option>
            <option value="مجاني">مجاني</option>
            <option value="مدفوع">مدفوع (الدفع عند الحضور)</option>
            <option value="الدفع ضروري">الدفع قبل الحضور</option>
        </select>

        <ul class=" nav nav-tabs text-center" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free"
                aria-selected="true">مجانية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid"
                aria-selected="false">سعر التذكرة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="requirePaid-tab" data-toggle="tab" href="#requirePaid" role="tab" aria-controls="requirePaid"
                aria-selected="false">رقم هاتف التحويل</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="free" role="tabpanel" aria-labelledby="free-tab">
            <p class="mt-3">التذكرة مجانية</p>
        </div>
        <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
            <input name="ticket_price" class="form-control mb-4 mt-4" type="number" onblur="this.placeholder='سعر التذكرة ( ج.م )'" placeholder="سعر التذكرة ( ج.م )" onfocus="this.placeholder=''">
        </div>
        <div class="tab-pane fade" id="requirePaid" role="tabpanel" aria-labelledby="requirePaid-tab">
            <input name="voda_num" class="form-control mb-4 mt-4" type="tel" onblur="this.placeholder='رقم تحويل فودافون كاش'" placeholder="رقم تحويل فودافون كاش" onfocus="this.placeholder=''">
          </div>
         </div>
        
        <textarea name='event_desc' class='form-control mb-4' rows='5' onblur="this.placeholder='وصف الإيفنت'" placeholder="وصف الإيفنت" onfocus="this.placeholder=''"></textarea>  
        
        <textarea name='org_desc' class='form-control mb-4' rows='5' onblur="this.placeholder='وصف منظم الإيفنت'" placeholder="وصف منظم الإيفنت" onfocus="this.placeholder=''"></textarea> 
        
        <label>تاريخ البدء</label>
        <input name="date" class="form-control mb-4" type="date" value=""><br>
          
        <label>زمن البدء</label>
        <input name="time" class="form-control mb-4" type="time" value=""><br>

        <label>تاريخ الانتهاء</label>
        <input name="finish_date" class="form-control mb-4" type="date" value="">
    </div>
<!-- the second half -->
    <div class="col-md-6">
        <select name="town" class="mb-4">
            <option>اختر المحافظة</option>
            <option value="القاهرة">القاهرة</option>
            <option value="الغربية">الغربية</option>
            <option value="الإسماعيلية">الإسماعيلية</option>
            <option value="الأسكندرية">الأسكندرية</option>
            <option value="أسوان">أسوان</option>
            <option value="أسيوط">أسيوط</option>
            <option value="البحر الأحمر">البحر الأحمر</option>
            <option value="الأقصر">الأقصر</option>
            <option value="البحيرة">البحيرة</option>
            <option value="الجيزة">الجيزة</option>
            <option value="الدقهلية">الدقهلية</option>
            <option value="السويس">السويس</option>
            <option value="الشرقية">الشرقية</option>
            <option value="الفيوم">الفيوم</option>
            <option value="القليوبية">القليوبية </option>
            <option value="المنوفية">المنوفية</option>
            <option value="المنيا">المنيا</option>
            <option value="الوادي الجديد">الوادي الجديد</option>
            <option value="بني سويف">بني سويف</option>
            <option value="بورسعيد">بورسعيد </option>
            <option value="جنوب سيناء">جنوب سيناء</option>
            <option value="دمياط">دمياط </option>
            <option value="سوهاج">سوهاج </option>
            <option value="شمال سيناء">شمال سيناء</option>
            <option value="قنا">قنا</option>
            <option value="كفر الشيخ">كفر الشيخ</option>
            <option value="مرسى مطروح">مرسى مطروح</option>
            <option value="السادس من أكتوبر">السادس من أكتوبر</option>
        </select>

            <label>زمن الإنتهاء</label>
            <input name="finish_time" class="form-control mb-4" type="time" value=""><br>

            <label>أقصى عدد مطلوب</label>        
            <input name="member_number" class="form-control mb-4" type="number"><br>

            <label>العنوان بالتفصيل</label>
            <input name="address" class="form-control mb-4" placeholder="المحافظة، المدينة، علامة مميزة"><br>

            <label>خريطة الموقع</label>
            <input name="map_link" class="form-control mb-4" placeholder="قم بلصق رابط خريطة جوجل إن وُجد"><br>

            <label>رابط الفيس بوك</label>
            <input name="fb_link" class="form-control mb-4" placeholder="قم بلصق رابط صفحة الفيس بوك إن وُجد"><br>

            <label>رابط تويتر</label>
            <input name="tw_link" class="form-control mb-4" placeholder="قم بلصق رابط تويتر إن وُجد">
            <button name="action" class="btn btn-primary" type="submit">Add</button>
    </div>
    </div>
    </form>
  </div>
</div>
<!-- end if the user signed in -->
<?php } else {
    header('location:./auth/login.php');
}

require_once ('layouts/footer.php'); ?>