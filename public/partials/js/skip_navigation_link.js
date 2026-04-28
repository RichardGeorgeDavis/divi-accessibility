jQuery(document).ready(function($) {
	const da11y = (window || {})._da11y || {};
	const fallbackText = da11y.skip_navigation_link_text || 'Skip to content';
	const defaultLinks = [
		{
			name: 'content',
			enabled: true,
			text: fallbackText,
			target: '#main-content, #et-main-area'
		}
	];
	const skipLinks = Array.isArray(da11y.skip_links) ? da11y.skip_links : defaultLinks;

	/**
	 * Find the first element matched by a comma-separated selector list.
	 */
	function findTarget(selectorList) {
		const selectors = (selectorList || '').split(',');

		for (let i = 0; i < selectors.length; i++) {
			const selector = selectors[i].trim();

			if (!selector) {
				continue;
			}

			try {
				const $target = $(selector).first();

				if ($target.length) {
					return $target;
				}
			} catch (error) {
				void error;
				continue;
			}
		}

		return $();
	}

	function isFocusable($target) {
		return $target.is('a[href], button, input, select, textarea, [tabindex]');
	}

	function getTargetId($target, name, index) {
		let id = $target.attr('id');

		if (!id) {
			id = 'da11y-skip-target-' + name + '-' + index;
			$target.attr('id', id);
		}

		return id;
	}

	function makeFocusable($target) {
		if (!isFocusable($target)) {
			$target.attr('tabindex', -1);
		}
	}

	function createSkipLink(link, index) {
		const $target = findTarget(link.target);

		if (!link.enabled || !link.text || !$target.length) {
			return null;
		}

		const id = getTargetId($target, link.name || 'link', index);
		const $skipLink = $('<a/>', {
			href: '#' + id,
			class: 'skip-link da11y-screen-reader-text'
		}).text(link.text);

		makeFocusable($target);

		return $skipLink;
	}

	for (let i = skipLinks.length - 1; i >= 0; i--) {
		const $skipLink = createSkipLink(skipLinks[i], i);

		if ($skipLink) {
			$('body').prepend($skipLink);
		}
	}

	/**
	 * Use js to focus for internal links.
	 */
	$('a[href^="#"]').click(function () {
		const content = $('#' + $(this).attr('href').slice(1));

		if (content.length) {
			content.focus();
		}
	});

});
