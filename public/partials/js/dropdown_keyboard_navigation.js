jQuery(document).ready(function($) {
	var labels = (window._da11y && window._da11y.accessibility_labels) || {
		submenu: 'submenu'
	};
	labels.submenu = labels.submenu || 'submenu';

	$('.et-menu > li').on('focusout', function() {
		$(this).removeClass('et-hover');
	});
	if($('.menu-item-has-children > a').length ) {
		$('.menu-item-has-children > a').addClass('da11y-submenu');
		$('.menu-item-has-children > a').attr({
			'aria-expanded': 'false',
			'aria-haspopup': 'true'
		});
	}

	function setMenuExpanded($menuItem, expanded) {
		$menuItem.children('.da11y-submenu').attr('aria-expanded', expanded ? 'true' : 'false');
		$menuItem.children('.da11y-dropdown-toggle').attr('aria-expanded', expanded ? 'true' : 'false');
		$menuItem.toggleClass('et-hover', expanded);
		$menuItem.children('.sub-menu').toggleClass('da11y-submenu-show', expanded);
	}

	function closeSiblingMenus($menuItem) {
		$menuItem.siblings('.menu-item-has-children').each(function() {
			setMenuExpanded($(this), false);
		});
	}

	function addDropdownButtons() {
		if ($(window).width() <= 980) {
			return;
		}

		$('header li.menu-item.menu-item-has-children > a:not(.et_mobile_menu a), .et_pb_menu li.menu-item.menu-item-has-children > a:not(.et_mobile_menu a)').each(function() {
			var $link = $(this);
			var $menuItem = $link.parent();
			var label = $.trim($link.text()) || labels.submenu;

			if ($menuItem.children('.da11y-dropdown-toggle').length) {
				return;
			}

			$link.after($('<button/>', {
				type: 'button',
				class: 'da11y-dropdown-toggle',
				'aria-expanded': 'false',
				'aria-haspopup': 'true',
				'aria-label': label + ': ' + labels.submenu
			}));
		});
	}

	addDropdownButtons();

	$(document).on('mouseenter', '.menu-item.menu-item-has-children', function() {
		$(this).children('.da11y-dropdown-toggle, .da11y-submenu').attr('aria-expanded', 'true');
	});

	$(document).on('mouseleave', '.menu-item.menu-item-has-children', function() {
		$(this).children('.da11y-dropdown-toggle, .da11y-submenu').attr('aria-expanded', 'false');
	});

	$(document).on('click keydown', '.da11y-dropdown-toggle', function(event) {
		if ('keydown' === event.type && event.which !== 13 && event.which !== 32) {
			return;
		}

		var $button = $(this);
		var $menuItem = $button.parent('.menu-item-has-children');
		var isExpanded = 'true' === $button.attr('aria-expanded');

		event.preventDefault();
		closeSiblingMenus($menuItem);
		setMenuExpanded($menuItem, !isExpanded);
	});

	$('.menu-item a').on('focus', function() {
		var menuItem = $(this).parent();
		var menuParents = $(this).parents('.menu-item-has-children');

		if (menuItem.hasClass('menu-item-has-children')) {
			menuParents = menuParents.add(menuItem);
		}

		menuParents.each(function() {
			setMenuExpanded($(this), true);
		});
	});

	$('.menu-item-has-children a').on('focusout', function() {
		if( $(this).parent().not('.menu-item-has-children').is(':last-child') ) {
			$(this).parents('.menu-item-has-children').each(function() {
				setMenuExpanded($(this), false);
			});
		}
	});

	$('.menu-item-has-children a').keyup(function(event) {
		if (event.keyCode === 27) {
			var menuParent = $(this).parents('.menu-item-has-children').last();
			if(menuParent.length) {
				menuParent.children('a').focus();
				menuParent.find('.menu-item-has-children').addBack().each(function() {
					setMenuExpanded($(this), false);
				});
			}
		}
	});

	/**
	 * Generate search form styles.
	 *
	 * @since Divi v3.0.23
	 */
	function et_set_search_form_css() {
		const search_container = $('.et_search_form_container');
		const body = $('body');
		if (search_container.hasClass('et_pb_search_visible')) {
			const header_height = $('#main-header').innerHeight();
			const menu_width = $('#top-menu').width();
			const font_size = $('#top-menu li a').css('font-size');
			search_container.css({ height: header_height + 'px' });
			search_container.find('input').css('font-size', font_size);
			if (!body.hasClass('et_header_style_left')) {
				search_container.css('max-width', menu_width + 60);
			} else {
				search_container.find('form').css('max-width', menu_width + 60);
			}
		}
	}

	/**
	 * Show the search.
	 *
	 * @since Divi v3.0.23
	 */
	function show_search() {
		const search_container = $('.et_search_form_container');
		if (search_container.hasClass('et_pb_is_animating')) {
			return;
		}
		$('.et_menu_container').removeClass('et_pb_menu_visible et_pb_no_animation').addClass('et_pb_menu_hidden');
		search_container.removeClass('et_pb_search_form_hidden et_pb_no_animation').addClass('et_pb_search_visible et_pb_is_animating');
		setTimeout(function () {
			$('.et_menu_container').addClass('et_pb_no_animation');
			search_container.addClass('et_pb_no_animation').removeClass('et_pb_is_animating');
		}, 1000);
		search_container.find('input').focus();
		et_set_search_form_css();
	}

	/**
	 * Hide the search.
	 *
	 * @since Divi v3.0.23
	 */
	function hide_search() {
		if ($('.et_search_form_container').hasClass('et_pb_is_animating')) {
			return;
		}
		$('.et_menu_container').removeClass('et_pb_menu_hidden et_pb_no_animation').addClass('et_pb_menu_visible');
		$('.et_search_form_container').removeClass('et_pb_search_visible et_pb_no_animation').addClass('et_pb_search_form_hidden et_pb_is_animating');
		setTimeout(function () {
			$('.et_menu_container').addClass('et_pb_no_animation');
			$('.et_search_form_container').addClass('et_pb_no_animation').removeClass('et_pb_is_animating');
		}, 1000);
	}

	$(document)
		.off('focusin.da11ySearch focusout.da11ySearch', '.et-search-field')
		.on('focusin.da11ySearch', '.et-search-field', function () {
			show_search();
		})
		.on('focusout.da11ySearch', '.et-search-field', function () {
			hide_search();
		});

});
