$(function() {				
	$('<img id="ajaxLoadIcon" src="img/ajax.gif">').appendTo('section');
	
	$(document)
		.ajaxStart(function() {
			$('#ajaxLoadIcon').show();
		})
		.ajaxStop(function() {
			$('#ajaxLoadIcon').hide();
		});
	
	
	$("#toolbarLikeBtn").click(function(event) {
		event.preventDefault();
		voting('+');
	});
	
	$("#toolbarDislikeBtn").click(function(event) {
		event.preventDefault();
		voting('-');
	});
		
	
		
	var voting = function(opinion){
		// GET_[$id] aus URL erhalten
		var url = document.URL;
		var url = url.substring(url.indexOf('id=')+3, url.length);
		if (url.indexOf('&') === -1)
			var id = url.substring(0, url.length); // kein weiterer param
		else
			var id = url.substring(0, Math.min(url.indexOf('&'), url.length));
	
		$.get(
			"includes/voting.php", {
				id: id,
				vote: opinion
				
			}, function(like) {
				like *= 1;
				var dislike = 100-like;
				
				$('#toolbarRatingDisplay').text(Math.round(like) + "%");
				$('#toolbarLikesline').width(like + "%");
				$('#toolbarDislikesline').width(dislike + "%");
			}
		);
	};
});