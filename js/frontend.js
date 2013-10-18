window.onload = function(){ // inkl. img
	/* bildüberschrift nach oben holen */
	var index = $('#imageSliderInnerbox').children().length;
	$('#imageSlider p').css('z-index', index+1);
	
	
	$('#imageSliderInnerbox').cycle({
		timeout: 3000,
		pause: true,
		before: titel
	});
		
	function titel() {
		$('#imageSlider p').text( $('img', this).attr('alt') );
	}
	
	$('#imageSlider').show();
};