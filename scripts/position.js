jQuery(document).ready(function(){
    var viewportWidth = $(window).width();
    var widthBody=$("body").innerWidth();
    //alert (viewportWidth+'  '+widthBody  );
    $('body').css({"position":"absolute"});
    $('body').css({"left":(viewportWidth/2)-(widthBody)/2+"px"});
    $(window).resize(function(){
        var viewportWidth = $(window).width();
        var widthBody=$("body").innerWidth();
        $('body').css({"left":(viewportWidth/2)-(widthBody)/2+"px"}); 
    });
});


