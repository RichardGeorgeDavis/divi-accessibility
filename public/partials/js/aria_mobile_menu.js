jQuery(document).ready(function($) {
	var hiddenSelector = '#top-header, #main-content, #main-footer, .et-l--body, .et-l--footer';

	function setManagedAriaHidden($elements, hidden) {
		$elements.each(function() {
			var $element = $(this);

			if (hidden) {
				if (!$element.attr('data-da11y-mobile-menu-managed')) {
					var previous = $element.attr('aria-hidden');

					if (typeof previous !== 'undefined') {
						$element.attr('data-da11y-mobile-menu-prev-aria-hidden', previous);
					}

					$element.attr('data-da11y-mobile-menu-managed', 'true');
				}

				$element.attr('aria-hidden', 'true');
				return;
			}

			if (!$element.attr('data-da11y-mobile-menu-managed')) {
				return;
			}

			if ($element.is('[data-da11y-mobile-menu-prev-aria-hidden]')) {
				$element.attr('aria-hidden', $element.attr('data-da11y-mobile-menu-prev-aria-hidden'));
				$element.removeAttr('data-da11y-mobile-menu-prev-aria-hidden');
			} else {
				$element.removeAttr('aria-hidden');
			}

			$element.removeAttr('data-da11y-mobile-menu-managed');
		});
	}

	function setPageContentHidden(isOpen) {
		setManagedAriaHidden($(hiddenSelector), isOpen);
	}

	/**
	 * Mobile menu Aria support.
	 */
	$('.mobile_menu_bar').attr({'role': 'button', 'aria-expanded': 'false', 'aria-label': 'Menu', 'tabindex': 0});
	$('.mobile_menu_bar').on('click', function() {
		if($(this).hasClass('a11y-mobile-menu-open') ) {
			$(this).removeClass('a11y-mobile-menu-open').attr('aria-expanded', 'false');
			setPageContentHidden(false);
		} else {
			$(this).addClass('a11y-mobile-menu-open').attr('aria-expanded', 'true');
			setPageContentHidden(true);
		}
	});

	/**
	* Allows mobile menu to be opened with keyboard.
	*/
	$('.mobile_menu_bar').keyup(function(event) {
		if (event.keyCode === 13 || event.keyCode === 32) {
			$(this).click();
		}
	});

	/**
	* Allows mobile menu to be closed with keyboard.
	*/
	$(document).keyup(function(event) {
		if (event.keyCode === 27) {
			if($('#et_mobile_nav_menu .mobile_nav').hasClass('opened')) {
				$('.mobile_menu_bar').click();
			}
		}
	});

	/**
	* Closes mobile menu when it loses focus.
	*/
	$(this).on('focusin', function () {
		if($('#et_mobile_nav_menu .mobile_nav').hasClass('opened')) {
			if(!$('#et_mobile_nav_menu .et_mobile_menu :focus').length) {
				$('#et_mobile_nav_menu .mobile_menu_bar').click();
			}
		}
	});

	setPageContentHidden(false);

});
