jQuery(document).ready(function($) {
	const text = ( ( window || {} )._da11y || {} ).skip_navigation_link_text || false;

	/**
	 * Add skiplink to page.
	 */
	function skipTo(target) {
		const $target = $(target);

		if (!$target.length) {
			return;
		}

		const skiplink = '<a href="' + target + '" class="skip-link da11y-screen-reader-text">' + text + '</a>';
		$target.attr('tabindex', -1);
		$('body').prepend(skiplink);
	}

	const target = $('#main-content').length ? '#main-content' : '#et-main-area';
	skipTo(target);

	/**
	 * Use js to focus for internal links.
	 */
	$('a[href^="#"]').click(function () {
		const content = $('#' + $(this).attr('href').slice(1));
		content.focus();
	});

});
