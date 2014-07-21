$(window).ready(function() {
    $('td[contenteditable=true]').blur(function() {
        routePath = $(this).closest('table').attr('data-routePath');
        td = $(this);

        $.post(routePath, {editedData:$(this).html(), other:"attributes"}, function(returnData) {
            if (returnData.responseCode == 200)
                response(td, '#3c948b');

            else if (returnData.responseCode == 400)
                response(td, '#df6c4f', returnData.content);

            else
                response(td, '#df6c4f', 'Could not get response');
        });/* no 4th parameter for post() so jQuery guess the data-type based on our given content-Type */
    });



    var response = function(td, color, error) {
        td.css('color', color);
        data = td.html();
        time = 1500;


        if (error !== undefined) {
            td.html(error);
            time = 2500;
        }

        setTimeout(function(){
            td.html(data);
            td.css('color', 'inherit');
        }, time);
    }
});




/*
 var url=$("#myForm").attr("action");
 $.post(url,
 $("#myForm").serialize(),
 function(data){

 }
 );
 */