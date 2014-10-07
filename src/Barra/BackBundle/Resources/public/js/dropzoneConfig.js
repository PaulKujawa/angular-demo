var itemTemplate =
    '<div class="dz-preview dz-file-preview">'                          +
        '<div class="dz-details">'                                      +
            '<img data-dz-thumbnail />'                                 +
            '<div class="dz-filename">'                                 +
                '<span data-dz-name></span>'                            +
            '</div>'                                                    +
        '</div>'                                                        +
        '<div class="dz-progress">'                                     +
            '<span class="dz-upload" data-dz-uploadprogress></span>'    +
        '</div>'                                                        +
        '<div class="dz-size" data-dz-size></div>'                      +

        /*'<a class="dz-remove" href="#" data-dz-remove>'               +
            '<span class="glyphicon glyphicon-minus"></span>'           +
        '</a>'                                                          +*/

        '<div class="dz-success-mark">'                                 +
            '<span>✔</span>'                                            +
        '</div>'                                                        +
        '<div class="dz-error-mark">'                                   +
            '<span>✘</span>'                                            +
        '</div>'                                                        +
        '<div class="dz-error-message">'                                +
            '<span data-dz-errormessage></span>'                        +
        '</div>'                                                        +
    '</div>';



Dropzone.options.dropzoneId = {
    parallelUploads: 3,
    maxFilesize: 4, // in MB, according to server validation
    thumbnailWidth: null, // height:100%, width:auto (100)
    acceptedFiles: "image/*, application/pdf",
    previewTemplate: itemTemplate,

    init: function() {
        this.on("success", function(file, response) {
            var url = $('#dropzoneId').attr('data-removeLink').slice(0, -1) + response.id;
            var removeIcon = Dropzone.createElement(
                "<a class='dz-remove' href="+url+" data-dz-remove><span class='glyphicon glyphicon-minus'></span></a>");
            file.previewElement.appendChild(removeIcon);
        });


        var thisDropzone = this;
        // each response file
            var fooFile = {name: "dbName.png", size: 6797, id: 6, generatedName: "dcd4b208597fbb7e7c79d5208079059373526f32.png"};
            thisDropzone.options.addedfile.call(thisDropzone, fooFile);
            thisDropzone.options.thumbnail.call(thisDropzone, fooFile, "/vpit/web/uploads/documents/" + fooFile.generatedName);

            var url = $('#dropzoneId').attr('data-removeLink').slice(0, -1) + fooFile.id;
            var removeIcon = Dropzone.createElement(
                "<a class='dz-remove' href="+url+" data-dz-remove><span class='glyphicon glyphicon-minus'></span></a>");
            fooFile.previewElement.appendChild(removeIcon);
        // end loop
    }
 };