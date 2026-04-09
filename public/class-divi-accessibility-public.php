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
			$data['skip_navigation_link_text'] = __( 'Skip to content', 'divi-accessibility' );
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

		if ( isset( $settings['tota11y'] ) ) {
			$tota11y = $settings['tota11y'];
		}

		if ( current_user_can( 'manage_options' ) && ( true == $tota11y ) ) {
			return true;
		}

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
	 * @param string $output
	 * @param string $render_method
	 * @param ET_Builder_Element $element
	 *
	 * @return string
	 */
	function add_accessibilty_classes( $output, $render_method, $element ) {
		if ( is_string( $output ) && isset( $element->props ) && is_array( $element->props ) ) {

			$class_list = '';

			if ( $this->module_prop_is_enabled(
				$element->props,
				array(
					array( 'hide_aria_element' ),
					array( 'accessibility', 'advanced', 'hideAriaElement', 'desktop', 'value' ),
				)
			) ) {
				$class_list .= ' aria-hidden';
			}
			if ( $this->module_prop_is_enabled(
				$element->props,
				array(
					array( 'show_for_screen_readers_only' ),
					array( 'accessibility', 'advanced', 'showForScreenReadersOnly', 'desktop', 'value' ),
				)
			) ) {
				$class_list .= ' screen-reader-text';
			}
			if ( $class_list ) {
				$output = preg_replace('/class=\"(.*?)\"/', 'class="$1' . $class_list . '"', $output, 1);
			}
		}
		return $output;
	}
}
