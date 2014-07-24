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
    $('.jsStorage[data-type="'+entity['type']+'"]').remove();




    entity['table'].on('click', '.editableCell', function() {
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

        var values = [];
        entity['oldTr'].children('.editableCell').each(function() {
            values.push( $(this).html() );
        });

        values.reverse();
        entity['uFormRow'].find('.form-control').each(function() {
            $(this).val( values.pop() );
        });

        var index = $(this).index();
        entity['uFormRow'].find('.form-control').eq(index).focus();
    });



    entity['uForm'].submit(function(event) {
        event.preventDefault();
        var mystery = $(this);

        $.ajax({
            url: mystery.attr('action'),
            type: "POST",
            data: mystery.serialize()

        }).done(function(response) {
            if (response.code == 200)
                hideUForm();

            else if (response.code == 400)
                manageValidationErrors(response.message);

             else if (response.code == 404)
                $('#foo').html('404 '+response.message);
            //response(td, '#df6c4f', ajaxResponse.content);

            else
                $('#foo').html("error");
            //response(td, '#df6c4f', 'Could not get response');
        });
    });



    var hideUForm = function() {
        var values = [];
        entity['uFormRow'].find('.form-control').each(function() {
                values.push( $(this).val() );
            }
        );

        values.reverse();
        entity['oldTr'].children('.editableCell').each(function() {
                $(this).text(values.pop());
            }
        );

        // toggle Forms
        entity['table'].unwrap();
        entity['table'].wrap(entity['iForm']);
        entity['uFormRow'].replaceWith(entity['oldTr']);
        entity['table'].append(entity['iFormRow']);

        // optical feedback
        entity['oldTr'].addClass('trUpdated')
        setTimeout(function() {
            entity['oldTr'].removeClass('trUpdated');
            entity['oldTr'] = null;
        }, 1500);
    };


    var manageValidationErrors = function(errors) {
        $.each(errors, function(fieldname, number) {
            var output = "<ul>";

            $.each(number, function(index, error) {
                output += '<li>'+ error +'</li>';
            });

            output += '</ul>';
            var field = entity['uFormRow'].find("[name$='["+ fieldname +"]']");
            field.before(output);
        });
    }
});




