( function() {
	var hooks = window.vendor && window.vendor.wp && window.vendor.wp.hooks;
	var i18n = window.vendor && window.vendor.wp && window.vendor.wp.i18n;

	if ( ! hooks || 'function' !== typeof hooks.addFilter ) {
		return;
	}

	var __ = i18n && 'function' === typeof i18n.__ ? i18n.__ : function( text ) {
		return text;
	};
	var packageConfig = window.DiviAccessibilityD5ImageHelperConfigData || window.diviAccessibilityD5ImageHelperConfigData || {};
	var helperLabels = window.diviAccessibilityImageHelperLabels || packageConfig.diviAccessibilityImageHelperLabels || {};

	function label( key, fallback ) {
		return helperLabels[ key ] || __( fallback, 'divi-accessibility' );
	}

	function ensureObject( value ) {
		return value && 'object' === typeof value ? value : {};
	}

	function buildField( attrName, groupSlug, label, description, componentName, priority, defaultValue ) {
		var field = {
			groupSlug: groupSlug,
			attrName: attrName,
			label: label,
			description: description,
			render: true,
			priority: priority,
			features: {
				hover: false,
				sticky: false,
				responsive: false,
				preset: 'content',
			},
			component: {
				name: componentName,
				type: 'field',
			},
		};

		if ( typeof defaultValue !== 'undefined' ) {
			field.defaultAttr = {
				desktop: {
					value: defaultValue,
				},
			};
		}

		return field;
	}

	function buildGroupItem( groupSlug, componentName, label ) {
		return {
			groupType: 'group-item',
			item: {
				groupSlug: groupSlug,
				render: true,
				component: {
					name: componentName,
					type: 'group',
					props: {
						grouped: false,
						fieldLabel: label,
					},
				},
			},
		};
	}

	function getPath( object, path ) {
		var index;
		var value = object;

		for ( index = 0; index < path.length; index++ ) {
			if ( ! value || 'object' !== typeof value || ! Object.prototype.hasOwnProperty.call( value, path[ index ] ) ) {
				return undefined;
			}

			value = value[ path[ index ] ];
		}

		return value;
	}

	function getAttrValue( attrs, path, fallback ) {
		var value = getPath( attrs, path );

		if ( value && 'object' === typeof value ) {
			if ( value.desktop && 'object' === typeof value.desktop && 'undefined' !== typeof value.desktop.value ) {
				return value.desktop.value;
			}

			if ( 'undefined' !== typeof value.value ) {
				return value.value;
			}
		}

		return 'undefined' === typeof value || null === value ? fallback : value;
	}

	function trimString( value ) {
		if ( 'undefined' === typeof value || null === value ) {
			return '';
		}

		return String( value ).replace( /^\s+|\s+$/g, '' );
	}

	function stripHtml( value ) {
		var element;

		if ( 'undefined' === typeof document ) {
			return trimString( value );
		}

		element = document.createElement( 'div' );
		element.innerHTML = trimString( value );

		return element.textContent || element.innerText || '';
	}

	function isEnabled( value ) {
		if ( true === value || 1 === value ) {
			return true;
		}

		return -1 !== [ '1', 'on', 'true' ].indexOf( trimString( value ).toLowerCase() );
	}

	function normalizeAspectRatio( value ) {
		if ( value && 'object' === typeof value ) {
			value = value.aspectRatio;
		}

		value = trimString( value || 'none' ).replace( /\s/g, '' );

		return /^\d+\/\d+$/.test( value ) ? value : 'none';
	}

	function normalizeHeadingLevel( value ) {
		if ( value && 'object' === typeof value ) {
			value = value.headingLevel;
		}

		value = trimString( value || 'h2' ).toLowerCase();

		return -1 !== [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ].indexOf( value ) ? value : 'h2';
	}

	function getImageHelperMetadata( attrs ) {
		return {
			titleText: trimString( getAttrValue( attrs, [ 'imageMetadata', 'innerContent', 'titleText' ], '' ) ),
			captionText: trimString( getAttrValue( attrs, [ 'imageMetadata', 'innerContent', 'captionText' ], '' ) ),
			descriptionText: trimString( getAttrValue( attrs, [ 'imageMetadata', 'innerContent', 'descriptionText' ], '' ) ),
			titleHeading: normalizeHeadingLevel( getAttrValue( attrs, [ 'imageMetadata', 'decoration', 'titleFont', 'font' ], 'h2' ) ),
			showTitle: isEnabled( getAttrValue( attrs, [ 'imageMetadata', 'advanced', 'showTitle' ], 'off' ) ),
			showCaption: isEnabled( getAttrValue( attrs, [ 'imageMetadata', 'advanced', 'showCaption' ], 'off' ) ),
			showDescription: isEnabled( getAttrValue( attrs, [ 'imageMetadata', 'advanced', 'showDescription' ], 'off' ) ),
			aspectRatio: normalizeAspectRatio( getAttrValue( attrs, [ 'image', 'innerContent' ], 'none' ) ),
		};
	}

	function getImageMetadataElement( React, metadata ) {
		var children = [];

		if ( metadata.showTitle && metadata.titleText ) {
			children.push( React.createElement( metadata.titleHeading, {
				key: 'title',
				className: 'et_pb_image_title',
			}, stripHtml( metadata.titleText ) ) );
		}

		if ( metadata.showCaption && metadata.captionText ) {
			children.push( React.createElement( 'p', {
				key: 'caption',
				className: 'et_pb_image_caption',
			}, stripHtml( metadata.captionText ) ) );
		}

		if ( metadata.showDescription && metadata.descriptionText ) {
			children.push( React.createElement( 'div', {
				key: 'description',
				className: 'et_pb_image_description',
				dangerouslySetInnerHTML: {
					__html: metadata.descriptionText,
				},
			} ) );
		}

		if ( ! children.length ) {
			return null;
		}

		return React.createElement( 'div', {
			key: 'da11y-image-metadata',
			className: 'et_pb_image_metadata_container',
		}, children );
	}

	function getImageHelperStyleElements( React, moduleWrapper, params ) {
		var StyleContainer;
		var StyleDeclarations;
		var attrs;
		var decoration;
		var divi = window.divi || {};
		var elements = params && params.elements;
		var imageDecoration;
		var isEdited;
		var orderClass;
		var styles;

		if (
			! divi.module
			|| ! divi.styleLibrary
			|| ! elements
			|| 'function' !== typeof elements.style
		) {
			return [];
		}

		StyleContainer = divi.module.StyleContainer;
		StyleDeclarations = divi.styleLibrary.StyleDeclarations;

		if ( ! StyleContainer || ! StyleDeclarations ) {
			return [];
		}

		attrs = params.attrs || {};
		orderClass = elements.orderClass || elements.order_class || '';

		if ( ! orderClass ) {
			return [];
		}

		imageDecoration = getPath( attrs, [ 'image', 'innerContent' ] ) || {};
		decoration = getPath( attrs, [ 'imageMetadata', 'decoration' ] ) || {};
		isEdited = moduleWrapper && moduleWrapper.props && moduleWrapper.props.isEdited;

		function createDeclarations() {
			return new StyleDeclarations( {
				returnType: 'string',
				important: false,
			} );
		}

		styles = [
			React.createElement( StyleContainer, {
				key: 'da11y-image-helper-image-style',
				mode: 'builder',
				state: isEdited ? params.state : '',
				noStyleTag: false,
			}, elements.style( {
				attrName: 'image',
				styleProps: {
					advancedStyles: [
						{
							componentName: 'divi/common',
							props: {
								selector: orderClass + ' .et_pb_image_wrap',
								attr: imageDecoration,
								declarationFunction: function( styleParams ) {
									var aspect = normalizeAspectRatio( styleParams && styleParams.attrValue );
									var declarations = createDeclarations();

									if ( 'none' !== aspect ) {
										declarations.add( 'aspect-ratio', aspect );
										declarations.add( 'overflow', 'hidden' );
									} else {
										declarations.add( 'aspect-ratio', 'auto' );
									}

									return declarations.value();
								},
							},
						},
						{
							componentName: 'divi/common',
							props: {
								selector: orderClass + ' .et_pb_image_wrap img',
								attr: imageDecoration,
								declarationFunction: function( styleParams ) {
									var aspect = normalizeAspectRatio( styleParams && styleParams.attrValue );
									var declarations = createDeclarations();

									if ( 'none' !== aspect ) {
										declarations.add( 'width', '100%' );
										declarations.add( 'height', '100%' );
										declarations.add( 'object-fit', 'cover' );
									} else {
										declarations.add( 'width', 'auto' );
										declarations.add( 'height', 'auto' );
										declarations.add( 'object-fit', 'fill' );
									}

									return declarations.value();
								},
							},
						},
					],
				},
			} ) ),
			React.createElement( StyleContainer, {
				key: 'da11y-image-helper-metadata-style',
				mode: 'builder',
				state: isEdited ? params.state : '',
				noStyleTag: false,
			}, elements.style( {
				attrName: 'imageMetadata',
				styleProps: {
					advancedStyles: [
						{
							componentName: 'divi/common',
							props: {
								selector: orderClass + ' .et_pb_image_metadata_container',
								attr: decoration.showImageMetaAsOverlay || {},
								declarationFunction: function( styleParams ) {
									var declarations = createDeclarations();

									if ( isEnabled( styleParams && styleParams.attrValue ) ) {
										declarations.add( 'position', 'absolute' );
										declarations.add( 'top', '0' );
										declarations.add( 'left', '0' );
									} else {
										declarations.add( 'position', 'relative' );
										declarations.add( 'top', 'unset' );
										declarations.add( 'left', 'unset' );
									}

									return declarations.value();
								},
							},
						},
						{
							componentName: 'divi/background',
							props: {
								selector: orderClass + ' .et_pb_image_metadata_container',
								attr: decoration.containerBackground || {},
								important: false,
							},
						},
						{
							componentName: 'divi/spacing',
							props: {
								selector: orderClass + ' .et_pb_image_metadata_container',
								attr: decoration.containerSpacing || {},
								important: false,
							},
						},
						{
							componentName: 'divi/border',
							props: {
								selector: orderClass + ' .et_pb_image_metadata_container',
								attr: decoration.containerBorder || {},
								important: false,
							},
						},
						{
							componentName: 'divi/box-shadow',
							props: {
								selector: orderClass + ' .et_pb_image_metadata_container',
								attr: decoration.containerShadow || {},
								important: false,
							},
						},
						{
							componentName: 'divi/font',
							props: {
								selector: orderClass + ' .et_pb_image_title',
								attr: decoration.titleFont || {},
								important: false,
							},
						},
						{
							componentName: 'divi/font',
							props: {
								selector: orderClass + ' .et_pb_image_caption',
								attr: decoration.captionFont || {},
								important: false,
							},
						},
						{
							componentName: 'divi/font-body',
							props: {
								selector: orderClass + ' .et_pb_image_description',
								attr: decoration.descriptionFont || {},
								important: false,
							},
						},
					],
				},
			} ) ),
		];

		return styles;
	}

	function normalizeChildren( children ) {
		if ( Array.isArray( children ) ) {
			return children;
		}

		return 'undefined' === typeof children || null === children ? [] : [ children ];
	}

	hooks.addFilter(
		'divi.moduleLibrary.moduleSettings.groups.divi.image',
		'divi-accessibility/image-helper-groups',
		function( groups ) {
			groups = ensureObject( groups );

			if ( groups.contentImageLink ) {
				groups.contentImageLink.priority = 30;
			}
			if ( groups.advancedAttributes ) {
				groups.advancedAttributes.panel = 'content';
				groups.advancedAttributes.priority = 20;
			}

			groups.contentImageText = {
				groupName: 'contentImageText',
				panel: 'content',
				priority: 20,
				multiElements: true,
				component: {
					name: 'divi/composite',
					props: {
						groupLabel: label( 'image_text', 'Image Text' ),
					},
				},
			};

			groups.designImageTextContainer = {
				groupName: 'designImageTextContainer',
				panel: 'design',
				priority: 5,
				multiElements: true,
				component: {
					name: 'divi/composite',
					props: {
						groupLabel: label( 'image_text_container', 'Image Text Container' ),
						visible: function( data ) {
							var attrs = data && data.attrs ? data.attrs : {};
							var advanced = attrs.imageMetadata && attrs.imageMetadata.advanced ? attrs.imageMetadata.advanced : {};

							return 'on' === ( advanced.showTitle && advanced.showTitle.desktop ? advanced.showTitle.desktop.value : 'off' )
								|| 'on' === ( advanced.showCaption && advanced.showCaption.desktop ? advanced.showCaption.desktop.value : 'off' )
								|| 'on' === ( advanced.showDescription && advanced.showDescription.desktop ? advanced.showDescription.desktop.value : 'off' );
						},
					},
				},
			};

			groups.designImageTextTitle = {
				groupName: 'designImageTextTitle',
				panel: 'design',
				priority: 5,
				multiElements: true,
				component: {
					name: 'divi/composite',
					props: {
						groupLabel: label( 'image_text_title', 'Image Text Title' ),
						visible: function( data ) {
							var attrs = data && data.attrs ? data.attrs : {};
							var advanced = attrs.imageMetadata && attrs.imageMetadata.advanced ? attrs.imageMetadata.advanced : {};

							return 'on' === ( advanced.showTitle && advanced.showTitle.desktop ? advanced.showTitle.desktop.value : 'off' );
						},
					},
				},
			};

			groups.designImageTextCaption = {
				groupName: 'designImageTextCaption',
				panel: 'design',
				priority: 5,
				multiElements: true,
				component: {
					name: 'divi/composite',
					props: {
						groupLabel: label( 'image_text_caption', 'Image Text Caption' ),
						visible: function( data ) {
							var attrs = data && data.attrs ? data.attrs : {};
							var advanced = attrs.imageMetadata && attrs.imageMetadata.advanced ? attrs.imageMetadata.advanced : {};

							return 'on' === ( advanced.showCaption && advanced.showCaption.desktop ? advanced.showCaption.desktop.value : 'off' );
						},
					},
				},
			};

			groups.designImageTextDescription = {
				groupName: 'designImageTextDescription',
				panel: 'design',
				priority: 5,
				multiElements: true,
				component: {
					name: 'divi/composite',
					props: {
						groupLabel: label( 'image_text_description', 'Image Text Description' ),
						visible: function( data ) {
							var attrs = data && data.attrs ? data.attrs : {};
							var advanced = attrs.imageMetadata && attrs.imageMetadata.advanced ? attrs.imageMetadata.advanced : {};

							return 'on' === ( advanced.showDescription && advanced.showDescription.desktop ? advanced.showDescription.desktop.value : 'off' );
						},
					},
				},
			};

			return groups;
		}
	);

	hooks.addFilter(
		'divi.moduleLibrary.moduleAttributes.divi.image',
		'divi-accessibility/image-helper-attributes',
		function( attributes ) {
			var imageItems;

			attributes = ensureObject( attributes );
			attributes.image = ensureObject( attributes.image );
			attributes.image.settings = ensureObject( attributes.image.settings );
			attributes.image.settings.innerContent = ensureObject( attributes.image.settings.innerContent );
			attributes.image.settings.innerContent.items = ensureObject( attributes.image.settings.innerContent.items );
			imageItems = attributes.image.settings.innerContent.items;

			imageItems.aspectRatio = {
				groupSlug: 'contentImage',
				subName: 'aspectRatio',
				label: label( 'image_aspect_ratio', 'Image Aspect Ratio' ),
				description: label( 'image_aspect_ratio_desc', 'Set a frontend aspect ratio for this image.' ),
				render: true,
				priority: 10,
				component: {
					name: 'divi/select',
					type: 'field',
					props: {
						options: {
							none: {
								label: label( 'original_image_ratio', 'Original Image Ratio' ),
							},
							'1/1': {
								label: label( 'square_1_1', 'Square 1:1' ),
							},
							'16/9': {
								label: label( 'landscape_16_9', 'Landscape 16:9' ),
							},
							'4/3': {
								label: label( 'landscape_4_3', 'Landscape 4:3' ),
							},
							'3/2': {
								label: label( 'landscape_3_2', 'Landscape 3:2' ),
							},
							'9/16': {
								label: label( 'portrait_9_16', 'Portrait 9:16' ),
							},
							'3/4': {
								label: label( 'portrait_3_4', 'Portrait 3:4' ),
							},
							'2/3': {
								label: label( 'portrait_2_3', 'Portrait 2:3' ),
							},
						},
					},
				},
				defaultAttr: {
					desktop: {
						value: {
							aspectRatio: 'none',
						},
					},
					tablet: {
						value: {
							aspectRatio: 'none',
						},
					},
					phone: {
						value: {
							aspectRatio: 'none',
						},
					},
				},
			};

			attributes.imageMetadata = {
				type: 'object',
				selector: '{{selector}} .et_pb_image_metadata_container',
				settings: {
					innerContent: {
						groupType: 'group-items',
						items: {
							titleText: buildField(
								'imageMetadata.innerContent.titleText',
								'contentImageText',
								label( 'image_title_text', 'Image Title Text' ),
								label( 'image_title_text_desc', 'Visible title text to display with the image.' ),
								'divi/text',
								10,
								''
							),
							captionText: buildField(
								'imageMetadata.innerContent.captionText',
								'contentImageText',
								label( 'image_caption_text', 'Image Caption Text' ),
								label( 'image_caption_text_desc', 'Visible caption text to display with the image.' ),
								'divi/text',
								20,
								''
							),
							descriptionText: buildField(
								'imageMetadata.innerContent.descriptionText',
								'contentImageText',
								label( 'image_description_text', 'Image Description Text' ),
								label( 'image_description_text_desc', 'Visible description text to display with the image.' ),
								'divi/richtext',
								30,
								''
							),
						},
					},
					advanced: {
						groupType: 'group-items',
						items: {
							showTitle: buildField(
								'imageMetadata.advanced.showTitle',
								'contentImageText',
								label( 'show_image_title', 'Show Image Title' ),
								label( 'show_image_title_desc', 'Display the image title text on the frontend.' ),
								'divi/toggle',
								40,
								'off'
							),
							showCaption: buildField(
								'imageMetadata.advanced.showCaption',
								'contentImageText',
								label( 'show_image_caption', 'Show Image Caption' ),
								label( 'show_image_caption_desc', 'Display the image caption text on the frontend.' ),
								'divi/toggle',
								50,
								'off'
							),
							showDescription: buildField(
								'imageMetadata.advanced.showDescription',
								'contentImageText',
								label( 'show_image_description', 'Show Image Description' ),
								label( 'show_image_description_desc', 'Display the image description text on the frontend.' ),
								'divi/toggle',
								60,
								'off'
							),
						},
					},
					decoration: {
						groupType: 'group-items',
						items: {
							showImageMetaAsOverlay: {
								groupType: 'group-item',
								item: buildField(
									'imageMetadata.decoration.showImageMetaAsOverlay',
									'designImageTextContainer',
									label( 'use_text_overlay', 'Use Text Overlay' ),
									label( 'use_text_overlay_desc', 'Position image text over the image.' ),
									'divi/toggle',
									10,
									'off'
								),
							},
							containerBackground: buildGroupItem( 'designImageTextContainer', 'divi/background', label( 'container_background', 'Image Text Container Background' ) ),
							containerSpacing: buildGroupItem( 'designImageTextContainer', 'divi/spacing', label( 'container_spacing', 'Image Text Container Spacing' ) ),
							containerBorder: buildGroupItem( 'designImageTextContainer', 'divi/border', label( 'container_border', 'Image Text Container Border' ) ),
							containerShadow: buildGroupItem( 'designImageTextContainer', 'divi/box-shadow', label( 'container_shadow', 'Image Text Container Shadow' ) ),
							titleFont: buildGroupItem( 'designImageTextTitle', 'divi/font', label( 'title', 'Title' ) ),
							captionFont: buildGroupItem( 'designImageTextCaption', 'divi/font', label( 'caption', 'Caption' ) ),
							descriptionFont: buildGroupItem( 'designImageTextDescription', 'divi/font-body', label( 'description_font', 'Description Font' ) ),
						},
					},
				},
			};

			return attributes;
		}
	);

	hooks.addFilter(
		'divi.module.wrapper.render',
		'divi-accessibility/image-helper-wrapper',
		function( moduleWrapper, params ) {
			var React = window.React;
			var children;
			var metadata;
			var metadataElement;
			var styleElements;

			if (
				! React
				|| ! moduleWrapper
				|| ! moduleWrapper.props
				|| ! params
				|| 'divi/image' !== params.name
			) {
				return moduleWrapper;
			}

			metadata = getImageHelperMetadata( params.attrs || {} );
			metadataElement = getImageMetadataElement( React, metadata );
			styleElements = getImageHelperStyleElements( React, moduleWrapper, params );
			children = normalizeChildren( moduleWrapper.props.children );

			if ( metadataElement ) {
				children.push( metadataElement );
			}

			children = children.concat( styleElements );

			moduleWrapper.props.children = children;

			return moduleWrapper;
		}
	);
}() );
