( function() {
	var hooks = window.vendor && window.vendor.wp && window.vendor.wp.hooks;
	var i18n = window.vendor && window.vendor.wp && window.vendor.wp.i18n;

	if ( ! hooks || 'function' !== typeof hooks.addFilter ) {
		return;
	}

	var __ = i18n && 'function' === typeof i18n.__ ? i18n.__ : function( text ) {
		return text;
	};
	var group_slug = 'advancedAccessibility';
	var group_title = __( 'Accessibility Settings', 'divi-accessibility' );

	function ensureObject( value ) {
		return value && 'object' === typeof value ? value : {};
	}

	function buildToggleField( attrName, label, description, priority ) {
		return {
			groupType: 'group-item',
			item: {
				groupSlug: group_slug,
				attrName: attrName,
				label: label,
				description: description,
				category: 'configuration',
				priority: priority,
				render: true,
				features: {
					hover: false,
					sticky: false,
					responsive: false,
				},
				component: {
					type: 'field',
					name: 'divi/toggle',
				},
			},
		};
	}

	hooks.addFilter(
		'divi.moduleLibrary.moduleSettings.groups',
		'divi-accessibility/module-settings-groups',
		function( groups ) {
			groups = ensureObject( groups );

			if ( ! groups[ group_slug ] ) {
				groups[ group_slug ] = {
					panel: 'advanced',
					priority: 95,
					groupName: 'accessibility',
					component: {
						name: 'divi/composite',
						props: {
							groupLabel: group_title,
						},
					},
				};
			}

			return groups;
		}
	);

	hooks.addFilter(
		'divi.moduleLibrary.moduleAttributes',
		'divi-accessibility/module-attributes',
		function( attributes ) {
			attributes = ensureObject( attributes );
			attributes.accessibility = ensureObject( attributes.accessibility );
			attributes.accessibility.type = attributes.accessibility.type || 'object';
			attributes.accessibility.settings = ensureObject( attributes.accessibility.settings );
			attributes.accessibility.settings.advanced = ensureObject( attributes.accessibility.settings.advanced );

			if ( ! attributes.accessibility.settings.advanced.hideAriaElement ) {
				attributes.accessibility.settings.advanced.hideAriaElement = buildToggleField(
					'accessibility.advanced.hideAriaElement',
					__( 'Hide From Screen Readers', 'divi-accessibility' ),
					__( 'Hide this module from screen readers.', 'divi-accessibility' ),
					10
				);
			}

			if ( ! attributes.accessibility.settings.advanced.showForScreenReadersOnly ) {
				attributes.accessibility.settings.advanced.showForScreenReadersOnly = buildToggleField(
					'accessibility.advanced.showForScreenReadersOnly',
					__( 'Show For Screen Readers Only', 'divi-accessibility' ),
					__( 'Show this module for screen readers only.', 'divi-accessibility' ),
					20
				);
			}

			return attributes;
		}
	);

	hooks.addFilter(
		'divi.moduleLibrary.moduleDefaultAttributes',
		'divi-accessibility/module-default-attributes',
		function( defaultAttrs ) {
			defaultAttrs = ensureObject( defaultAttrs );
			defaultAttrs.accessibility = ensureObject( defaultAttrs.accessibility );
			defaultAttrs.accessibility.advanced = ensureObject( defaultAttrs.accessibility.advanced );

			if ( ! defaultAttrs.accessibility.advanced.hideAriaElement ) {
				defaultAttrs.accessibility.advanced.hideAriaElement = {
					desktop: {
						value: 'off',
					},
				};
			}

			if ( ! defaultAttrs.accessibility.advanced.showForScreenReadersOnly ) {
				defaultAttrs.accessibility.advanced.showForScreenReadersOnly = {
					desktop: {
						value: 'off',
					},
				};
			}

			return defaultAttrs;
		}
	);
}() );
