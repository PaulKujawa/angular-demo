/*
    HTML accessible via file.previewElement

    div.dz-preview attached classes:
        while upload: .dz-processing
        after upload: .dz-success
        after error:  .dz-error & [data-dz-errormessage] will contain servermessage


    data-dz-remove for separate delete-links instead of the addRemoveLinks ones
        e.g.   <img src="removebutton.png" alt="Click me to remove the file." data-dz-remove />

 */

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
        '<a class="dz-remove" href="#" data-dz-remove>'                 +
            '<span class="glyphicon glyphicon-minus"></span>'           +
        '</a>'                                                          +

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
    //addRemoveLinks: true,
    thumbnailWidth: null, // height:100%, width:auto (100)
    acceptedFiles: "image/*, application/pdf",
    previewTemplate: itemTemplate,
    init: function() {
        this.on("removedfile", function(file) {
            //Dropzone.getRejectedFiles;
            var ret = file.width;
            alert(ret);
        });
    }
 };

