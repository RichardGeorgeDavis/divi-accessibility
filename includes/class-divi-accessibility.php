<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://campuspress.com
 * @since      1.1.0
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/includes
 */
class Divi_Accessibility {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       string
	 */
	protected $da11y;

	/**
	 * The prefix for the plugins's options.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       string
	 */
	protected $da11y_options;

	/**
	 * The current version of the plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       string
	 */
	protected $version;

	/**
	 * The plugin settings.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       array
	 */
	protected $settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.2.0
	 * @param string $version Plugin version.
	 */
	public function __construct( $version ) {

		$this->da11y         = 'divi_accessibility';
		$this->da11y_options = 'divi_accessibility_options';
		$this->version       = $version;

		$this->load_dependencies();
		$this->load_settings();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Divi_Accessibility_Admin. Defines all hooks for the admin area.
	 * - Divi_Accessibility_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-divi-accessibility-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-divi-accessibility-public.php';

		if ( $this->should_load_updater() ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-divi-accessibility-updater.php';
		}

	}

	/**
	 * Determine whether the GitHub updater needs to be loaded.
	 *
	 * @since 2.1.1
	 * @return bool True when WordPress may check or apply plugin updates.
	 */
	private function should_load_updater() {
		if ( is_admin() ) {
			return true;
		}

		if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) {
			return true;
		}

		return defined( 'WP_CLI' ) && WP_CLI;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Divi_Accessibility_Admin( $this->da11y, $this->da11y_options, $this->version, $this->settings );

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $plugin_admin, 'add_options_page' ), 900 );
		add_action( 'admin_init', array( $plugin_admin, 'register_settings' ) );
		add_filter( 'plugin_action_links_' . DA11Y_FILE, array( $plugin_admin, 'link_settings' ) );

		//DIVI ARIA visibility
		add_filter( 'et_builder_module_general_fields', array( $plugin_admin,
			'divi_builder_register_accessibilty_settings'
		), 15, 1 );
		add_filter( 'et_builder_get_parent_modules', array( $plugin_admin, 'divi_builder_add_accessibility_group' ), 15, 2 );
		add_filter( 'et_builder_get_child_modules', array( $plugin_admin, 'divi_builder_add_accessibility_group' ), 15, 2 );
		add_action( 'divi_visual_builder_assets_before_enqueue_scripts', array( $plugin_admin, 'enqueue_divi_5_visual_builder_assets' ) );
		add_filter( 'divi.conversion.moduleLibrary.conversionMap', array( $plugin_admin, 'register_divi_5_accessibility_conversion_map' ) );

		if ( class_exists( 'Divi_Accessibility_Updater' ) ) {
			$plugin_updater = new Divi_Accessibility_Updater( DA11Y_FILE, $this->version );
			$plugin_updater->register_hooks();
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Divi_Accessibility_Public( $this->da11y, $this->da11y_options, $this->version, $this->settings );

		add_action(
			'wp_enqueue_scripts',
			array( $plugin_public, 'setup_scripts_and_styles' ),
			PHP_INT_MAX
		);
		add_action( 'init', array( $plugin_public, 'remove_divi_viewport_meta' ) );
		add_action( 'wp_head', array( $plugin_public, 'accessible_viewport_meta' ) );
		add_filter( 'init', array( $plugin_public, 'remove_duplicate_menu_ids' ) );
		add_filter( 'body_class', array( $plugin_public, 'add_divi_version_body_class' ) );

		add_filter( 'et_pb_module_shortcode_attributes', array( $plugin_public, 'maybe_override_module_image_alt' ), 10, 5 );
		add_filter( 'divi_module_wrapper_render', array( $plugin_public, 'maybe_filter_divi_5_image_module_wrapper' ), 10, 2 );
		add_action( 'et_module_process_display_conditions', array( $plugin_public, 'add_accessibilty_classes' ), PHP_INT_MAX, 3 );
		add_filter( 'render_block', array( $plugin_public, 'add_divi_5_block_accessibility_classes' ), PHP_INT_MAX, 2 );
	}

	/**
	 * Shared actions.
	 */
	public function run() {
		add_action( 'init', array( $this, 'load_translations' ) );
	}

	/**
	 * Load the language translations.
	 */
	public function load_translations() {
		load_plugin_textdomain(
			'divi-accessibility',
			false,
			trailingslashit( DA11Y_PATH, 'languages' )
		);
	}

	/**
	 * Retreive settings.
	 *
	 * @since    1.0.0
	 */
	public function load_settings() {
		$this->settings = get_option( $this->da11y_options );
	}

}
