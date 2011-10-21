$(document).ready(function() {
$('#videos img').load(function() {
	$('#videos img').each(function(i) {
		var height = $(this).height();
		if(height<139&&height>100) {
			var margin=(140-height)/2;
			$(this).css('marginTop',margin);
		}
		else if(height<=0.1) {
			var path = $(this).attr('src');
			var imag = new Image();
			var width;
			imag.src = path;
			imag.onload = function() {
				width = imag.width;
				height = imag.height;
				var factor = width/187;
				height = height * factor;
				var margin = (140-height)/2;
				$(this).css('marginTop',margin);
			};
		}
	});
});
});