jQuery(document).ready(function($) {
	var hiddenSelector = '#top-header, #main-content, #et-main-area, #main-footer, .et-l--body, .et-l--footer';
	var menuControlSelector = '.mobile_menu_bar, .mobile_menu_bar_toggle, .dipi_hamburger';
	var mobileMenuSelector = '#et_mobile_nav_menu, .et_mobile_nav_menu';
	var openMenuSelector = '.mobile_nav.opened, .dipi_hamburger.is-active';

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

	function prepareMenuControls() {
		$(menuControlSelector).attr({'role': 'button', 'aria-label': 'Menu', 'tabindex': 0});
	}

	function isMobileMenuOpen() {
		return $(openMenuSelector).length > 0;
	}

	function syncMobileMenuState() {
		var isOpen = isMobileMenuOpen();

		prepareMenuControls();

		$(menuControlSelector)
			.toggleClass('a11y-mobile-menu-open', isOpen)
			.attr('aria-expanded', isOpen ? 'true' : 'false');

		setPageContentHidden(isOpen);
	}

	function syncMobileMenuStateAfterToggle() {
		window.setTimeout(syncMobileMenuState, 0);
		window.setTimeout(syncMobileMenuState, 50);
		window.setTimeout(syncMobileMenuState, 250);
		window.setTimeout(syncMobileMenuState, 750);
	}

	function observeMobileMenuStateChanges() {
		if (!window.MutationObserver || !document.body) {
			return;
		}

		new MutationObserver(function(mutations) {
			var shouldSync = mutations.some(function(mutation) {
				return $(mutation.target).is('.mobile_nav, .mobile_menu_bar, .dipi_hamburger');
			});

			if (shouldSync) {
				window.setTimeout(syncMobileMenuState, 0);
			}
		}).observe(document.body, {
			attributes: true,
			attributeFilter: ['class'],
			subtree: true
		});
	}

	/**
	 * Mobile menu Aria support.
	 */
	prepareMenuControls();
	$(document).on('click', menuControlSelector, syncMobileMenuStateAfterToggle);
	$(document).on('click', '.et_mobile_menu a', syncMobileMenuStateAfterToggle);
	observeMobileMenuStateChanges();

	/**
	* Allows mobile menu to be opened with keyboard.
	*/
	$(document).on('keydown', menuControlSelector, function(event) {
		if (event.keyCode === 13 || event.keyCode === 32) {
			event.preventDefault();
		}
	});

	$(document).on('keyup', menuControlSelector, function(event) {
		if (event.keyCode === 13 || event.keyCode === 32) {
			event.preventDefault();
			$(this).click();
		}
	});

	/**
	* Allows mobile menu to be closed with keyboard.
	*/
	$(document).keyup(function(event) {
		if (event.keyCode === 27) {
			if($(mobileMenuSelector + ' .mobile_nav').hasClass('opened')) {
				$('.mobile_menu_bar').click();
				syncMobileMenuStateAfterToggle();
			}
		}
	});

	/**
	* Closes mobile menu when it loses focus.
	*/
	$(this).on('focusin', function () {
		if($(mobileMenuSelector + ' .mobile_nav').hasClass('opened')) {
			if(!$(mobileMenuSelector + ' .et_mobile_menu :focus').length) {
				$(mobileMenuSelector + ' .mobile_menu_bar').click();
				syncMobileMenuStateAfterToggle();
			}
		}
	});

	syncMobileMenuState();

});
