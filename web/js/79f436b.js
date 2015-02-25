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

    wrapper.click(function() {
        console.log("large screenshots will be displayed");
    });
});