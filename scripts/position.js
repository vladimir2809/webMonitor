jQuery(document).ready(function(){
    var viewportWidth = $(window).width();
    var widthBody=$("body").innerWidth();
    var left=(viewportWidth/2)-(widthBody)/2;
    var oldIE;
    if ($('html').is('.lt-ie7, .lt-ie8, .lt-ie9')) {
			oldIE = true;
		}
    //alert (viewportWidth+'  '+widthBody  );
    $('body').css({"position":"absolute"});
    $('body').css({"left":(viewportWidth/2)-(widthBody)/2+"px"});
    if (oldIE)
    {
        $('#main').css({"position":"absolute"});
        $('#main').css({"left":left+90+'px',"top":95+'px'});
        $('#mainLogin').css({"position":"absolute"}); 
        var leftLogin=(viewportWidth/2)-$('#mainLogin').innerWidth()/2;
        $('#mainLogin').css({"left":leftLogin+'px',"top":95+'px'});
    }
    $(window).resize(function(){
        var viewportWidth = $(window).width();
        var widthBody=$("body").innerWidth();
        $('body').css({"left":(viewportWidth/2)-(widthBody)/2+"px"}); 
    });
});


