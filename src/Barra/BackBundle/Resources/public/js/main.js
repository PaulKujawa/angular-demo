$(window).ready(function() {
    clipBoard = "";

    $('td[contenteditable=true]').click(function() {
        clipBoard = $(this).text();
    });

    $('td[contenteditable=true]').blur(function() {
        td = $(this);
        data = $.trim(td.text());
        td.text(data);

        id = td.parent().attr('data-id');
        routePath = td.closest('table').attr('data-routePath');

        $.post(
            routePath, {
                pk:id,
                content:data

            }, function(returnData) {
                if (returnData.responseCode == 200)
                    response(td, '#3c948b');

                else if (returnData.responseCode == 400)
                    response(td, '#df6c4f', returnData.content);

                else
                    response(td, '#df6c4f', 'Could not get response');
            }/* no 4th parameter for post() so jQuery guess the data-type based on our given content-Type */
        );
    });



    var response = function(td, color, error) {
        td.css('color', color);

        if (error !== undefined) {
            td.text(error);

            setTimeout(function(){
                td.text(clipBoard);
                td.css('color', 'inherit');
            }, 2500);

        } else {
            setTimeout(function(){
                td.text(td.text());
                td.css('color', 'inherit');
            }, 1500);
        }

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