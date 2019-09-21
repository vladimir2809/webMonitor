 jQuery(document).ready(function(){
    // при нажатии на кнопку ок при показе окна с ошибками
    $(":button[name='btnError']").click(function(){
         $('#divMessageError').addClass('divDisabled');
         $('#divScreen').addClass('divDisabled');
    });
    $("#telephone").keypress(function (event){
                           if (event.which<47 || event.which>57) //запретить вводить все кроме цивр
                               event.preventDefault(); 
                           // если длина номер телефона больше 10 цивр 
                           if ($('#telephone').val().length>=10){
                               event.preventDefault(); 
                             //  $('#telephone').css({'border':"1px solid rgb(128,255,0)"});  
                           }		
    });
    $(window).load(function(){ 
        if ($("#checkboxSms").prop('checked')){
           $('.SMS').prop('disabled',false);
        }else{
           $('.SMS').prop('disabled',true); 
        } 
    });
     $("#checkboxSms").change(function(){
        if ($("#checkboxSms").prop('checked')){
           $('.SMS').prop('disabled',false);
        }else{
           $('.SMS').prop('disabled',true); 
        }
        
            
    });
   
});

