jQuery(document).ready(function($) {
		var da11y = window._da11y || {};
		var labels = da11y.control_labels || {
			close_search: 'Close search',
			open_search: 'Open search',
			open_site_search: 'Open site search',
			search: 'Search',
			search_for: 'Search for...',
			view_cart: 'View cart'
		};

		function isNativelyInteractive(element) {
			return $(element).is('a, button, input, select, textarea');
		}

		function ensureSearchLabel($field, idPrefix, includeSubmit) {
			var id = $field.attr('id');

			if (!id) {
				id = idPrefix;
				$field.attr('id', id);
			}

			if (!$field.prevAll('label[for="' + id + '"]').length) {
				$field.before('<label class="da11y-screen-reader-text" for="' + id + '">' + labels.search_for + '</label>');
			}

			if (includeSubmit && !$field.siblings('button.da11y-screen-reader-text[type="submit"]').length) {
				$field.after('<button type="submit" class="da11y-screen-reader-text">' + labels.search + '</button>');
			}
		}

		function setControlLabel(selector, label, role) {
			$(selector).each(function() {
				var $control = $(this);

				$control.attr('aria-label', label);

				if (role) {
					$control.attr('role', role);
				}

				if (!isNativelyInteractive(this)) {
					$control.attr({
						'tabindex': '0',
						'data-da11y-keyboard-activate': 'true'
					});
				}
			});
		}

	/**
	 * Add unique ID to search module input with matching label.
	 *
	 * @divi-module  Search
	 */
	$('.et-search-field').each(function (e) {
		ensureSearchLabel($(this), 'et_pb_search_module_input_' + e, true);
	});

	/**
	 * Add unique ID to search module input with matching label.
	 *
	 * @divi-module  Search
	 */
	$('.et_pb_s').each(function (e) {
		ensureSearchLabel($(this), 'et_pb_s_module_input_' + e, false);
	});

	setControlLabel('#et_search_icon', labels.open_search, 'button');
	setControlLabel('.et_pb_menu__icon.et_pb_menu__search-button', labels.open_site_search || labels.open_search, 'button');
	setControlLabel('.et_close_search_field, .et_pb_menu__icon.et_pb_menu__close-search-button', labels.close_search, 'button');
	setControlLabel('.et-cart-info, .et_pb_menu__icon.et_pb_menu__cart-button', labels.view_cart, 'link');

	$(document).on('keydown', '[data-da11y-keyboard-activate="true"]', function(event) {
		if (13 !== event.which && 32 !== event.which) {
			return;
		}

		event.preventDefault();
		$(this).trigger('click');
	});

	/**
	 * Add unique ID to contact module input with matching label.
	 *
	 * @divi-module  Contact
	 */
	$('.et_pb_contact_form').each(function () {
		$(this).find('.et_pb_contact_captcha_question').parent().wrap('<label></label>');
	});

	/**
	* Correct labels on social media icons
	*/
	$('.et-social-facebook a.icon span').text('Facebook');
	$('.et-social-twitter a.icon span').text('X');
	$('.et-social-google-plus a.icon span').text('Google Plus');
	$('.et-social-pinterest a.icon span').text('Pinterest');
	$('.et-social-linkedin a.icon span').text('LinkedIn');
	$('.et-social-tumblr a.icon span').text('Tumblr');
	$('.et-social-instagram a.icon span').text('Instagram');
	$('.et-social-skype a.icon span').text('Skype');
	$('.et-social-flikr a.icon span').text('Flickr');
	$('.et-social-myspace a.icon span').text('Myspace');
	$('.et-social-dribbble a.icon span').text('Dribble');
	$('.et-social-youtube a.icon span').text('YouTube');
	$('.et-social-vimeo a.icon span').text('Vimeo');
	$('.et-social-rss a.icon span').text('RSS');

});
