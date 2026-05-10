jQuery(document).ready(function($) {
		var da11y = window._da11y || {};
		var labels = da11y.control_labels || {
			close_search: 'Close search',
			open_search: 'Open search',
			open_site_search: 'Open site search',
			search: 'Search',
			search_form: 'Search form',
			menu_search_form: 'Menu search form',
			search_for: 'Search for...',
			view_cart: 'View cart'
		};
		var accessibilityLabels = da11y.accessibility_labels || {
			opens_in_new_tab: 'opens in a new tab',
			visit_our: 'Visit our',
			page: 'page',
			read_more_about: 'Read more about',
			video_play_button: 'Video play button',
			open_and_close_mobile_menu: 'Open and close mobile menu',
			audio_player: 'Audio player',
			by: 'by',
			of: 'of',
			back_to_top: 'Back to top'
		};
		labels.open_site_search = labels.open_site_search || labels.open_search || 'Open site search';
		labels.search_form = labels.search_form || 'Search form';
		labels.menu_search_form = labels.menu_search_form || 'Menu search form';
		accessibilityLabels.opens_in_new_tab = accessibilityLabels.opens_in_new_tab || 'opens in a new tab';
		accessibilityLabels.visit_our = accessibilityLabels.visit_our || 'Visit our';
		accessibilityLabels.page = accessibilityLabels.page || 'page';
		accessibilityLabels.read_more_about = accessibilityLabels.read_more_about || 'Read more about';
		accessibilityLabels.video_play_button = accessibilityLabels.video_play_button || 'Video play button';
		accessibilityLabels.open_and_close_mobile_menu = accessibilityLabels.open_and_close_mobile_menu || 'Open and close mobile menu';
		accessibilityLabels.audio_player = accessibilityLabels.audio_player || 'Audio player';
		accessibilityLabels.by = accessibilityLabels.by || 'by';
		accessibilityLabels.of = accessibilityLabels.of || 'of';
		accessibilityLabels.back_to_top = accessibilityLabels.back_to_top || 'Back to top';

		/**
	 * Add role="tabList".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs_controls').each(function () {
		$(this).attr('role', 'tablist');
	});

	/**
	 * Add role="presentation".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs_controls li').each(function () {
		$(this).attr('role', 'presentation');
	});

	/**
	 * Add role="tab".
	 *
	 * @divi-module  Tab
	 */
	 $('.et_pb_tabs_controls a').each(function () {
		$(this).attr({
			'role': 'tab',
		});
	});

	/**
	 * Add role="tabpanel".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tab').each(function () {
		$(this).attr('role', 'tabpanel');
	});

	/**
	 * Add initial state:
	 *
	 * aria-selected="false"
	 * aria-expanded="false"
	 * tabindex=-1
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs_controls li:not(.et_pb_tab_active) a').each(function () {
		$(this).attr({
			'aria-selected': 'false',
			'aria-expanded': 'false',
			tabindex: -1
		});
	});


	/**
	* Add initial state:
	*
	* aria-selected="true"
	* aria-expanded="true"
	* tabindex=-1
	*
	* @divi-module  Tab
	 */
	$('.et_pb_tabs_controls li.et_pb_tab_active a').each(function () {
		$(this).attr({
			'aria-selected': 'true',
			'aria-expanded': 'true',
			tabindex: 0
		});
	});


	// Add aria-haspopup="true" support to parent submenu links.
	$('li.menu-item-has-children > a').each(function () {
		$(this).attr({
			'aria-haspopup': 'true',
		});
	});

	// Add role="button" only to non-native clickable Divi controls.
	$('#et_search_icon, .et_close_search_field, #et_mobile_nav_menu, .et_pb_video_play a').attr('role', 'button');

	//Add aria support to reCAPTCHA
	$('#g-recaptcha-response').each(function () {
		$(this).attr({
			'aria-hidden': 'true',
			'aria-label': 'do not use',
			'aria-readonly': 'true',
		});
	});

	/**
	 * Add unique ID to tab controls.
	 * Add aria-controls="x".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs_controls a').each(function (e) {
		$(this).attr({
			id: 'et_pb_tab_control_' + e,
			'aria-controls': 'et_pb_tab_panel_' + e
		});
	});

	/**
	 * Add unique ID to tab panels.
	 * Add aria-labelledby="x".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tab').each(function (e) {
		$(this).attr({
			id: 'et_pb_tab_panel_' + e,
			'aria-labelledby': 'et_pb_tab_control_' + e
		});
	});

	/**
	 * Set initial inactive tab panels to aria-hidden="false".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tab.et_pb_active_content').each(function () {
		$(this).attr('aria-hidden', 'false');
	});

	/**
	 * Set initial inactive tab panels to aria-hidden="true".
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tab:not(.et_pb_active_content)').each(function () {
		$(this).attr('aria-hidden', 'true');
	});

	/**
	 * Add unique ID to tab module.
	 * Need to use data attribute because a regular ID somehow interferes with Divi.
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs').each(function (e) {
		$(this).attr('data-da11y-id', 'et_pb_tab_module_' + e);
	});

	/**
	 * Update aria-selected attribute when tab is clicked or when hitting enter while focused.
	 *
	 * @divi-module  Tab
	 */
	$('.et_pb_tabs_controls a').on('click', function () {
		const id = $(this).attr('id');
		const namespace = $(this).closest('.et_pb_tabs').attr('data-da11y-id'); // Used as a selector to scope changes to current module.
		// Reset all tab controls to be aria-selected="false" & aria-expanded="false".
		$('[data-da11y-id="' + namespace + '"] .et_pb_tabs_controls a').attr({
			'aria-selected': 'false',
			'aria-expanded': 'false',
			tabindex: -1
		});
		// Make active tab control aria-selected="true" & aria-expanded="true".
		$(this).attr({
			'aria-selected': 'true',
			'aria-expanded': 'true',
			tabindex: 0
		});
		// Reset all tab panels inside the current tabs module.
		$('[data-da11y-id="' + namespace + '"] .et_pb_tab').attr('aria-hidden', 'true');
		// Label active tab panel as aria-hidden="false".
		$('[aria-labelledby="' + id + '"]').attr('aria-hidden', 'false');
	});

	// Arrow navigation for tab modules
	$('.et_pb_tabs_controls a').keyup(function (e) {
		const namespace = $(this).closest('.et_pb_tabs').attr('data-da11y-id');
		const module = $('[data-da11y-id="' + namespace + '"]');
		if (e.which === 39) { // Right.
			const next = module.find('li.et_pb_tab_active').next();
			if (next.length > 0) {
				next.find('a').trigger('click');
			} else {
				module.find('li:first a').trigger('click');
			}
		} else if (e.which === 37) { // Left.
			const next = module.find('li.et_pb_tab_active').prev();
			if (next.length > 0) {
				next.find('a').trigger('click');
			} else {
				module.find('li:last a').trigger('click');
			}
		}
		$('.et_pb_tabs_controls a').removeClass('keyboard-outline');
		module.find('li.et_pb_tab_active a').addClass('keyboard-outline');
	});

	/**
	 * Add unique ID to search module.
	 * Need to use data attribute because a regular ID somehow interferes with Divi.
	 *
	 * @divi-module  Search
	 */
	$('.et_pb_search').each(function (e) {
		$(this).attr('data-da11y-id', 'et_pb_search_module_' + e);
	});

	/**
	 * Add aria-required="true" to inputs.
	 *
	 * @divi-module  Contact Form
	 */
	$('[data-required_mark="required"]').each(function () {
		$(this).attr('aria-required', 'true');
	});

	/**
	 * Hide hidden error field on contact form.
	 *
	 * @divi-module  Contact Form
	 */
	$('.et_pb_contactform_validate_field').attr('type', 'hidden');

	/**
	 * Add live region support to error and success contact form messages.
	 *
	 * @divi-module  Contact Form
	 */
	function setContactMessageLiveRegion($scope) {
		$scope.find('.et-pb-contact-message').addBack('.et-pb-contact-message').attr({
			'role': 'alert',
			'aria-live': 'assertive',
			'aria-atomic': 'true',
			'tabindex': '-1'
		});
	}

	/**
	 * Keep validation states in sync with Divi's error classes.
	 *
	 * @divi-module  Contact Form
	 */
	function syncContactFieldValidationState($form) {
			$form.find('input, textarea, select').not('.et_pb_contactform_validate_field, [type="hidden"]').each(function() {
				var $field = $(this);
				var hasError = $field.hasClass('et_contact_error') || $field.closest('.et_pb_contact_field').hasClass('et_contact_error');
				$field.attr('aria-invalid', hasError ? 'true' : 'false');
			});

			$form.find('.et_pb_checkbox_handle').each(function() {
				var $handle = $(this);
				var $checkboxLabels = $handle.siblings('.et_pb_contact_field_options_wrapper').find('label[role="checkbox"]');
				var hasError = $handle.hasClass('et_contact_error') || $handle.closest('.et_pb_contact_field').hasClass('et_contact_error');
				$handle.attr('aria-invalid', hasError ? 'true' : 'false');
				$checkboxLabels.attr('aria-invalid', hasError ? 'true' : 'false');
			});
		}

		function syncContactCheckboxLabel(label) {
			var labelFor = label.getAttribute('for');
			var checkbox = labelFor ? document.getElementById(labelFor) : null;
			var $label = $(label);

			if (!checkbox || 'checkbox' !== checkbox.type) {
				return;
			}

			$label.attr({
				'aria-checked': checkbox.checked ? 'true' : 'false',
				'role': 'checkbox',
				'tabindex': '0'
			});

			if (checkbox.disabled) {
				$label.attr('aria-disabled', 'true');
			} else {
				$label.removeAttr('aria-disabled');
			}
		}

		function refreshContactCheckboxAccessibility($scope) {
			$scope.find('.et_pb_contact_form label[for], .et_pb_contact label[for]').addBack('.et_pb_contact_form label[for], .et_pb_contact label[for]').each(function() {
				syncContactCheckboxLabel(this);
			});
		}

		/**
		 * Refresh contact form accessibility after Divi updates the DOM.
	 *
	 * @divi-module  Contact Form
	 */
		function refreshContactFormAccessibility($scope) {
			refreshContactCheckboxAccessibility($scope);
			$scope.find('.et_pb_contact_form').addBack('.et_pb_contact_form').each(function() {
				syncContactFieldValidationState($(this));
			});
			setContactMessageLiveRegion($scope);
		}

	/**
	 * Observe async contact form updates so live regions and invalid states persist.
	 *
	 * @divi-module  Contact Form
	 */
	function observeContactFormAccessibility($scope) {
		var scope = $scope.get(0);

		if (!scope || $scope.data('da11y-contact-observed')) {
			return;
		}

		new MutationObserver(function(mutations) {
			var shouldRefresh = false;

			$.each(mutations, function(index, mutation) {
				if (mutation.type === 'childList' || mutation.attributeName === 'class') {
					shouldRefresh = true;
					return false;
				}
			});

			if (shouldRefresh) {
				refreshContactFormAccessibility($scope);
			}
		}).observe(scope, {
			childList: true,
			subtree: true,
			attributes: true,
			attributeFilter: ['class']
		});

		$scope.data('da11y-contact-observed', true);
	}

	refreshContactFormAccessibility($(document));
	$('.et_pb_contact, .et_pb_contact_form_container').each(function() {
		observeContactFormAccessibility($(this));
	});

	$(document).on('keydown', '.et_pb_contact_form label[role="checkbox"], .et_pb_contact label[role="checkbox"]', function(event) {
		var labelFor;
		var checkbox;

		if (13 !== event.which && 32 !== event.which) {
			return;
		}

		labelFor = this.getAttribute('for');
		checkbox = labelFor ? document.getElementById(labelFor) : null;

		if (!checkbox) {
			return;
		}

		event.preventDefault();
		checkbox.click();
		syncContactCheckboxLabel(this);
	});

	$(document).on('change', '.et_pb_contact_form input[type="checkbox"], .et_pb_contact input[type="checkbox"]', function() {
		var $label = $('label[for="' + this.id + '"]');

		if ($label.length) {
			syncContactCheckboxLabel($label.get(0));
		}
	});

	/**
	* Add main role to main-content
	*/
	const $mainContent = $('#main-content').length ? $('#main-content') : $('#et-main-area');
	$mainContent.first().attr('role', 'main');

	/**
	 * Add aria-label="x".
	 *
	 * @divi-module  Fullwidth header, comment-wrap
	 */
	$('.et_pb_fullwidth_header').each(function (e) {
		$(this).attr('aria-label', 'Wide Header' + e);
	});
	$('#comment-wrap').attr('aria-label', 'Comments');
	$('#et_search_icon, .et_pb_menu__icon.et_pb_menu__search-button').attr('aria-label', labels.open_search);
	$('.et_close_search_field, .et_pb_menu__icon.et_pb_menu__close-search-button').attr('aria-label', labels.close_search);
	$('.et-cart-info, .et_pb_menu__icon.et_pb_menu__cart-button').attr('aria-label', labels.view_cart);

	$('header form.et-search-form').attr('aria-label', labels.search_form);
	$('header form.et_pb_menu__search-form').attr('aria-label', labels.menu_search_form);
	$('.et_pb_module.et_pb_menu .et_mobile_nav_menu').attr({
		'aria-label': accessibilityLabels.open_and_close_mobile_menu,
		'role': 'button',
		'tabindex': 0
	});

	$('.et_pb_module.et_pb_menu .et_mobile_nav_menu').on('keydown', function(event) {
		if (event.which === 13 || event.which === 32) {
			event.preventDefault();
			$(this).find('.mobile_menu_bar').trigger('click');
		}
	});

	function normalizeSocialName(name) {
		name = $.trim(name || '').replace(/^et-social-/, '').replace(/^et_pb_social_icon_/, '');

		if ('twitter' === name.toLowerCase()) {
			return 'X';
		}

		return name.charAt(0).toUpperCase() + name.slice(1);
	}

	$('.et-social-icon').each(function() {
		var className = this.className || '';
		var match = className.match(/et-social-([A-Za-z0-9_-]+)/);
		var name = match ? normalizeSocialName(match[1]) : '';

		if (name) {
			$(this).find('a').attr('aria-label', accessibilityLabels.visit_our + ' ' + name + ' ' + accessibilityLabels.page);
		}
	});

	$('.et_pb_social_icon > a.icon').each(function() {
		var title = normalizeSocialName($(this).attr('title'));

		if (title) {
			$(this).attr('aria-label', accessibilityLabels.visit_our + ' ' + title + ' ' + accessibilityLabels.page);
		}
	});

	$('.et_pb_module article.et_pb_post .post-content .more-link').each(function() {
		var $link = $(this);

		if ($.trim($link.text()).toLowerCase() !== 'read more') {
			return;
		}

		var title = $.trim($link.closest('article').find('.entry-title a, .entry-title').first().text());

		if (title) {
			$link.attr('aria-label', accessibilityLabels.read_more_about + ' ' + title);
		}
	});

	$('a.et_pb_video_play, .et_pb_video_play a').attr('aria-label', accessibilityLabels.video_play_button);

	$('.et_pb_module.et_pb_image a').has('img').each(function() {
		var $link = $(this);
		var $image = $link.find('img').first();
		var label = $.trim($image.attr('alt') || $image.attr('title') || '');
		var href = $link.attr('href') || '';

		if (!label && href && href.charAt(0) !== '#') {
			label = href.replace(/\/+$/, '').split('/').pop().replace(/[-_]/g, ' ');
		}

		if (label) {
			$link.attr('aria-label', label);
		}
	});

	$('a[target="_blank"]').each(function() {
		var $link = $(this);
		var currentLabel = $.trim($link.attr('aria-label') || $link.text() || $link.attr('title') || '');
		var suffix = '(' + accessibilityLabels.opens_in_new_tab + ')';

		if (!currentLabel) {
			currentLabel = 'link';
		}

		if (currentLabel.toLowerCase().indexOf(accessibilityLabels.opens_in_new_tab.toLowerCase()) === -1) {
			$link.attr('aria-label', currentLabel + ' ' + suffix);
		}
	});

	function formatTime(seconds) {
		var safeSeconds = !isNaN(seconds) && isFinite(seconds) ? seconds : 0;
		var minutes = Math.floor(safeSeconds / 60);
		var remainingSeconds = Math.floor(safeSeconds % 60);

		return minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
	}

	$('.mejs-container').each(function() {
		var $container = $(this);
		var title = $.trim($container.closest('.et_pb_audio_module').find('.et_pb_module_header').text());
		var artist = $.trim($container.closest('.et_pb_audio_module').find('.et_audio_module_meta strong').text());
		var label = accessibilityLabels.audio_player;

		if (title) {
			label += ': ' + title;
		}

		if (artist) {
			label += ' ' + accessibilityLabels.by + ' ' + artist;
		}

		$container.attr('aria-label', label);
	});

	$('audio.wp-audio-shortcode').on('timeupdate loadedmetadata', function() {
		var current = formatTime(this.currentTime);
		var duration = formatTime(this.duration);

		$(this).closest('.mejs-container').find('.mejs-time-slider').attr('aria-valuetext', current + ' ' + accessibilityLabels.of + ' ' + duration);
	});

	$('span.et_pb_scroll_top').attr({
		'role': 'button',
		'aria-label': accessibilityLabels.back_to_top,
		'tabindex': '0'
	}).on('keyup', function(event) {
		if (event.which !== 13 && event.which !== 32) {
			return;
		}

		event.preventDefault();
		$(this).trigger('click');
		setTimeout(function() {
			$('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])').filter(':visible').first().focus();
		}, 300);
	});

	/**
	 * Hide manually disabled ARIA elements
	 */
	$('.aria-hidden').each(function (index, element) {
		hideAriaElement(element);
	});

	function hideAriaElement(element) {
		const $element = $(element);
		$(element).attr('aria-hidden', 'true');

		for(const child of $element.children()){
			hideAriaElement(child);
		}
	}
});
