jQuery(document).ready(function($) {
	$('img[title]').each(function() {
		var $image = $(this);

		if (!$image.attr('data-da11y-original-title')) {
			$image.attr('data-da11y-original-title', $image.attr('title'));
		}

		$image.removeAttr('title');
	});
});
