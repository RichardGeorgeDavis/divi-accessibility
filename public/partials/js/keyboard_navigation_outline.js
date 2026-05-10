jQuery(document).ready(function($) {

	let lastKey = new Date();
	let lastClick = new Date();
	var outlineColor = (window._da11y && window._da11y.active_outline_color) || '';

	function applyOutlineColor($element) {
		if (outlineColor) {
			$element.css('outline-color', outlineColor);
		}
	}

	/**
	 * Only apply focus styles for keyboard usage.
	 */
	$(this).on('focusin', function (e) {
		$('.keyboard-outline').removeClass('keyboard-outline');
		const wasByKeyboard = lastClick < lastKey;
		if (wasByKeyboard) {
			applyOutlineColor($(e.target).addClass('keyboard-outline'));
		}
	});

	$(this).on('mousedown', function () {
		lastClick = new Date();
	});

	$(this).on('keydown', function () {
		lastKey = new Date();
	});

});
