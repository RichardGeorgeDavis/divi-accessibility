jQuery(document).ready(function($) {
	const da11y = (window || {})._da11y || {};
	const criticalStyleId = 'da11y-skip-link-critical-css';
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

	function injectCriticalStyles() {
		if (document.getElementById(criticalStyleId)) {
			return;
		}

		const style = document.createElement('style');
		const target = document.head || document.body;

		if (!target) {
			return;
		}

		style.id = criticalStyleId;
		style.textContent = [
			'.skip-link.da11y-screen-reader-text,.skip-link[data-da11y-skip-link]{clip:rect(1px,1px,1px,1px);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;font-size:1em;font-weight:600;height:1px;letter-spacing:normal;line-height:normal;overflow:hidden;position:absolute!important;text-shadow:none;text-transform:none;width:1px;-webkit-font-smoothing:subpixel-antialiased;}',
			'.skip-link.da11y-screen-reader-text:active,.skip-link.da11y-screen-reader-text:focus,.skip-link[data-da11y-skip-link]:active,.skip-link[data-da11y-skip-link]:focus{background:#f1f1f1;-webkit-box-shadow:0 0 2px 2px rgba(0,0,0,.6);box-shadow:0 0 2px 2px rgba(0,0,0,.6);color:#00547A;clip:auto!important;display:block;height:auto;left:5px;padding:15px 23px 14px;text-decoration:none;top:7px;width:auto;z-index:1000000;}'
		].join('');
		target.appendChild(style);
	}

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

	function getLinkName(link) {
		return link.name || 'link';
	}

	function hasSkipLink(name) {
		return $('.skip-link[data-da11y-skip-link]').filter(function() {
			return $(this).attr('data-da11y-skip-link') === name;
		}).length > 0;
	}

	function createSkipLink(link, index) {
		const name = getLinkName(link);

		if (hasSkipLink(name)) {
			return null;
		}

		const $target = findTarget(link.target);

		if (!link.enabled || !link.text || !$target.length) {
			return null;
		}

		const id = getTargetId($target, name, index);
		const $skipLink = $('<a/>', {
			href: '#' + id,
			class: 'skip-link da11y-screen-reader-text',
			'data-da11y-skip-link': name
		}).text(link.text);

		makeFocusable($target);

		return $skipLink;
	}

	injectCriticalStyles();

	for (let i = skipLinks.length - 1; i >= 0; i--) {
		const $skipLink = createSkipLink(skipLinks[i], i);

		if ($skipLink) {
			$('body').prepend($skipLink);
		}
	}

	/**
	 * Use js to focus for internal links.
	 */
	$(document).off('click.da11ySkipLink', 'a[href^="#"]').on('click.da11ySkipLink', 'a[href^="#"]', function () {
		const content = $('#' + $(this).attr('href').slice(1));

		if (content.length) {
			content.focus();
		}
	});

});
