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
 //    разрешаем вводить только цивры в поле text;
    $("input:text").keypress(function (event){
			if (event.which<47 || event.which>57) 
                            event.preventDefault();		
		});
    $("input:text").focusout(function (){   
                   // делаем так что бы не оставались нули в начале числа
                   arr_num=$(this).val().split(''); 
                   while (arr_num[0]=='0'){
                       arr_num.shift();
                   }
                  // alert(arr_num);
                   num=arr_num.join('');
                   $(this).val(num)
                   if ($(this).val()=='') {// если строка пустая
                       $(this).val(0) ;// заполнить ее нулем
                   }
                   
    });       
    // если в стрке только ноль делаем строку пустой при принятии фокуса text
    $("input:text").focusin(function (){          
                   if ($(this).val()=='0') $(this).val('') ;
    });  
});


