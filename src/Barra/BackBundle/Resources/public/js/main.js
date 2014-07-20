$( window ).ready(function() {

    rows = $('table tr');
    editableCells = rows.find('.editableCell'); // td:not(:last-child)

    updateForm = rows.last().find('form');
    updateFormFields = updateForm.find('input');

    updateFormFields.each(function() {
  //      $(this).val('hallo');
    });




    editableCells.click(function () {
        rowData = $(this).parent().find('.editableCell'); // td:not(:last-child)

        rowData.each(function() {
//            window.alert( $(this).html() );
        });

        rowId = $(this).parent().data('id');

    //    window.alert( rowId );
    });
});

//$('#formUpdate_id').val(10);

//var name = $(this).html();
//$('#formUpdate_name').val(name);

// window.alert( $('#formUpdate_id').val() );
// .css( "background-color", "red" );
