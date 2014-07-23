$(document).ready(function() {


    
    var editableCells   = $('.editableCell');
    var tr = null;

    var insertFormRow = null;
    var insertForm = null;

    var updateFormRow   = $('#deletedByJS .updateFormRow').detach();
    var updateForm      = $('#deletedByJS form').detach();
    $('#deletedByJS').remove();


    editableCells.click(function() {
        if (tr !== null) return;

        tr                  = $(this).parent();
        var insertForm      = tr.closest('form');
        var insertFormRow   = insertForm.find('.insertFormRow');

        // switch forms tags
        var table = insertForm.find('table');
        table.unwrap();
        table.wrap(updateForm);

        // switch rows
        insertFormRow = insertFormRow.detach();
        id = tr.attr('data-id');
        tr.replaceWith(updateFormRow);
        $('#formManufacturerUpdate_id').val(id);
    });



    updateForm.submit(function() {
        formUrl = updateForm.attr('action');
        updateForm = $(this);

        $.ajax({
                url: formUrl,
                type: "POST",
                data: updateForm.serialize()

        }).done(function(response) {
            if (response.code == 200) { //response(td, '#3c948b');
                $('#foo').html('200 '+ response.message);

            }
            else if (response.code == 400) {
                errors = response.message;
                $('#foo').html('400 '+errors);

            } else if (response.code == 404)
                $('#foo').html('404 '+response.message);
                //response(td, '#df6c4f', ajaxResponse.content);

            else
                $('#foo').html("error");
                //response(td, '#df6c4f', 'Could not get response');


            switchForms();
        });

        return false;
    });


    // remove insertForm
    //form.replaceWith(form.html());
    //$('.insertFormRow').remove();

    //updateFormRow.appendTo( row.parent() );

    var switchForms = function() {
        tr = null;

    }



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




