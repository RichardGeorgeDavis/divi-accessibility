(function ($) {

	function setSwitchState($input) {
		var checked = $input.prop('checked');
		var $switch = $input.siblings('.hurkanSwitch');
		var $switchBox = $switch.find('.hurkanSwitch-switch-box');
		var activeSelector = checked ? '.hurkanSwitch-switch-item-status-on' : '.hurkanSwitch-switch-item-status-off';

		$switch.find('.hurkanSwitch-switch-item').removeClass('active');
		$switch.find(activeSelector).addClass('active');
		$switchBox.attr('aria-checked', checked ? 'true' : 'false');
	}

	$(function() {
		$('.da11y-color-picker').wpColorPicker();

		$('.da11y-hurkan-switch .hurkanSwitch-switch-input').each(function() {
			setSwitchState($(this));
		});

		$('.da11y-hurkan-switch .hurkanSwitch-switch-input').on('change', function() {
			setSwitchState($(this));
		});

		$('.da11y-hurkan-switch .hurkanSwitch-switch-box').on('click', function(event) {
			var $input = $(this).closest('.da11y-hurkan-switch').find('.hurkanSwitch-switch-input');

			event.preventDefault();

			if ($input.prop('disabled') || $input.prop('readonly')) {
				return;
			}

			$input.prop('checked', !$input.prop('checked')).trigger('change');
		}).on('keydown', function(event) {
			if (' ' !== event.key && 'Enter' !== event.key) {
				return;
			}

			event.preventDefault();
			$(this).trigger('click');
		});
	});

}(jQuery));
