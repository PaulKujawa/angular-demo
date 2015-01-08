$(function() {
    $(".draggable").sortable({
        axis: "y",
        cursor: "move",
        revert: true,

        start: function(event, ui) {
            var posBefore = ui.item.index()+1; // db id starts with 1
            ui.item.data('posBefore', posBefore);
        },

        update: function(event, ui) {
            var posBefore = ui.item.data('posBefore');
            var posAfter = ui.item.index()+1; // db id starts with 1
            var table = ui.item.closest('table');

            swapListEntries(table, ui.item, posBefore, posAfter);
        }
    });


    var swapListEntries = function(table, row, posBefore, posAfter) {
        var url = table.attr('data-swapLink').slice(0, -8)+posBefore+"/"+posAfter+"/ajax";

        $.ajax({
            url: url,
            type: "POST"
        }).done(function(response) {
            var aClass;
            if (response.code == 200)
                aClass = 'success';
            else
                aClass = 'danger';

            row.addClass(aClass);
            setTimeout(function() {
                row.removeClass(aClass);
            }, 1500)
        });
    };










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
        uForm_fill(i);
        var index = $(this).index();
        entities[i]['uFormRow'].find('.form-control').eq(index).focus();
    });



    var uForm_fill = function(i) {
        var values = [];
        entities[i]['activeTr'].children('.editableCell').each(function() {
            values.push( $(this).html() );
        });
        values.reverse();

        entities[i]['uFormRow'].find('.form-control').each(function() {
            var val     = values.pop(),
                widget  = $(this).prop('type');

            if (widget == 'select-one') {
                $(this).find("option").filter(function() {
                    return $(this).text() == val
                }).prop('selected', true);

            } else if (widget == 'select-multiple') {
                var multipleSelect  = $(this),
                    vals            = val.split(', ');

                $.each(vals, function(i, v) {
                    multipleSelect.find("option").filter(function() {
                        return $(this).text() == v
                    }).prop('selected', true);
                });

            } else if (widget == 'checkbox') {
                $(this).prop('checked', val);

            } else
                $(this).val( val );
        });
    };



    $('section').on('submit', "[name$='Update']", function(event) {
        var compareString = $(this).find('table').attr('data-type');
        var i = chooseEntity(compareString);
        uForm_RemoveValidation(i);
        event.preventDefault();

        var uForm = $(this),
            positionField = uForm.find("[name$='[position]']"),
            pos = positionField.parent().index()+1; // db starts with 1

        positionField.val(pos); /* db starts with 0, DOM with 1 */

        $.ajax({
            url: uForm.attr('action'),
            type: "POST",
            data: uForm.serialize()

        }).done(function(response) {
            if (response.code == 200)
                uForm_hide(i);

            else if (response.code == 400)
                uForm_AddFieldValidation(i, response.fieldError);

            else if (response.code == 409)
                uForm_AddFormValidation(i, response.dbError);

            else if (response.code == 500)
                uForm_AddFormValidation(i, "A fatal 500 error occurred.");
        });
    });



    var uForm_RemoveValidation = function(i) {
        var tds = entities[i]['uFormRow'].children('.danger');
        tds.removeClass('danger has-error');
        tds.find('.form-control').tooltip("destroy");
    };



    var uForm_AddFieldValidation = function(i, errors) {
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



    var uForm_AddFormValidation = function(i, errors) {
        var tr = entities[i]['uFormRow'];
        tr.addClass('danger has-error');
        createTooltip(tr, errors, true);
    };



    var iForm_exchangeValidation = function() {
        $('.formInRow').find('ul').each(function(){ /* uls = appear just for error lists */
            var fieldErrorUL = $(this);
            var widget = fieldErrorUL.next();
            var td = widget.parent();
            td.addClass('danger has-error');
            fieldErrorUL.remove();
            createTooltip(widget, "<ul>"+fieldErrorUL.html()+"</ul>", false);
        });

        // TODO
        // form
        var errorColumns = $('.formInRowError');
        errorColumns.find('ul').each(function() {
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
                my: 'center bottom',
                at: 'center-10 bottom+10'
            }
        });

        //  if (isForm) {
        // target.tooltip("open");
        //}
    };



    var uForm_hide = function(i) {
        var values = [];
        entities[i]['uFormRow'].find('.form-control').each(function() {
            if ($(this).prop('type') == 'select-one')
                values.push( $(this).find("option:selected").text() );
            else
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
    iForm_exchangeValidation();
});




