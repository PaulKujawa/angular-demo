$(document).ready(function() {
    // ugly part to find rows & forms
    var entity = {};
    entity['table'] = $('table').first();
    entity['iForm'] = entity['table'].parent();
    entity['type'] = entity['table'].attr('data-type');
    entity['iFormRow'] = entity['iForm'].find('.formInRow');
    entity['uFormRow'] = $('.jsStorage[data-type="'+entity['type']+'"] tr').detach();
    entity['uForm'] = $('.jsStorage[data-type="'+entity['type']+'"] form').detach();
    entity['oldTr'] = null;


    var editableCells   = $('.editableCell');
    $('.jsStorage[data-type="'+entity['type']+'"]').remove();


    editableCells.click(function() {
        if (entity['oldTr'] !== null) return;
        entity['oldTr'] = $(this).parent();

        // remove iForm
        entity['table'].unwrap();
        entity['table'].wrap(entity['uForm']);
        entity['iFormRow'] = entity['iFormRow'].detach();

        // insert uForm
        var id = entity['oldTr'].attr('data-id');
        entity['oldTr'].replaceWith(entity['uFormRow']);
        entity['uFormRow'].find('.formPk').val(id);
    });



    entity['uForm'].submit(function() {
        entity['uForm'] = $(this);

        $.ajax({
                url: entity['uForm'].attr('action'),
                type: "POST",
                data: entity['uForm'].serialize()

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




