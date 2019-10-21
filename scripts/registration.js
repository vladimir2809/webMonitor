jQuery(document).ready(function(){
//alert('Привет мир!');
// когда загрежена страница
$(window).load(function(){ 
    // если галочка отправлять смс стои
    if ($("#checkboxSMS").prop('checked')){
       $('.SMS:input').css({"border":"1px solid black"});
       $( ".SMS:input" ).prop( "disabled", false );
       $('p.SMS').css({"color":"black"});    
       $("#spanTelephone").css({"color":"black"});
    }
    // если галочка отправлять смс не стоит
    if ($("#checkboxSMS").prop('checked')==false){
       $('.SMS:input').css({"border":"1px solid gray"});
       $( ".SMS:input" ).prop( "disabled", true );
       $('p.SMS').css({"color":"gray"});
       $("#spanTelephone").css({"color":"gray"});
    }
 });
    // когда изменяем галочку отправлять смс то выключить или включить элементы отвечаюшие за смс
    $("#checkboxSMS").change(function(){
  //      $('.SMS:input').css({'border':'1px dolid gray'});
       if ($("#checkboxSMS").prop('checked')){
           $('.SMS:input').css({"border":"1px solid black"});
           $( ".SMS:input" ).prop( "disabled", false );
           $('p.SMS').css({"color":"black"});    
           $("#spanTelephone").css({"color":"black"});
       }
       if ($("#checkboxSMS").prop('checked')==false){
           $('.SMS:input').css({"border":"1px solid gray"});
           $( ".SMS:input" ).prop( "disabled", true );
           $('p.SMS').css({"color":"gray"});
           $("#spanTelephone").css({"color":"gray"});
       }
    });
    // при вводе номера телефона
    $("#telephone").keypress(function (event){
			if (event.which<47 || event.which>57) //запретить вводить все кроме цивр
                            event.preventDefault(); 
                        // если длина номер телефона больше 10 цивр 
                        if ($('#telephone').val().length>=10){
                            event.preventDefault(); 
                            $('#telephone').css({'border':"1px solid rgb(128,255,0)"});  
                        }		
    });
    // при нажатии на кнопку ок при показе окна с ошибками
    $(":button[name='btnError']").click(function(){
         $('#divMessageError').addClass('divDisabled');
         $('#divScreen').addClass('divDisabled');
    });
    // подсветка имени фамилии и логина
    $('input:text[name="nameUser"],\n\
       input:text[name="surnameUser"],\n\
       input:text[name="login"]').focusout(function(event){
        if ($(this).val().length>=3){
            $(this).css({'border':"1px solid rgb(128,255,0)"});
        }else{
            $(this).css({'border':"1px solid red"});
        }    
    });
    // подсветка пароля
    $(':password[name="password"]').focusout(function(event){
        if ($(this).val().length>=6){
            $(this).css({'border':"1px solid rgb(128,255,0)"});
        }else{
            $(this).css({'border':"1px solid red"});
        } 
    });
    // подсветка дублера пароля
    $(':password[name="password2"]').focusout(function(event){
        if ($(this).val()===$(':password[name="password"]').val()){
            $(this).css({'border':"1px solid rgb(128,255,0)"});
        }else{
            $(this).css({'border':"1px solid red"});
        } 
    });
    // подсветка номера телефона
    $("#telephone").focusout(function (event){
        if ($(this).val().length>=10){
           $(this).css({'border':"1px solid rgb(128,255,0)"});
        }else{
           $(this).css({'border':"1px solid red"});
        } 
                   
    });
 });


