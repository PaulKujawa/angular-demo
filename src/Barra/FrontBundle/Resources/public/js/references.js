/**
 * details on hover just for large displays (2x2 grid)
 */
$(function() {
    var wrapper     = $(".reference");

    if ( $(window).width() >= 992 ) {
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
                '<div class="carousel-caption fontXL">'+caption+'</div>' +
            '</div>');
    };

    var carousel                = $("#carousel-reference"),
        carouselIndexWrapper    = carousel.find(".carousel-indicators"),
        carouselSlidesWrapper   = carousel.find(".carousel-inner"),
        references              = $('.reference'),
        overlay                 = $('.overlay'),
        section                 = $('section');


    carousel.carousel({interval: 2500});


    references.click(function() {
        var url = carousel.data('url').slice(0, -1) + $(this).data("referenceid");

        $.ajax({
            url: url,
            type: "POST"
        }).done(function(response) {
            if (response.files.length > 0) {
                carouselIndexWrapper.empty(); carouselSlidesWrapper.empty();

                $.each(response.files, function(i, file) {
                    addIndexEntry(carouselIndexWrapper, i);
                    var caption = file.caption.substr(0, file.caption.indexOf("."));
                    addSlide(carouselSlidesWrapper, file.url, caption);
                });

                carouselIndexWrapper.children(":first").addClass('active');
                carouselSlidesWrapper.children(":first").addClass('active');
                overlay.removeClass('hidden');

                $(document).on('keyup.escape', function(e) {
                    if (e.keyCode == 27) { // ESC
                        overlay.addClass('hidden');
                        $(document).off('keyup.escape');
                    }
                });
            }
        });
    });


    overlay.find('.close').click(function() {
        overlay.addClass('hidden');
        $(document).off('keyup.escape');
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
