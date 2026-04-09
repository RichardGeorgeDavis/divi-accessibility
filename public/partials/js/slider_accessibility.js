jQuery(document).ready(function($) {

	var sliderLabels = typeof _da11y !== 'undefined' && _da11y.slider_accessibility_labels
		? _da11y.slider_accessibility_labels
		: {};

	function isActivationKey(event) {
		return event.which === 13 || event.which === 32;
	}

	function getLabel(name, fallback) {
		return sliderLabels[name] || fallback;
	}

	function getSlideLabel(index) {
		return getLabel('go_to_slide', 'Go to slide %d').replace('%d', index + 1);
	}

	function setArrowSupport($arrows) {
		$arrows.each(function() {
			var $arrow = $(this);
			var isPrev = $arrow.hasClass('et-pb-arrow-prev');

			$arrow.attr({
				'role': 'button',
				'tabindex': 0,
				'aria-label': isPrev
					? getLabel('previous', 'Previous slide')
					: getLabel('next', 'Next slide')
			});
		});
	}

	function updateDotStates($dots) {
		$dots.each(function(index) {
			var $dot = $(this);
			var isActive = $dot.hasClass('et-pb-active-control') || $dot.parent().hasClass('et-pb-active-control');

			$dot.attr({
				'aria-label': getSlideLabel(index),
				'aria-current': isActive ? 'true' : 'false'
			});
		});
	}

	function setDotSupport($dots) {
		$dots.attr({
			'role': 'button',
			'tabindex': 0
		});

		updateDotStates($dots);
	}

	function refreshSliderSupport($slider) {
		setArrowSupport($slider.find('.et-pb-arrow-prev, .et-pb-arrow-next'));
		setDotSupport($slider.find('.et-pb-controllers a'));
	}

	function queueSliderRefresh($slider) {
		if (!$slider.length || $slider.data('da11y-slider-refresh-queued')) {
			return;
		}

		$slider.data('da11y-slider-refresh-queued', true);
		window.setTimeout(function() {
			refreshSliderSupport($slider);
			$slider.removeData('da11y-slider-refresh-queued');
		}, 100);
	}

	function observeSliderSupport($slider) {
		var slider = $slider.get(0);

		if (!slider || $slider.data('da11y-slider-observed')) {
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
				queueSliderRefresh($slider);
			}
		}).observe(slider, {
			childList: true,
			subtree: true,
			attributes: true,
			attributeFilter: ['class']
		});

		$slider.data('da11y-slider-observed', true);
	}

	function applySliderSupport() {
		$('.et_pb_slider, .et_pb_post_slider, .et_pb_video_slider').each(function() {
			var $slider = $(this);
			refreshSliderSupport($slider);
			observeSliderSupport($slider);
		});
	}

	$(document).on('keydown', '.et-pb-arrow-prev, .et-pb-arrow-next, .et-pb-controllers a', function(event) {
		if (event.which === 32) {
			event.preventDefault();
		}
	});

	$(document).on('keyup', '.et-pb-arrow-prev, .et-pb-arrow-next, .et-pb-controllers a', function(event) {
		if (isActivationKey(event)) {
			event.preventDefault();
			$(this).trigger('click');
		}
	});

	$(document).on('click', '.et-pb-arrow-prev, .et-pb-arrow-next, .et-pb-controllers a', function() {
		queueSliderRefresh($(this).closest('.et_pb_slider, .et_pb_post_slider, .et_pb_video_slider'));
	});

	applySliderSupport();
	$(window).on('load', applySliderSupport);
});
