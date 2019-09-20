 jQuery(document).ready(function(){
    $("#telephone").keypress(function (event){
                           if (event.which<47 || event.which>57) //запретить вводить все кроме цивр
                               event.preventDefault(); 
                           // если длина номер телефона больше 10 цивр 
                           if ($('#telephone').val().length>=10){
                               event.preventDefault(); 
                             //  $('#telephone').css({'border':"1px solid rgb(128,255,0)"});  
                           }		
    });
});

