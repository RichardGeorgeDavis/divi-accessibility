<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/RichardGeorgeDavis/divi-accessibility
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

		$root_style = 'divi-accessibility-da11y-styles';
		wp_register_style( $root_style, false, array(), $this->version );
		wp_enqueue_style( $root_style );

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
				'open_site_search' => __( 'Open site search', 'divi-accessibility' ),
				'search'       => __( 'Search', 'divi-accessibility' ),
				'search_form'  => __( 'Search form', 'divi-accessibility' ),
				'menu_search_form' => __( 'Menu search form', 'divi-accessibility' ),
				'search_for'   => __( 'Search for...', 'divi-accessibility' ),
				'view_cart'    => __( 'View cart', 'divi-accessibility' ),
			);
		}
		$data['accessibility_labels'] = array(
			'opens_in_new_tab' => __( 'opens in a new tab', 'divi-accessibility' ),
			'visit_our'        => __( 'Visit our', 'divi-accessibility' ),
			'page'             => __( 'page', 'divi-accessibility' ),
			'read_more_about'  => __( 'Read more about', 'divi-accessibility' ),
			'video_play_button' => __( 'Video play button', 'divi-accessibility' ),
			'open_and_close_mobile_menu' => __( 'Open and close mobile menu', 'divi-accessibility' ),
			'audio_player'     => __( 'Audio player', 'divi-accessibility' ),
			'by'               => __( 'by', 'divi-accessibility' ),
			'of'               => __( 'of', 'divi-accessibility' ),
			'back_to_top'      => __( 'Back to top', 'divi-accessibility' ),
			'submenu'          => __( 'submenu', 'divi-accessibility' ),
		);
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
			'hide_image_title_tooltips',
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
			'underline_urls_not_menu',
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

		$settings = $this->get_settings_with_defaults();

		if ( isset( $settings[ $option ] ) && 1 == $settings[ $option ] ) {
			$can_load = true;
		}

		return apply_filters( 'divi_accessibility_can_load', $can_load, $option );

	}

	/**
	 * Return settings merged with defaults.
	 *
	 * @return array
	 */
	private function get_settings_with_defaults() {
		return array_merge(
			Divi_Accessibility_Admin::get_options_list(),
			is_array( $this->settings ) ? $this->settings : array()
		);
	}

	/**
	 * Return a single setting value.
	 *
	 * @param string $name Setting name.
	 * @return mixed
	 */
	private function get_setting_value( $name ) {
		$settings = $this->get_settings_with_defaults();

		return isset( $settings[ $name ] ) ? $settings[ $name ] : null;
	}

	/**
	 * Whether frontend image alt processing should run.
	 *
	 * @return bool
	 */
	private function should_process_image_alt_text() {
		return 'disabled' !== $this->get_setting_value( 'image_alt_source' )
			|| 'disabled' !== $this->get_setting_value( 'image_alt_fallback_source' );
	}

	/**
	 * Whether Divi 5 Image Helper rendering should run.
	 *
	 * @return bool
	 */
	private function should_render_image_helper_metadata() {
		return 1 === (int) $this->get_setting_value( 'image_helper_module_fields' );
	}

	/**
	 * Return the best known attachment ID for an image URL.
	 *
	 * @param string $url Image URL.
	 * @return int
	 */
	private function get_attachment_id_by_url( $url ) {
		global $wpdb;

		if ( ! is_string( $url ) || '' === trim( $url ) ) {
			return 0;
		}

		$image_url     = preg_replace( '/-(\d+)x(\d+)\./', '.', strtok( $url, '?' ) );
		$attachment_id = (int) attachment_url_to_postid( $image_url );

		if ( ! $attachment_id ) {
			$parsed_url = wp_parse_url( $image_url );
			$path       = is_array( $parsed_url ) && ! empty( $parsed_url['path'] ) ? $parsed_url['path'] : '';
			$filename   = pathinfo( trim( $path, '/' ), PATHINFO_FILENAME );

			if ( preg_match( '/%[0-9A-Fa-f]{2}/', $filename ) ) {
				$filename = urldecode( $filename );
			}

			$filename = sanitize_file_name( $filename );

			if ( '' !== $filename ) {
				$results = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT pm.post_id, pm.meta_value
						FROM $wpdb->postmeta pm
						INNER JOIN $wpdb->posts p ON pm.post_id = p.ID
						WHERE pm.meta_key = '_wp_attached_file'
						AND pm.meta_value LIKE %s
						AND p.post_type = 'attachment'
						AND p.post_status = 'inherit'",
						'%' . $wpdb->esc_like( $filename ) . '%'
					)
				);

				if ( ! empty( $results ) ) {
					foreach ( $results as $result ) {
						if ( strtolower( pathinfo( $result->meta_value, PATHINFO_FILENAME ) ) === strtolower( $filename ) ) {
							$attachment_id = (int) $result->post_id;
							break;
						}
					}
				}
			}
		}

		if ( $attachment_id && function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
			$translation_id = pll_get_post( $attachment_id, pll_current_language() );
			if ( $translation_id ) {
				$attachment_id = (int) $translation_id;
			}
		}

		if ( $attachment_id && class_exists( 'sitepress' ) ) {
			$attachment_id = (int) apply_filters( 'wpml_object_id', $attachment_id, 'attachment', true );
		}

		return $attachment_id;
	}

	/**
	 * Return image attachment metadata used by frontend helpers.
	 *
	 * @param string $url Image URL.
	 * @return array
	 */
	private function get_image_attachment_data( $url ) {
		$attachment_id = $this->get_attachment_id_by_url( $url );
		$image_url     = preg_replace( '/-(\d+)x(\d+)\./', '.', strtok( (string) $url, '?' ) );
		$filename      = pathinfo( wp_basename( $image_url ), PATHINFO_FILENAME );
		$filename      = trim( str_replace( array( '-', '_' ), ' ', $filename ) );

		if ( ! $attachment_id ) {
			return array(
				'id'          => 0,
				'alt'         => '',
				'title'       => '',
				'caption'     => '',
				'description' => '',
				'filename'    => $filename,
			);
		}

		$post = get_post( $attachment_id );

		if ( ! $post || 'attachment' !== $post->post_type ) {
			return array(
				'id'          => 0,
				'alt'         => '',
				'title'       => '',
				'caption'     => '',
				'description' => '',
				'filename'    => $filename,
			);
		}

		return array(
			'id'          => $attachment_id,
			'alt'         => (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
			'title'       => (string) $post->post_title,
			'caption'     => (string) $post->post_excerpt,
			'description' => (string) $post->post_content,
			'filename'    => $filename,
		);
	}

	/**
	 * Resolve frontend alt text according to plugin settings.
	 *
	 * @param string $url Existing image URL.
	 * @param string $module_alt Existing module alt text.
	 * @param bool   $module_alt_is_authored Whether the module/rendered image explicitly authored an alt attribute.
	 * @return string
	 */
	private function resolve_image_alt_text( $url, $module_alt, $module_alt_is_authored = false ) {
		$module_alt      = trim( (string) $module_alt );
		$alt_source      = (string) $this->get_setting_value( 'image_alt_source' );
		$fallback_source = (string) $this->get_setting_value( 'image_alt_fallback_source' );

		if ( 'media_override' !== $alt_source ) {
			if ( '' !== $module_alt ) {
				return $module_alt;
			}

			if ( $module_alt_is_authored ) {
				return '';
			}
		}

		$attachment_data = $this->get_image_attachment_data( $url );

		if ( 'disabled' !== $alt_source && '' !== trim( $attachment_data['alt'] ) ) {
			return sanitize_text_field( $attachment_data['alt'] );
		}

		if ( 'title' === $fallback_source && '' !== trim( $attachment_data['title'] ) ) {
			return sanitize_text_field( $attachment_data['title'] );
		}

		if ( 'filename' === $fallback_source && '' !== trim( $attachment_data['filename'] ) ) {
			return sanitize_text_field( $attachment_data['filename'] );
		}

		return $module_alt;
	}

	/**
	 * Override Divi 4 shortcode module image alt attributes when configured.
	 *
	 * @param array  $props Module props.
	 * @param array  $attrs Original attrs.
	 * @param string $render_slug Module slug.
	 * @param string $_address Module address.
	 * @param string $content Module content.
	 * @return array
	 */
	public function maybe_override_module_image_alt( $props, $attrs = array(), $render_slug = '', $_address = '', $content = '' ) {
		unset( $_address, $content );

		$attrs = is_array( $attrs ) ? $attrs : array();

		if ( ! $this->should_process_image_alt_text() || ! is_array( $props ) ) {
			return $props;
		}

		if ( function_exists( 'et_fb_is_enabled' ) && et_fb_is_enabled() ) {
			return $props;
		}

		if ( function_exists( 'et_builder_bfb_enabled' ) && et_builder_bfb_enabled() ) {
			return $props;
		}

		switch ( $render_slug ) {
			case 'et_pb_image':
			case 'et_pb_fullwidth_image':
				if ( ! empty( $props['src'] ) ) {
					$has_alt      = array_key_exists( 'alt', $attrs );
					$props['alt'] = $this->resolve_image_alt_text( $props['src'], $has_alt ? $props['alt'] : '', $has_alt );
				}
				break;

			case 'et_pb_blurb':
				if ( isset( $props['use_icon'] ) && 'on' === $props['use_icon'] ) {
					break;
				}
				if ( ! empty( $props['image'] ) ) {
					$has_alt      = array_key_exists( 'alt', $attrs );
					$props['alt'] = $this->resolve_image_alt_text( $props['image'], $has_alt ? $props['alt'] : '', $has_alt );
				}
				break;

			case 'et_pb_fullwidth_header':
				if ( ! empty( $props['logo_image_url'] ) ) {
					$has_alt                = array_key_exists( 'logo_alt_text', $attrs );
					$props['logo_alt_text'] = $this->resolve_image_alt_text( $props['logo_image_url'], $has_alt ? $props['logo_alt_text'] : '', $has_alt );
				}
				if ( ! empty( $props['header_image_url'] ) ) {
					$has_alt                 = array_key_exists( 'image_alt_text', $attrs );
					$props['image_alt_text'] = $this->resolve_image_alt_text( $props['header_image_url'], $has_alt ? $props['image_alt_text'] : '', $has_alt );
				}
				break;

			case 'et_pb_slide':
				if ( ! empty( $props['image'] ) ) {
					$has_alt            = array_key_exists( 'image_alt', $attrs );
					$props['image_alt'] = $this->resolve_image_alt_text( $props['image'], $has_alt ? $props['image_alt'] : '', $has_alt );
				}
				break;
		}

		return $props;
	}

	/**
	 * Load a small HTML fragment into DOMDocument.
	 *
	 * @param string $html HTML fragment.
	 * @return DOMDocument|null
	 */
	private function load_html_fragment( $html ) {
		if ( ! class_exists( 'DOMDocument' ) || ! is_string( $html ) || '' === $html ) {
			return null;
		}

		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$previous = libxml_use_internal_errors( true );

		if ( function_exists( 'mb_encode_numericentity' ) ) {
			$html = mb_encode_numericentity( $html, array( 0x80, 0x10FFFF, 0, 0xFFFFFF ), 'UTF-8' );
		} else {
			$html = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $html;
		}

		$loaded = $dom->loadHTML( $html, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		libxml_clear_errors();
		libxml_use_internal_errors( $previous );
		$dom->encoding = 'UTF-8';

		return $loaded ? $dom : null;
	}

	/**
	 * Save DOMDocument back to a string.
	 *
	 * @param DOMDocument $dom DOM document.
	 * @return string
	 */
	private function save_html_fragment( $dom ) {
		$html = $dom->saveHTML();

		if ( function_exists( 'mb_decode_numericentity' ) ) {
			$html = mb_decode_numericentity( $html, array( 0x80, 0x10FFFF, 0, 0xFFFFFF ), 'UTF-8' );
		}

		return $html;
	}

	/**
	 * Append safe HTML content into a DOM node.
	 *
	 * @param DOMDocument $dom Parent DOM document.
	 * @param DOMNode     $node Node to receive children.
	 * @param string      $html HTML content.
	 * @return void
	 */
	private function append_safe_html_to_node( $dom, $node, $html ) {
		$html = trim( wp_kses_post( $html ) );

		if ( '' === $html ) {
			return;
		}

		$fragment_dom = $this->load_html_fragment( '<div data-da11y-fragment-root="1">' . $html . '</div>' );

		if ( ! $fragment_dom ) {
			$node->appendChild( $dom->createTextNode( wp_strip_all_tags( $html ) ) );
			return;
		}

		$xpath = new DOMXPath( $fragment_dom );
		$root  = $xpath->query( '//*[@data-da11y-fragment-root="1"]' );
		$root  = $root && $root->length ? $root->item( 0 ) : null;

		if ( ! $root ) {
			$node->appendChild( $dom->createTextNode( wp_strip_all_tags( $html ) ) );
			return;
		}

		foreach ( iterator_to_array( $root->childNodes ) as $child ) {
			$node->appendChild( $dom->importNode( $child, true ) );
		}
	}

	/**
	 * Add configured alt text to images inside rendered output.
	 *
	 * @param string $output Rendered output.
	 * @return string
	 */
	private function add_image_alt_text_to_output( $output ) {
		if ( ! $this->should_process_image_alt_text() ) {
			return $output;
		}

		$dom = $this->load_html_fragment( $output );

		if ( ! $dom ) {
			return $output;
		}

		$updated = false;

		foreach ( $dom->getElementsByTagName( 'img' ) as $image ) {
			$src = $image->getAttribute( 'src' );

			if ( '' === $src ) {
				continue;
			}

			$has_alt     = $image->hasAttribute( 'alt' );
			$current_alt = $has_alt ? $image->getAttribute( 'alt' ) : '';
			$new_alt     = $this->resolve_image_alt_text( $src, $current_alt, $has_alt );

			if ( $new_alt !== $current_alt ) {
				$image->setAttribute( 'alt', $new_alt );
				$updated = true;
			}
		}

		return $updated ? $this->save_html_fragment( $dom ) : $output;
	}

	/**
	 * Return the first available Divi 5 image source from attrs.
	 *
	 * @param array $attrs Module attrs.
	 * @return string
	 */
	private function get_divi_5_image_src_from_attrs( array $attrs ) {
		$value = $this->get_nested_module_prop( $attrs, array( 'image', 'innerContent', 'desktop', 'value', 'src' ) );

		return is_string( $value ) ? $value : '';
	}

	/**
	 * Choose module/media metadata text for an image helper field.
	 *
	 * @param string $module_value Module value.
	 * @param string $media_value Media value.
	 * @return string
	 */
	private function resolve_image_metadata_text( $module_value, $media_value ) {
		$source       = (string) $this->get_setting_value( 'image_metadata_text_source' );
		$module_value = trim( (string) $module_value );
		$media_value  = trim( (string) $media_value );

		if ( 'media_override' === $source && '' !== $media_value ) {
			return $media_value;
		}

		if ( 'media_when_empty' === $source && '' === $module_value && '' !== $media_value ) {
			return $media_value;
		}

		return $module_value;
	}

	/**
	 * Build Divi 5 image metadata field data.
	 *
	 * @param array $attrs Module attrs.
	 * @return array
	 */
	private function get_divi_5_image_metadata( array $attrs ) {
		$image_src        = $this->get_divi_5_image_src_from_attrs( $attrs );
		$attachment_data  = '' !== $image_src ? $this->get_image_attachment_data( $image_src ) : array();
		$title_text       = $this->get_module_prop_string( $attrs, array( array( 'imageMetadata', 'innerContent', 'titleText', 'desktop', 'value' ) ) );
		$caption_text     = $this->get_module_prop_string( $attrs, array( array( 'imageMetadata', 'innerContent', 'captionText', 'desktop', 'value' ) ) );
		$description_text = $this->get_module_prop_string( $attrs, array( array( 'imageMetadata', 'innerContent', 'descriptionText', 'desktop', 'value' ) ) );
		$heading_level    = $this->get_module_prop_string( $attrs, array( array( 'imageMetadata', 'decoration', 'titleFont', 'font', 'desktop', 'value', 'headingLevel' ) ) );

		if ( ! in_array( $heading_level, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) {
			$heading_level = 'h2';
		}

		return array(
			'image_src'         => $image_src,
			'title_text'        => $this->resolve_image_metadata_text( $title_text, isset( $attachment_data['title'] ) ? $attachment_data['title'] : '' ),
			'caption_text'      => $this->resolve_image_metadata_text( $caption_text, isset( $attachment_data['caption'] ) ? $attachment_data['caption'] : '' ),
			'description_text'  => $this->resolve_image_metadata_text( $description_text, isset( $attachment_data['description'] ) ? $attachment_data['description'] : '' ),
			'title_heading'     => $heading_level,
			'show_title'        => $this->module_prop_is_enabled( $attrs, array( array( 'imageMetadata', 'advanced', 'showTitle', 'desktop', 'value' ) ) ),
			'show_caption'      => $this->module_prop_is_enabled( $attrs, array( array( 'imageMetadata', 'advanced', 'showCaption', 'desktop', 'value' ) ) ),
			'show_description'  => $this->module_prop_is_enabled( $attrs, array( array( 'imageMetadata', 'advanced', 'showDescription', 'desktop', 'value' ) ) ),
			'use_text_overlay'  => $this->module_prop_is_enabled( $attrs, array( array( 'imageMetadata', 'decoration', 'showImageMetaAsOverlay', 'desktop', 'value' ) ) ),
			'aspect_ratio'      => $this->get_module_prop_string( $attrs, array( array( 'image', 'innerContent', 'desktop', 'value', 'aspectRatio' ) ) ),
		);
	}

	/**
	 * Add Divi 5 image metadata markup to rendered output.
	 *
	 * @param string $output Rendered output.
	 * @param array  $attrs Module attrs.
	 * @return string
	 */
	private function add_image_metadata_to_output( $output, array $attrs ) {
		if ( ! $this->should_render_image_helper_metadata() ) {
			return $output;
		}

		$metadata = $this->get_divi_5_image_metadata( $attrs );

		if (
			( ! $metadata['show_title'] || '' === trim( $metadata['title_text'] ) )
			&& ( ! $metadata['show_caption'] || '' === trim( $metadata['caption_text'] ) )
			&& ( ! $metadata['show_description'] || '' === trim( $metadata['description_text'] ) )
			&& ( '' === $metadata['aspect_ratio'] || 'none' === $metadata['aspect_ratio'] )
		) {
			return $output;
		}

		$dom = $this->load_html_fragment( $output );

		if ( ! $dom ) {
			return $output;
		}

		$xpath       = new DOMXPath( $dom );
		$wrap_nodes  = $xpath->query( "//*[contains(concat(' ', normalize-space(@class), ' '), ' et_pb_image_wrap ')]" );
		$image_wrap  = $wrap_nodes && $wrap_nodes->length ? $wrap_nodes->item( 0 ) : null;
		$changed     = false;
		$aspect      = trim( $metadata['aspect_ratio'] );

		if ( $image_wrap && '' !== $aspect && 'none' !== $aspect && preg_match( '#^\d+/\d+$#', $aspect ) ) {
			$existing_style = $image_wrap->getAttribute( 'style' );
			$image_wrap->setAttribute( 'style', trim( $existing_style . '; aspect-ratio: ' . $aspect . '; overflow: hidden;' ) );

			$images = $image_wrap->getElementsByTagName( 'img' );
			if ( $images->length ) {
				$img            = $images->item( 0 );
				$existing_style = $img->getAttribute( 'style' );
				$img->setAttribute( 'style', trim( $existing_style . '; width: 100%; height: 100%; object-fit: cover;' ) );
			}

			$changed = true;
		}

		if ( ! $image_wrap ) {
			return $changed ? $this->save_html_fragment( $dom ) : $output;
		}

		$existing_metadata = $xpath->query( "//*[contains(concat(' ', normalize-space(@class), ' '), ' da11y-image-metadata-container ')]" );
		if ( $existing_metadata && $existing_metadata->length ) {
			return $changed ? $this->save_html_fragment( $dom ) : $output;
		}

		$container_classes = 'et_pb_image_metadata_container da11y-image-metadata-container';
		$container         = $dom->createElement( 'div' );
		$container->setAttribute( 'class', $container_classes );

		if ( $metadata['use_text_overlay'] ) {
			$container->setAttribute( 'style', 'position:absolute;top:0;left:0;' );
		}

		if ( $metadata['show_title'] && '' !== trim( $metadata['title_text'] ) ) {
			$title = $dom->createElement( $metadata['title_heading'] );
			$title->setAttribute( 'class', 'et_pb_image_title' );
			$title->appendChild( $dom->createTextNode( wp_strip_all_tags( $metadata['title_text'] ) ) );
			$container->appendChild( $title );
		}

		if ( $metadata['show_caption'] && '' !== trim( $metadata['caption_text'] ) ) {
			$caption = $dom->createElement( 'p' );
			$caption->setAttribute( 'class', 'et_pb_image_caption' );
			$caption->appendChild( $dom->createTextNode( wp_strip_all_tags( $metadata['caption_text'] ) ) );
			$container->appendChild( $caption );
		}

		if ( $metadata['show_description'] && '' !== trim( $metadata['description_text'] ) ) {
			$description = $dom->createElement( 'div' );
			$description->setAttribute( 'class', 'et_pb_image_description' );
			$this->append_safe_html_to_node( $dom, $description, $metadata['description_text'] );
			$container->appendChild( $description );
		}

		if ( $container->hasChildNodes() ) {
			if ( $image_wrap->nextSibling ) {
				$image_wrap->parentNode->insertBefore( $container, $image_wrap->nextSibling );
			} else {
				$image_wrap->parentNode->appendChild( $container );
			}
			$changed = true;
		}

		return $changed ? $this->save_html_fragment( $dom ) : $output;
	}

	/**
	 * Filter Divi 5 image module wrappers.
	 *
	 * @param string $module_wrapper Rendered module wrapper.
	 * @param array  $args Divi module args.
	 * @return string
	 */
	public function maybe_filter_divi_5_image_module_wrapper( $module_wrapper, $args = array() ) {
		if (
			! is_string( $module_wrapper )
			|| ! is_array( $args )
			|| empty( $args['name'] )
			|| 'divi/image' !== $args['name']
		) {
			return $module_wrapper;
		}

		$attrs = isset( $args['attrs'] ) && is_array( $args['attrs'] ) ? $args['attrs'] : array();
		$output = $this->add_image_alt_text_to_output( $module_wrapper );
		$output = $this->add_image_metadata_to_output( $output, $attrs );
		$this->maybe_render_divi_5_image_helper_styles( $args );

		return function_exists( 'et_core_esc_previously' ) ? et_core_esc_previously( $output ) : $output;
	}

	/**
	 * Render Divi 5 Image Helper design styles when Divi's style API is available.
	 *
	 * @param array $args Divi module render args.
	 * @return void
	 */
	private function maybe_render_divi_5_image_helper_styles( array $args ) {
		if ( ! $this->should_render_image_helper_metadata() ) {
			return;
		}

		if (
			empty( $args['attrs'] )
			|| ! is_array( $args['attrs'] )
			|| empty( $args['elements'] )
			|| ! is_object( $args['elements'] )
			|| ! method_exists( $args['elements'], 'style' )
			|| ! class_exists( '\ET\Builder\FrontEnd\Module\Style' )
			|| ! class_exists( '\ET\Builder\Packages\StyleLibrary\Utils\StyleDeclarations' )
		) {
			return;
		}

		$attrs       = $args['attrs'];
		$elements    = $args['elements'];
		$order_class = '';

		if ( isset( $elements->order_class ) && is_string( $elements->order_class ) ) {
			$order_class = $elements->order_class;
		} elseif ( isset( $elements->orderClass ) && is_string( $elements->orderClass ) ) {
			$order_class = $elements->orderClass;
		}

		if ( '' === $order_class || empty( $args['id'] ) || empty( $args['name'] ) ) {
			return;
		}

		$image_decoration    = isset( $attrs['image']['innerContent'] ) && is_array( $attrs['image']['innerContent'] )
			? $attrs['image']['innerContent']
			: array();
		$metadata_decoration = isset( $attrs['imageMetadata']['decoration'] ) && is_array( $attrs['imageMetadata']['decoration'] )
			? $attrs['imageMetadata']['decoration']
			: array();

		if ( empty( $image_decoration ) && empty( $metadata_decoration ) ) {
			return;
		}

		try {
			$styles = array(
				$elements->style(
					array(
						'attrName'   => 'image',
						'styleProps' => array(
							'advancedStyles' => array(
								array(
									'componentName' => 'divi/common',
									'props'         => array(
										'selector'            => $order_class . ' .et_pb_image_wrap',
										'attr'                => $image_decoration,
										'declarationFunction' => function( $params ) {
											return $this->get_divi_5_image_wrap_style_declarations( $params );
										},
									),
								),
								array(
									'componentName' => 'divi/common',
									'props'         => array(
										'selector'            => $order_class . ' .et_pb_image_wrap img',
										'attr'                => $image_decoration,
										'declarationFunction' => function( $params ) {
											return $this->get_divi_5_image_style_declarations( $params );
										},
									),
								),
							),
						),
					)
				),
				$elements->style(
					array(
						'attrName'   => 'imageMetadata',
						'styleProps' => array(
							'advancedStyles' => array(
								array(
									'componentName' => 'divi/common',
									'props'         => array(
										'selector'            => $order_class . ' .et_pb_image_metadata_container',
										'attr'                => isset( $metadata_decoration['showImageMetaAsOverlay'] ) ? $metadata_decoration['showImageMetaAsOverlay'] : array(),
										'declarationFunction' => function( $params ) {
											return $this->get_divi_5_image_metadata_overlay_style_declarations( $params );
										},
									),
								),
								array(
									'componentName' => 'divi/background',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_metadata_container',
										'attr'     => isset( $metadata_decoration['containerBackground'] ) ? $metadata_decoration['containerBackground'] : array(),
									),
								),
								array(
									'componentName' => 'divi/spacing',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_metadata_container',
										'attr'     => isset( $metadata_decoration['containerSpacing'] ) ? $metadata_decoration['containerSpacing'] : array(),
									),
								),
								array(
									'componentName' => 'divi/border',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_metadata_container',
										'attr'     => isset( $metadata_decoration['containerBorder'] ) ? $metadata_decoration['containerBorder'] : array(),
									),
								),
								array(
									'componentName' => 'divi/boxShadow',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_metadata_container',
										'attr'     => isset( $metadata_decoration['containerShadow'] ) ? $metadata_decoration['containerShadow'] : array(),
									),
								),
								array(
									'componentName' => 'divi/font',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_title',
										'attr'     => isset( $metadata_decoration['titleFont'] ) ? $metadata_decoration['titleFont'] : array(),
									),
								),
								array(
									'componentName' => 'divi/font',
									'props'         => array(
										'selector' => $order_class . ' .et_pb_image_caption',
										'attr'     => isset( $metadata_decoration['captionFont'] ) ? $metadata_decoration['captionFont'] : array(),
									),
								),
							),
						),
					)
				),
			);

			if ( class_exists( '\ET\Builder\Packages\Module\Options\Element\ElementStyle' ) ) {
				$styles[] = \ET\Builder\Packages\Module\Options\Element\ElementStyle::style(
					array(
						'selector' => $order_class . ' .et_pb_image_description',
						'attrs'    => array(
							'bodyFont' => isset( $metadata_decoration['descriptionFont'] ) ? $metadata_decoration['descriptionFont'] : array(),
						),
					)
				);
			}

			\ET\Builder\FrontEnd\Module\Style::add(
				array(
					'id'            => (string) $args['id'],
					'name'          => (string) $args['name'],
					'orderIndex'    => isset( $args['orderIndex'] ) ? (int) $args['orderIndex'] : 0,
					'storeInstance' => isset( $args['storeInstance'] ) ? (int) $args['storeInstance'] : 0,
					'styles'        => $styles,
				)
			);
		} catch ( Throwable $e ) {
			return;
		}
	}

	/**
	 * Return a StyleDeclarations instance.
	 *
	 * @return object
	 */
	private function get_divi_5_style_declarations() {
		return new \ET\Builder\Packages\StyleLibrary\Utils\StyleDeclarations(
			array(
				'returnType' => 'string',
				'important'  => false,
			)
		);
	}

	/**
	 * Return a normalized image aspect ratio value from Divi style params.
	 *
	 * @param array $params Divi style params.
	 * @return string
	 */
	private function get_divi_5_image_aspect_ratio_from_style_params( $params ) {
		$attr_value = isset( $params['attrValue'] ) ? $params['attrValue'] : array();
		$aspect     = 'none';

		if ( is_array( $attr_value ) && isset( $attr_value['aspectRatio'] ) && is_scalar( $attr_value['aspectRatio'] ) ) {
			$aspect = (string) $attr_value['aspectRatio'];
		} elseif ( is_scalar( $attr_value ) ) {
			$aspect = (string) $attr_value;
		}

		$aspect = str_replace( ' ', '', trim( $aspect ) );

		return preg_match( '#^\d+/\d+$#', $aspect ) ? $aspect : 'none';
	}

	/**
	 * Build image wrapper style declarations.
	 *
	 * @param array $params Divi style params.
	 * @return string
	 */
	private function get_divi_5_image_wrap_style_declarations( $params ) {
		$aspect             = $this->get_divi_5_image_aspect_ratio_from_style_params( $params );
		$style_declarations = $this->get_divi_5_style_declarations();

		if ( 'none' !== $aspect ) {
			$style_declarations->add( 'aspect-ratio', $aspect );
			$style_declarations->add( 'overflow', 'hidden' );
		} else {
			$style_declarations->add( 'aspect-ratio', 'auto' );
		}

		return $style_declarations->value();
	}

	/**
	 * Build image element style declarations.
	 *
	 * @param array $params Divi style params.
	 * @return string
	 */
	private function get_divi_5_image_style_declarations( $params ) {
		$aspect             = $this->get_divi_5_image_aspect_ratio_from_style_params( $params );
		$style_declarations = $this->get_divi_5_style_declarations();

		if ( 'none' !== $aspect ) {
			$style_declarations->add( 'width', '100%' );
			$style_declarations->add( 'height', '100%' );
			$style_declarations->add( 'object-fit', 'cover' );
		} else {
			$style_declarations->add( 'width', 'auto' );
			$style_declarations->add( 'height', 'auto' );
			$style_declarations->add( 'object-fit', 'fill' );
		}

		return $style_declarations->value();
	}

	/**
	 * Build metadata overlay style declarations.
	 *
	 * @param array $params Divi style params.
	 * @return string
	 */
	private function get_divi_5_image_metadata_overlay_style_declarations( $params ) {
		$style_declarations = $this->get_divi_5_style_declarations();
		$is_overlay         = isset( $params['attrValue'] ) && $this->module_prop_value_is_enabled( $params['attrValue'] );

		if ( $is_overlay ) {
			$style_declarations->add( 'position', 'absolute' );
			$style_declarations->add( 'top', '0' );
			$style_declarations->add( 'left', '0' );
		} else {
			$style_declarations->add( 'position', 'relative' );
			$style_declarations->add( 'top', 'unset' );
			$style_declarations->add( 'left', 'unset' );
		}

		return $style_declarations->value();
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
	 * Determine whether a module prop value is enabled.
	 *
	 * @param mixed $value Module prop value.
	 * @return bool
	 */
	private function module_prop_value_is_enabled( $value ) {
		if ( true === $value || 1 === $value ) {
			return true;
		}

		if ( ! is_scalar( $value ) ) {
			return false;
		}

		return in_array( strtolower( trim( (string) $value ) ), array( '1', 'on', 'true' ), true );
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
			if ( $this->module_prop_value_is_enabled( $this->get_nested_module_prop( $props, $path ) ) ) {
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
		) {
			return $block_content;
		}

		$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();

		if ( 'divi/image' === $block['blockName'] ) {
			$block_content = $this->add_image_alt_text_to_output( $block_content );
			$block_content = $this->add_image_metadata_to_output( $block_content, $attrs );
		}

		if ( empty( $attrs ) ) {
			return $block_content;
		}

		return $this->add_module_accessibility_to_output(
			$block_content,
			$this->get_module_accessibility_class_list( $attrs ),
			$this->get_module_accessibility_attributes( $attrs )
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
