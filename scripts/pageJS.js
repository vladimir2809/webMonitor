jQuery(document).ready(function(){
//    function transferData(){
//     
//    }
//alert('Привет мир!');
    $(':button[name="btnTransfer"]').bind('click', function(){
        $('#dataSizeDB').val($('#dataSize').val());
        $('#dataDeviationSizeDB').val(2000);
        $('#dataH1DB').val($('#dataH1').val());
        $('#dataTitleDB').val($('#dataTitle').val());
        $('#dataKeywordsDB').val($('#dataKeywords').val());
        $('#dataDescriptionDB').val($('#dataDescription').val());
    });
});

