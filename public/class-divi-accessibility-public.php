<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://campuspress.com
 * @since      1.0.0
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/public
 */
class Divi_Accessibility_Public {

	const TYPE_JS  = 'js';
	const TYPE_CSS = 'css';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $da11y;

	/**
	 * The prefix for the plugins's options.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $da11y_options;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $version;

	/**
	 * The plugin settings.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @var       array
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $da11y          The name of this plugin.
	 * @param    string $da11y_options  The prefix for the plugin's options.
	 * @param    string $version        The version of this plugin.
	 * @param    array  $settings       The plugin settings.
	 */
	public function __construct( $da11y, $da11y_options, $version, $settings ) {

		$this->da11y         = $da11y;
		$this->da11y_options = $da11y_options;
		$this->version       = $version;
		$this->settings      = $settings;

	}

	/**
	 * Remove Divi viewport meta since we want to load our own.
	 *
	 * @since    1.0.2
	 */
	public function remove_divi_viewport_meta() {
		remove_action( 'wp_head', 'et_add_viewport_meta' );
	}

	/**
	 * Allow users to pinch and zoom divi theme.
	 *
	 * @since    1.0.2
	 */
	public function accessible_viewport_meta() {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />';
	}

	/**
	 * Enqueue and bootstrap the public facing resources.
	 */
	public function setup_scripts_and_styles() {
		wp_enqueue_script(
			'divi-accessibility-da11y',
			plugin_dir_url( __FILE__ ) . 'js/da11y.js',
			array( 'jquery' ),
			$this->version,
			true
		);
		wp_localize_script(
			'divi-accessibility-da11y',
			'_da11y',
			$this->get_public_data()
		);

		foreach ( $this->get_script_resources() as $name ) {
			$this->add_resource( 'divi-accessibility-da11y', $name, self::TYPE_JS );
		}

		$root_style = reset( wp_styles()->queue );
		foreach ( $this->get_style_resources() as $name ) {
			$this->add_resource( $root_style, $name, self::TYPE_CSS );
		}

		if ( true == $this->can_load_tota11y() ) {
			wp_enqueue_script(
				'divi-accessibility-tota11y',
				plugin_dir_url( __FILE__ ) . 'js/tota11y.min.js',
				array( 'jquery' ),
				$this->version,
				false
			);
		}
	}

	/**
	 * Gets public data exposed to enqueued JS resources
	 *
	 * @return array
	 */
	public function get_public_data() {
		$data         = array(
			'version' => $this->version,
		);
		$divi_version = $this->get_divi_major_version();
		if ( null !== $divi_version ) {
			$data['divi_version'] = $divi_version;
		}
		$defaults = Divi_Accessibility_Admin::get_options_list();
		if ( $this->is_in_developer_mode() ) {
			$data['options'] = array_merge(
				$defaults,
				(array) $this->settings
			);
		}
		if ( $this->can_load( 'keyboard_navigation_outline' ) ) {
			$data['active_outline_color'] = esc_js(
				isset( $this->settings['outline_color'] )
					? $this->settings['outline_color']
					: $defaults['outline_color']
			);
		}
		if ( $this->can_load( 'skip_navigation_link' ) ) {
			$settings = array_merge(
				$defaults,
				(array) $this->settings
			);

			$data['skip_navigation_link_text'] = sanitize_text_field( $settings['skip_link_content_text'] );
			$data['skip_links']                = array(
				array(
					'name'    => 'navigation',
					'enabled' => 1 === (int) $settings['skip_link_navigation_enabled'],
					'text'    => sanitize_text_field( $settings['skip_link_navigation_text'] ),
					'target'  => sanitize_text_field( $settings['skip_link_navigation_target'] ),
				),
				array(
					'name'    => 'content',
					'enabled' => 1 === (int) $settings['skip_link_content_enabled'],
					'text'    => sanitize_text_field( $settings['skip_link_content_text'] ),
					'target'  => sanitize_text_field( $settings['skip_link_content_target'] ),
				),
				array(
					'name'    => 'footer',
					'enabled' => 1 === (int) $settings['skip_link_footer_enabled'],
					'text'    => sanitize_text_field( $settings['skip_link_footer_text'] ),
					'target'  => sanitize_text_field( $settings['skip_link_footer_target'] ),
				),
			);
		}
		if ( $this->can_load( 'slider_accessibility' ) ) {
			$data['slider_accessibility_labels'] = array(
				'previous'    => __( 'Previous slide', 'divi-accessibility' ),
				'next'        => __( 'Next slide', 'divi-accessibility' ),
				'go_to_slide' => __( 'Go to slide %d', 'divi-accessibility' ),
			);
		}
		if ( $this->can_load( 'fix_labels' ) || $this->can_load( 'aria_support' ) ) {
			$data['control_labels'] = array(
				'close_search' => __( 'Close search', 'divi-accessibility' ),
				'open_search'  => __( 'Open search', 'divi-accessibility' ),
				'search'       => __( 'Search', 'divi-accessibility' ),
				'search_for'   => __( 'Search for...', 'divi-accessibility' ),
				'view_cart'    => __( 'View cart', 'divi-accessibility' ),
			);
		}
		return $data;
	}

