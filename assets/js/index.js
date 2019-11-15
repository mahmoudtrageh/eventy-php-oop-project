$(document).ready(function(){

var h2Offset = $(".fixed-menu").offset().top;
$(window).scroll(function(){
    if( $(window).scrollTop() > h2Offset )
        {
        $('.fixed-menu').css({'position':'fixed', 'z-index':'9999999999', 'top':'0', 'width':'40%', 'border':'1px solid #27ae60', 'padding':'8px', 'backgroundColor':'#fff', 'fontSize':'18px'});
            
             $('.fixed-btn').css({'position':'fixed', 'z-index':'9999999999', 'top':'0', 'width':'40%'});
        
                   
    } else {
        
        $('.fixed-menu').css({'position':'static', 'width':'100%', 'border':'0', 'padding':'10px', 'backgroundColor':'transparent', 'fontSize':'24px'});
                $('.fixed-btn').css({'position':'static', 'width':'100%'});

 
    }
})
//...................... End menu when scroll ................
    
    
    
//    $('#username').blur(function(){
//        
//        var pattern = /^\d/;
//    
//    var userName = document.getElementById('username').value;
//              
//        if(userName != "") {
//            
//        if ( pattern.test(userName) == true ){
//            
//            $('#username').nextAll().hide(500);
//            $('.alert-success').show(500);
//            
//                        
//        } else {
//            
//            $('#username').nextAll().hide(500);
//            $('.alert-danger').show(500);
//        }
//        
//        } else {
//        
//            $('#username').nextAll().hide(500);
//
//        }
//        
//    })
    
    });