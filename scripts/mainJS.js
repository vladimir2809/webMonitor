jQuery(document).ready(function(){
    $(':image[name=btnDelete]').bind('click', function(event){
        if (confirm("Вы действительно хотите удалить страницу "+$('#hidUrlOfDelete').attr('value') )==false){
            event.preventDefault();
        }         
     });
 });
