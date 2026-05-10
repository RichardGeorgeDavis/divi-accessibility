jQuery(document).ready(function($) {

	/**
	 * Add aria-hidden="true" to decorative Divi icons.
	 */
	$('.et_pb_main_blurb_image').each(function() {
		var $image = $(this);

		if ($image.children('a').length > 0) {
			return;
		}

		$image.attr('aria-hidden', 'true');
	});

});
