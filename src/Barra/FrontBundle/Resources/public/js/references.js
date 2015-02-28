$(function() {
    var wrapper     = $(".reference");

    if ( $(window).width() >= 992 ) { // hover just for 2x2 grid
        wrapper.children().addClass("hide");
        wrapper.mouseenter(function() {
            $(this).children().removeClass("hide");
        })
        .mouseleave(function() {
            $(this).children().addClass("hide");
        });
    }
});




$(function() {
    var addIndexEntry = function(indexWrapper, i) {
        indexWrapper.append('<li data-target="#carousel-reference" data-slide-to="'+i+'"></li>');
    };

    var addSlide = function(slidesWrapper, url, caption) {
        slidesWrapper.append(
            '<div class="item">' +
                '<img src="../../'+url+'" alt="'+caption+'">' +
                '<div class="carousel-caption">'+caption+'</div>' +
            '</div>');
    };

    var carousel        = $("#carousel-reference"),
        indexWrapper    = carousel.find(".carousel-indicators"),
        slidesWrapper   = carousel.find(".carousel-inner"),
        references      = $('.reference'),
        overlay         = $('.overlay'),
        section         = $('section');


    references.click(function() {
        var url = carousel.data('url').slice(0, -1) + $(this).data("referenceid");

        $.ajax({
            url: url,
            type: "POST"
        }).done(function(response) {
            if (response.files.length > 0) {
                indexWrapper.empty(); slidesWrapper.empty();

                $.each(response.files, function(i, file) {
                    addIndexEntry(indexWrapper, i);
                    var caption = file.caption.substr(0, file.caption.indexOf("."));
                    addSlide(slidesWrapper, file.url, caption);
                });

                indexWrapper.children(":first").addClass('active');
                slidesWrapper.children(":first").addClass('active');
                carousel.removeClass('hidden');
                overlay.removeClass('hidden');

                overlay.find('.close').click(function() {
                    carousel.addClass('hidden');
                    overlay.addClass(('hidden'));
                })
            }
        });
    });



    /**
     * carousel in full height or ending above footer when the footer is inside of the view port
     */
    var resizeCarousel = function() {
        var viewportBottom  = $(window).scrollTop() + $(window).height(),
            docBottom       = $(document).height(),
            bottom          = 0;

        if      (viewportBottom <= docBottom-50)    bottom = 0;
        else if (viewportBottom == docBottom)       bottom = 50;
        else                                        bottom = 50 -(docBottom-viewportBottom);

        overlay.css('bottom', bottom + "px");
    };

    // bottom depends on footer's visibility
    $(window).resize(resizeCarousel).scroll(resizeCarousel);
});