	/**
	 * Returns a list of all known script resources
	 *
	 * @return array
	 */
	public function get_script_resources() {
		return array(
			'dropdown_keyboard_navigation',
			'slider_accessibility',
			'skip_navigation_link',
			'keyboard_navigation_outline',
			'focusable_modules',
			'fix_labels',
			'aria_support',
			'aria_hidden_icons',
			'aria_mobile_menu',
			'developer_mode',
		);
	}

	/**
	 * Returns a list of all known style resources
	 *
	 * @return array
	 */
	public function get_style_resources() {
		return array(
			'dropdown_keyboard_navigation',
			'divi_version_compat',
			'keyboard_navigation_outline',
			'reduced_motion',
			'screen_reader_text',
			'skip_navigation_link',
			'slider_accessibility',
			'underline_urls',
			'underline_urls_not_title',
		);
	}

	/**
	 * Detect active Divi major version.
	 *
	 * @return int|null
	 */
	public function get_divi_major_version() {
		$theme = wp_get_theme();

		if ( is_child_theme() ) {
			$parent = $theme->parent();
			if ( $parent ) {
				$theme = $parent;
			}
		}

		$name       = strtolower( (string) $theme->get( 'Name' ) );
		$stylesheet = strtolower( (string) $theme->get_stylesheet() );
		if ( ! in_array( $name, array( 'divi', 'extra' ), true ) && ! in_array( $stylesheet, array( 'divi', 'extra' ), true ) ) {
			return null;
		}

		$version = (string) $theme->get( 'Version' );
		$major   = (int) strtok( $version, '.' );

		if ( $major > 0 ) {
			return $major;
		}

		return 4;
	}

	/**
	 * Add body class for Divi major version targeting.
	 *
	 * @param array $classes Existing body classes.
	 * @return array
	 */
	public function add_divi_version_body_class( $classes ) {
		$version = $this->get_divi_major_version();
		if ( null !== $version ) {
			$classes[] = 'da11y-divi-' . $version;
		}
		return $classes;
	}

	/**
	 * Adds resource
	 *
	 * @param string $hook Resource parent.
	 * @param string $name Resource name.
	 * @param string $type Resource type (css|js).
	 */
	public function add_resource( $hook, $name, $type ) {
		if ( ! $this->can_load( $name ) ) {
			return false;
		}
		if ( self::TYPE_JS === $type ) {
			return $this->will_enqueue( $type )
				? wp_enqueue_script(
					"{$hook}-{$name}",
					$this->get_resource_url( $name, $type ),
					array( $hook ),
					$this->version,
					true
				)
				: wp_add_inline_script( $hook, $this->get_resource_data( $name, $type ) );
		}
		if ( self::TYPE_CSS === $type ) {
			return $this->will_enqueue( $type )
				? wp_enqueue_style(
					"{$hook}-{$name}",
					$this->get_resource_url( $name, $type ),
					array( $hook ),
					$this->version
				)
				: wp_add_inline_style( $hook, $this->get_resource_data( $name, $type ) );
		}
		return false;
	}

	/**
	 * Whether resources of certain type are to be be enqueued or loaded inline
	 *
	 * @param string $type Resource type (css|js).
	 *
	 * @return bool
	 */
	public function will_enqueue( $type ) {
		$enqueue = apply_filters( 'divi_accessibility_enqueue', false );
		return apply_filters(
			'divi_accessibility_enqueue_type',
			$enqueue,
			$type
		);
	}

