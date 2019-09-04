jQuery(document).ready(function(){
//alert('Привет мир!');
    // добавляем обработчик события к кнопке ">>"
    $(':button[name="btnTransfer"]').bind('click', function(){
        $('#dataSizeDB').val($('#dataSize').val());
        $('#dataDeviationSizeDB').val(2000);
        $('#dataH1DB').val($('#dataH1').val());
        $('#dataTitleDB').val($('#dataTitle').val());
        $('#dataKeywordsDB').val($('#dataKeywords').val());
        $('#dataDescriptionDB').val($('#dataDescription').val());
    });
    // разрешаем вводить только цивры в поле text;
    $("input:text").keypress(function (event){
                        //if ($("input:text").val()=='') 
                 //         alert(  $("input:text").val()); 
                        if ($(this).val()==''){
                            if ((event.which<47 || event.which>57)|| event.which==48) 
                                event.preventDefault();
                        }
			if (event.which<47 || event.which>57) 
                            event.preventDefault();
                     
                    	
			
		});
    $("input:text").focusout(function (){          
                   if ($(this).val()=='') $(this).val(0) ;
    });       
    $("input:text").focusin(function (){          
                   if ($(this).val()=='0') $(this).val('') ;
    });  
});


