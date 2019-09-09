jQuery(document).ready(function(){
//alert('Привет мир!');
    // добавляем обработчик события к кнопке ">>"
    $(':image[name=btnDelete]').bind('click', function(event){
        if (confirm("Вы действительно хотите удалить страницу "+$('#hidUrlOfDelete').attr('value') )==false){
            event.preventDefault();
        }
           
       
            
     });
 });