	/**
	 * Load resource contents
	 *
	 * @param string $name Resource name.
	 * @param string $type Resource type (css|js).
	 *
	 * @return string
	 */
	public function get_resource_data( $name, $type ) {
		if ( ! $this->is_known_type( $type ) ) {
			return '';
		}
		$file = $this->get_resource_path( $name, $type );
		return is_readable( $file )
			? file_get_contents( $file )
			: '';
	}

	/**
	 * Gets resource FS path
	 *
	 * @param string $name Resource name.
	 * @param string $type Resource type (css|js).
	 *
	 * @return string
	 */
	public function get_resource_path( $name, $type ) {
		if ( ! $this->is_known_type( $type ) ) {
			return '';
		}
		$root     = trailingslashit( DA11Y_PATH ) . 'public/partials/' . $type;
		$debug    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		$minified = $this->is_in_developer_mode() || $debug
			? ''
			: '.min';
		return trailingslashit( $root ) .
			sanitize_file_name( $name ) .
			$minified .
			'.' . $type;
	}

	/**
	 * Gets resource URL
	 *
	 * @param string $name Resource name.
	 * @param string $type Resource type (css|js).
	 *
	 * @return string
	 */
	public function get_resource_url( $name, $type ) {
		if ( ! $this->is_known_type( $type ) ) {
			return '';
		}
		$root     = trailingslashit( plugin_dir_url( __FILE__ ) ) . 'partials/' . $type;
		$debug    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		$minified = $this->is_in_developer_mode() || $debug
			? ''
			: '.min';
		return trailingslashit( $root ) .
			sanitize_file_name( $name ) .
			$minified .
			'.' . $type;
	}

	/**
	 * Whether or not we're dealing with a known resource type.
	 *
	 * @param string $type Resource type.
	 *
	 * @return bool
	 */
	public function is_known_type( $type ) {
		return in_array(
			$type,
			array( self::TYPE_JS, self::TYPE_CSS ),
			true
		);
	}

	/**
	 * Whether or not we're in developer mode
	 *
	 * @return bool
	 */
	public function is_in_developer_mode() {
		return apply_filters(
			'divi_accessibility_developer_mode',
			current_user_can( 'manage_options' ) && $this->can_load( 'developer_mode' )
		);
	}

	/**
	 * Check if we have permission to load tota11y.
	 *
	 * @since     1.0.0
	 * @return    boolean
	 */
	public function can_load_tota11y() {

		$settings = $this->settings;
		$tota11y = false;

		if ( isset( $settings['tota11y'] ) ) {
			$tota11y = (bool) $settings['tota11y'];
		}

		if ( current_user_can( 'manage_options' ) && $tota11y ) {
			return true;
		}

		return false;

	}

	/**
	 * Check if we have permission to load a checkbox option.
	 *
	 * @since     1.0.0
	 * @param     string $option
	 * @return    boolean
	 */
	public function can_load( $option ) {

		if ( 'divi_version_compat' === $option ) {
			return null !== $this->get_divi_major_version();
		}

		$can_load = false;

		$settings = $this->settings;

		if ( isset( $settings[ $option ] ) && 1 == $settings[ $option ] ) {
			$can_load = true;
		}

		return apply_filters( 'divi_accessibility_can_load', $can_load, $option );

	}

	/**
	 * Prevent WordPress from adding a unique ID from menu list items.
	 * Because Divi uses js to build the mobile navigation menu from the main navigation links,
	 * unique ID's are cloned, causing issues with accessibility & validation.
	 *
	 * @since     1.2.0
	 */
	public function remove_duplicate_menu_ids() {

		if ( $this->can_load( 'fix_duplicate_menu_ids' ) ) {
			add_filter( 'nav_menu_item_id', '__return_null', 1000 );
		}

	}

	/**
	 * Get a nested module prop value.
	 *
	 * @param mixed $props Module props.
	 * @param array $path Path segments.
	 * @return mixed|null
	 */
	private function get_nested_module_prop( $props, array $path ) {
		$value = $props;

		foreach ( $path as $segment ) {
			if ( ! is_array( $value ) || ! array_key_exists( $segment, $value ) ) {
				return null;
			}

			$value = $value[ $segment ];
		}

		return $value;
	}

