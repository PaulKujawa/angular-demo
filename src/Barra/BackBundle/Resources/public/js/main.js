$(window).load(function() {
    var collectEntities = function() {
        var tables = $('table:not(.jsStorage)');

        tables.each(function() {
            var e = [];

            e['table'] = $(this);
            e['action'] = e['table'].attr('data-type');

            e['iFormRow'] = e['table'].find('.formInRow');
            e['iForm'] = e['table'].parent();

            var wrapper = $('.jsStorage[data-type="'+e["action"]+'"]');
            e['uFormRow'] = wrapper.find('tr').detach();
            e['uForm'] = wrapper.find('form').detach();
            wrapper.remove();

            e['activeTr'] = null;
            entities.push(e);
        });
    };



    var chooseEntity = function(action) {
        for (var i=0; i < entities.length; i++) {
            if (entities[i]['action'] === action)
                return i;
        }

        window.alert('something went wrong, please reload the site.');
        return false;
    };



    $('section').on('click', 'td.editableCell', function() {
        var compareString = $(this).closest('table').attr('data-type');
        var i = chooseEntity( compareString );

        if (entities[i]['activeTr'] !== null) return;
        entities[i]['activeTr'] = $(this).parent();

        // remove iForm
        entities[i]['table'].unwrap();
        entities[i]['table'].wrap(entities[i]['uForm']);
        entities[i]['iFormRow'] = entities[i]['iFormRow'].detach();

        // insert uForm
        var id = entities[i]['activeTr'].attr('data-id');
        entities[i]['activeTr'].replaceWith(entities[i]['uFormRow']);
        entities[i]['uFormRow'].find('.formPk').val(id);

        // fill uForm
        fillUForm(i);
        var index = $(this).index();
        entities[i]['uFormRow'].find('.form-control').eq(index).focus();
    });



    var fillUForm = function(i) {
        var values = [];
        entities[i]['activeTr'].children('.editableCell').each(function() {
            values.push( $(this).html() );
        });
        values.reverse();

        entities[i]['uFormRow'].find('.form-control').each(function() {
            var val = values.pop();

            if ($(this).prop('type') == 'select-one') {
                $(this).find("option").filter(function() {
                    return $(this).text() == val
                }).prop('selected', true);

            } else if ($(this).prop('type') == 'checkbox') {
                $(this).prop('checked', val);

            } else
                $(this).val( val );
        });
    };



    $('section').on('submit', "[name$='Update']", function(event) {
        var compareString = $(this).find('table').attr('data-type');
        var i = chooseEntity(compareString);
        uFormRemoveValidation(i);
        event.preventDefault();
        var uForm = $(this);

        $.ajax({
            url: uForm.attr('action'),
            type: "POST",
            data: uForm.serialize()

        }).done(function(response) {
            if (response.code == 200)
                hideUForm(i);

            else if (response.code == 400)
                uFormInsertFieldValidation(i, response.fieldError);

            else if (response.code == 409)
                uFormInsertFormValidation(i, response.dbError);

            else if (response.code == 500)
                uFormInsertFormValidation(i, "A fatal 500 error occurred.");
        });
    });



    var uFormRemoveValidation = function(i) {
        var tds = entities[i]['uFormRow'].children('.danger');
        tds.removeClass('danger has-error');
        tds.find('.form-control').tooltip("destroy");
    };



    var uFormInsertFieldValidation = function(i, errors) {
        $.each(errors, function(fieldname, number) {
            var output = "<ul>";
            $.each(number, function(index, error) {
                output += '<li>'+ error +'</li>';
            });
            output += "</ul>";

            var formWidget = entities[i]['uFormRow'].find("[name$='["+ fieldname +"]']");
            var td = formWidget.parent();
            td.addClass('danger has-error');
            createTooltip(formWidget, output, false);
            formWidget.blur();
        });
    };



    var uFormInsertFormValidation = function(i, errors) {
        var tr = entities[i]['uFormRow'];
        tr.addClass('danger has-error');
        createTooltip(tr, errors, true);
    };



    var iFormInsertValidation = function() {
        // fields
        $('.formInRow').find('ul').each(function(){
            var list = $(this);
            var formWidget = list.next();
            var td = formWidget.parent();
            td.addClass('danger has-error');
            list.remove();
            createTooltip(formWidget, "<ul>"+list.html()+"</ul>", false);
        });

        // form
        var errorColumns = $('.formInRowError');
        errorColumns.find('ul').each(function(){
            var ul = $(this);
            var tr = ul.closest('tr');
            var tr = tr.prev();
            tr.addClass('danger has-error');
            createTooltip(tr, "<ul>"+ul.html()+"</ul>", true);
        });
        errorColumns.remove();
    };



    var createTooltip = function(target, output, isForm) {
        target.tooltip({
            items: target,
            content: output,
            position: {
                my: 'center top', /* position of base element */
                at: 'center-10 bottom+10' /* position of tooltip */
            }
        });
        if (isForm)
            target.tooltip("open");
    };



    var hideUForm = function(i) {
        var values = [];
        entities[i]['uFormRow'].find('.form-control').each(function() {
            if ($(this).prop('type') == 'select-one') {
                values.push( $(this).find("option:selected").text() );

            } else
                values.push( $(this).val() );
        });

        values.reverse();
        entities[i]['activeTr'].children('.editableCell').each(function() {
            $(this).text(values.pop());
        });

        // toggle Forms
        entities[i]['table'].unwrap();
        entities[i]['table'].wrap(entities[i]['iForm']);
        entities[i]['uFormRow'].replaceWith(entities[i]['activeTr']);
        entities[i]['table'].append(entities[i]['iFormRow']);

        // optical feedback
        entities[i]['activeTr'].addClass('success');
        setTimeout(function() {
            entities[i]['activeTr'].removeClass('success');
            entities[i]['activeTr'] = null;
        }, 1500);
    };


    var entities = [];
    collectEntities();
    iFormInsertValidation();
});




