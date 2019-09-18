jQuery(document).ready(function(){
//alert('Привет мир!');

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
    $("#telephone").keypress(function (event){
			if (event.which<47 || event.which>57) 
                            event.preventDefault(); 
                        if ($('#telephone').val().length>=10)
                            event.preventDefault(); 
                            
        //$("#telephone").val('7');		
		});
  
 });