	/**
	 * Determine whether a module prop is enabled in D4 or D5 storage formats.
	 *
	 * @param array $props Module props.
	 * @param array $paths Candidate prop paths.
	 * @return bool
	 */
	private function module_prop_is_enabled( array $props, array $paths ) {
		foreach ( $paths as $path ) {
			if ( 'on' === $this->get_nested_module_prop( $props, $path ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the first non-empty string module prop value from D4 or D5 storage formats.
	 *
	 * @param array $props Module props.
	 * @param array $paths Candidate prop paths.
	 * @return string
	 */
	private function get_module_prop_string( array $props, array $paths ) {
		foreach ( $paths as $path ) {
			$value = $this->get_nested_module_prop( $props, $path );

			if ( is_scalar( $value ) ) {
				$value = trim( (string) $value );

				if ( '' !== $value ) {
					return $value;
				}
			}
		}

		return '';
	}

	/**
	 * Return the ARIA roles allowed by module accessibility fields.
	 *
	 * @return array
	 */
	private function get_allowed_module_aria_roles() {
		return array(
			'region',
			'complementary',
			'navigation',
			'list',
			'listitem',
			'button',
			'link',
			'dialog',
			'alertdialog',
			'presentation',
			'none',
		);
	}

	/**
	 * Sanitize a module role value against the plugin allowlist.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	private function sanitize_module_aria_role( $value ) {
		$value = sanitize_key( $value );

		if ( in_array( $value, $this->get_allowed_module_aria_roles(), true ) ) {
			return $value;
		}

		return '';
	}

	/**
	 * Sanitize a module text attribute value.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	private function sanitize_module_aria_text( $value ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize a space-separated ARIA ID reference list.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	private function sanitize_module_aria_idrefs( $value ) {
		$ids = preg_split( '/\s+/', $value );

		if ( ! is_array( $ids ) ) {
			return '';
		}

		$ids = array_filter(
			array_map(
				function( $id ) {
					return preg_replace( '/[^A-Za-z0-9\-_:.]/', '', $id );
				},
				$ids
			),
			function( $id ) {
				return '' !== $id;
			}
		);

		return implode( ' ', $ids );
	}

	/**
	 * Sanitize a single ARIA ID reference.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	private function sanitize_module_aria_idref( $value ) {
		$ids = preg_split( '/\s+/', $this->sanitize_module_aria_idrefs( $value ) );

		return is_array( $ids ) && isset( $ids[0] ) ? $ids[0] : '';
	}

	/**
	 * Sanitize a plugin-owned module accessibility attribute.
	 *
	 * @param string $name Attribute name.
	 * @param string $value Raw value.
	 * @return string
	 */
	private function sanitize_module_accessibility_attribute( $name, $value ) {
		switch ( $name ) {
			case 'role':
				return $this->sanitize_module_aria_role( $value );

			case 'aria-label':
			case 'aria-description':
				return $this->sanitize_module_aria_text( $value );

			case 'aria-labelledby':
			case 'aria-describedby':
				return $this->sanitize_module_aria_idrefs( $value );

			case 'aria-details':
				return $this->sanitize_module_aria_idref( $value );
		}

		return '';
	}

	/**
	 * Add a sanitized module accessibility attribute when valid.
	 *
	 * @param array  $attributes Attribute names and values.
	 * @param string $name Attribute name.
	 * @param string $value Raw value.
	 * @return array
	 */
	private function add_module_accessibility_attribute( array $attributes, $name, $value ) {
		$value = $this->sanitize_module_accessibility_attribute( $name, $value );

		if ( '' !== $value ) {
			$attributes[ $name ] = $value;
		}

		return $attributes;
	}

	/**
	 * Build escaped HTML attributes.
	 *
	 * @param array  $attributes Attribute names and values.
	 * @param string $tag_attributes Existing attributes on the target tag.
	 * @return string
	 */
	private function build_module_accessibility_attribute_string( array $attributes, $tag_attributes ) {
		$attribute_string = '';

		foreach ( $attributes as $name => $value ) {
			if ( '' === $value || preg_match( '/\s' . preg_quote( $name, '/' ) . '\s*=/i', $tag_attributes ) ) {
				continue;
			}

			$attribute_string .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}

		return $attribute_string;
	}

	/**
	 * Add accessibility classes and attributes to the first class-bearing element in module output.
	 *
	 * @param string $output Module output.
	 * @param string $class_list Space-prefixed class list.
	 * @param array  $attributes Attribute names and values.
	 * @return string
	 */
	private function add_module_accessibility_to_output( $output, $class_list, array $attributes ) {
		if ( ( ! $class_list && empty( $attributes ) ) || ! is_string( $output ) ) {
			return $output;
		}

		return preg_replace_callback(
			'/<([A-Za-z][A-Za-z0-9:_-]*)([^>]*\sclass="[^"]*"[^>]*)>/',
			function( $matches ) use ( $class_list, $attributes ) {
				$tag_name       = $matches[1];
				$tag_attributes = $matches[2];

				if ( $class_list ) {
					$tag_attributes = preg_replace( '/class="([^"]*)"/', 'class="$1' . $class_list . '"', $tag_attributes, 1 );
				}

				return '<' . $tag_name . $tag_attributes . $this->build_module_accessibility_attribute_string( $attributes, $tag_attributes ) . '>';
			},
			$output,
			1
		);
	}

	/**
	 * Build the accessibility class list from D4 or D5 module props.
	 *
	 * @param array $props Module props.
	 * @return string
	 */
	private function get_module_accessibility_class_list( array $props ) {
		$class_list = '';

		if ( $this->module_prop_is_enabled(
			$props,
			array(
				array( 'hide_aria_element' ),
				array( 'accessibility', 'advanced', 'hideAriaElement', 'desktop', 'value' ),
			)
		) ) {
			$class_list .= ' aria-hidden';
		}
		if ( $this->module_prop_is_enabled(
			$props,
			array(
				array( 'show_for_screen_readers_only' ),
				array( 'accessibility', 'advanced', 'showForScreenReadersOnly', 'desktop', 'value' ),
			)
		) ) {
			$class_list .= ' screen-reader-text';
		}

		return $class_list;
	}

	/**
	 * Build module accessibility attributes from D4 or D5 module props.
	 *
	 * @param array $props Module props.
	 * @return array
	 */
	private function get_module_accessibility_attributes( array $props ) {
		$attributes    = array();
		$attribute_map = array(
			'role'                => array(
				array( 'da11y_role' ),
				array( 'accessibility', 'advanced', 'da11yRole', 'desktop', 'value' ),
			),
			'aria-label'          => array(
				array( 'da11y_aria_label' ),
				array( 'accessibility', 'advanced', 'da11yAriaLabel', 'desktop', 'value' ),
			),
			'aria-labelledby'     => array(
				array( 'da11y_aria_labelledby' ),
				array( 'accessibility', 'advanced', 'da11yAriaLabelledby', 'desktop', 'value' ),
			),
			'aria-description'    => array(
				array( 'da11y_aria_description' ),
				array( 'accessibility', 'advanced', 'da11yAriaDescription', 'desktop', 'value' ),
			),
			'aria-describedby'    => array(
				array( 'da11y_aria_describedby' ),
				array( 'accessibility', 'advanced', 'da11yAriaDescribedby', 'desktop', 'value' ),
			),
			'aria-details'        => array(
				array( 'da11y_aria_details' ),
				array( 'accessibility', 'advanced', 'da11yAriaDetails', 'desktop', 'value' ),
			),
		);

		foreach ( $attribute_map as $attribute_name => $paths ) {
			$attributes = $this->add_module_accessibility_attribute(
				$attributes,
				$attribute_name,
				$this->get_module_prop_string( $props, $paths )
			);
		}

		return $attributes;
	}

	/**
	 * Add module accessibility classes to Divi 5 block output.
	 *
	 * @param string $block_content Rendered block content.
	 * @param array  $block Block data.
	 * @return string
	 */
	public function add_divi_5_block_accessibility_classes( $block_content, $block ) {
		if (
			! is_string( $block_content )
			|| ! is_array( $block )
			|| empty( $block['blockName'] )
			|| 0 !== strpos( $block['blockName'], 'divi/' )
			|| empty( $block['attrs'] )
			|| ! is_array( $block['attrs'] )
		) {
			return $block_content;
		}

		return $this->add_module_accessibility_to_output(
			$block_content,
			$this->get_module_accessibility_class_list( $block['attrs'] ),
			$this->get_module_accessibility_attributes( $block['attrs'] )
		);
	}

	/**
	 * @param string $output
	 * @param string $render_method
	 * @param ET_Builder_Element $element
	 *
	 * @return string
	 */
	function add_accessibilty_classes( $output, $render_method, $element ) {
		if ( is_string( $output ) && isset( $element->props ) && is_array( $element->props ) ) {
			$output = $this->add_module_accessibility_to_output(
				$output,
				$this->get_module_accessibility_class_list( $element->props ),
				$this->get_module_accessibility_attributes( $element->props )
			);
		}
		return $output;
	}
}
