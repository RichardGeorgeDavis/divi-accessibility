<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://campuspress.com
 * @since      1.0.0
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/admin
 */
class Divi_Accessibility_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @param string $hook Page hook.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		if ( ! $this->is_settings_page( $hook ) ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'divi-accessibility-admin-style', plugin_dir_url( __FILE__ ) . 'css/divi-accessibility-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the scripts for the admin area.
	 *
	 * @param string $hook Page hook.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		if ( ! $this->is_settings_page( $hook ) ) {
			return;
		}

		wp_enqueue_script( 'divi-accessibility-admin-script', plugin_dir_url( __FILE__ ) . 'js/divi-accessibility-admin.js', array( 'wp-color-picker' ), $this->version, true );
	}

	/**
	 * Check whether the current admin page is this plugin settings page.
	 *
	 * @since 2.1.1
	 * @param string $hook Page hook.
	 * @return bool
	 */
	private function is_settings_page( $hook ) {
		if ( is_string( $hook ) && false !== strpos( $hook, $this->da11y ) ) {
			return true;
		}

		if ( isset( $_GET['page'] ) ) {
			$page = sanitize_key( wp_unslash( $_GET['page'] ) );
			return $this->da11y === $page;
		}

		return false;
	}

	/**
	 * Add an options page under the Divi menu.
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		add_submenu_page(
			'et_divi_options',
			__( 'Divi Accessibility', 'divi-accessibility' ),
			__( 'Accessibility', 'divi-accessibility' ),
			'manage_options',
			$this->da11y,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Adds a link to the plugin settings page.
	 *
	 * @since     1.0.0
	 * @param     array $links    The current array of links.
	 * @return    array              The modified array of links.
	 */
	public function link_settings( $links ) {

		$links[] = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=' . $this->da11y ) ),
			esc_html__( 'Settings', 'divi-accessibility' )
		);

		$links[] = sprintf(
			'<a href="%s">%s</a>',
			esc_url( 'https://github.com/RichardGeorgeDavis/divi-accessibility' ),
			esc_html__( 'GitHub', 'divi-accessibility' )
		);

		return $links;

	}

	/**
	 * Render the options page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/divi-accessibility-admin-display.php';
	}

	/**
	 * Returns an array of options names and their default values.
	 *
	 * @since    1.0.0
	 * @return   array    An array of options
	 */
	public static function get_options_list() {

		$options = array(
			'aria_support'                 => 1,
			'slider_accessibility'         => 1,
			'dropdown_keyboard_navigation' => 1,
			'fix_labels'                   => 1,
			'focusable_modules'            => 1,
			'keyboard_navigation_outline'  => 1,
			'outline_color'                => '#2ea3f2',
			'screen_reader_text'           => 1,
			'skip_navigation_link'         => 1,
			'skip_link_navigation_enabled' => 0,
			'skip_link_content_enabled'    => 1,
			'skip_link_footer_enabled'     => 0,
			'skip_link_navigation_text'    => __( 'Skip to navigation', 'divi-accessibility' ),
			'skip_link_content_text'       => __( 'Skip to content', 'divi-accessibility' ),
			'skip_link_footer_text'        => __( 'Skip to footer', 'divi-accessibility' ),
			'skip_link_navigation_target'  => '#main-header nav, #top-menu-nav, #et-top-navigation, .et_pb_menu__menu, nav[role="navigation"], nav',
			'skip_link_content_target'     => '#main-content, #et-main-area, main, [role="main"]',
			'skip_link_footer_target'      => '#main-footer, .et-l--footer, footer',
			'aria_hidden_icons'            => 1,
			'aria_mobile_menu'             => 1,
			'fix_duplicate_menu_ids'       => 1,
			'reduced_motion'               => 0,
			'underline_urls'               => 0,
			'underline_urls_not_title'     => 0,
			'tota11y'                      => 0,
			'developer_mode'               => 0,
		);

		return $options;

	}

	/**
	 * Return dashboard tabs.
	 *
	 * @since 2.1.1
	 * @return array
	 */
	public function get_dashboard_tabs() {
		return array(
			'accessibility' => array(
				'label'       => __( 'Accessibility', 'divi-accessibility' ),
				'description' => __( 'Divi-specific fixes that improve keyboard, screen reader, and validation behavior.', 'divi-accessibility' ),
				'has_form'    => true,
			),
			'tools'         => array(
				'label'       => __( 'Tools', 'divi-accessibility' ),
				'description' => __( 'Admin-only helpers for reviewing and debugging accessibility behavior.', 'divi-accessibility' ),
				'has_form'    => true,
			),
			'resources'     => array(
				'label'       => __( 'Resources', 'divi-accessibility' ),
				'description' => __( 'Reference links and project information.', 'divi-accessibility' ),
				'has_form'    => false,
			),
		);
	}

	/**
	 * Return the active dashboard tab.
	 *
	 * @since 2.1.1
	 * @return string
	 */
	public function get_active_dashboard_tab() {
		$active_tab = 'accessibility';
		$tabs       = $this->get_dashboard_tabs();

		if ( isset( $_GET['tab'] ) ) {
			$requested_tab = sanitize_key( wp_unslash( $_GET['tab'] ) );
			if ( isset( $tabs[ $requested_tab ] ) ) {
				$active_tab = $requested_tab;
			}
		}

		return $active_tab;
	}

	/**
	 * Return settings metadata grouped by dashboard tab.
	 *
	 * @since 2.1.1
	 * @return array
	 */
	public function get_dashboard_settings() {
		return array(
			'accessibility' => array(
				array(
					'name'        => 'aria_support',
					'title'       => __( 'ARIA support', 'divi-accessibility' ),
					'description' => __( 'Add appropriate ARIA attributes across Divi elements &amp; modules.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'dropdown_keyboard_navigation',
					'title'       => __( 'Dropdown keyboard navigation', 'divi-accessibility' ),
					'description' => __( 'Allow easier navigation of Divi dropdown menus with the keyboard.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'slider_accessibility',
					'title'       => __( 'Slider accessibility', 'divi-accessibility' ),
					'description' => __( 'Add labels and keyboard controls to Divi slider arrows and navigation dots.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'fix_labels',
					'title'       => __( 'Fix labels', 'divi-accessibility' ),
					'description' => __( 'Fix missing labels &amp; incorrect or missing assignments to their corresponding inputs.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'focusable_modules',
					'title'       => __( 'Focusable modules', 'divi-accessibility' ),
					'description' => __( 'Allow Divi modules such as <em>Toggle</em> &amp; <em>Accordion</em> to be focusable with keyboard navigation. Hitting enter will open/close when focused.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'keyboard_navigation_outline',
					'title'       => __( 'Keyboard navigation outline', 'divi-accessibility' ),
					'description' => __( 'Add an outline to focused elements when navigation with the keyboard.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'outline_color',
					'title'       => __( 'Outline color', 'divi-accessibility' ),
					'description' => __( 'Choose the color used for the keyboard navigation outline.', 'divi-accessibility' ),
					'subtext'     => __( 'Keyboard navigation outline', 'divi-accessibility' ),
					'type'        => 'color',
				),
				array(
					'name'        => 'screen_reader_text',
					'title'       => __( 'Screen reader text', 'divi-accessibility' ),
					'description' => __( 'Add plugin screen reader class used on certain labels &amp; reverses Divi incorrectly applying <code>display: none;</code> on its own screen reader classes.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'skip_navigation_link',
					'title'       => __( 'Skip navigation link', 'divi-accessibility' ),
					'description' => __( 'Allow user to skip over Divi navigation when using keyboard and go straight to content.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'skip_link_navigation_enabled',
					'title'       => __( 'Skip to navigation link', 'divi-accessibility' ),
					'description' => __( 'Add a keyboard-visible link that moves focus directly to the site navigation.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'skip_link_content_enabled',
					'title'       => __( 'Skip to content link', 'divi-accessibility' ),
					'description' => __( 'Add a keyboard-visible link that moves focus directly to the main content area.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'skip_link_footer_enabled',
					'title'       => __( 'Skip to footer link', 'divi-accessibility' ),
					'description' => __( 'Add a keyboard-visible link that moves focus directly to the site footer.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'skip_link_navigation_text',
					'title'       => __( 'Skip to navigation text', 'divi-accessibility' ),
					'description' => __( 'Customize the visible text for the skip to navigation link.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'skip_link_content_text',
					'title'       => __( 'Skip to content text', 'divi-accessibility' ),
					'description' => __( 'Customize the visible text for the skip to content link.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'skip_link_footer_text',
					'title'       => __( 'Skip to footer text', 'divi-accessibility' ),
					'description' => __( 'Customize the visible text for the skip to footer link.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'skip_link_navigation_target',
					'title'       => __( 'Skip to navigation target selectors', 'divi-accessibility' ),
					'description' => __( 'Comma-separated selectors. The first matching element receives focus when the navigation skip link is used.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'skip_link_content_target',
					'title'       => __( 'Skip to content target selectors', 'divi-accessibility' ),
					'description' => __( 'Comma-separated selectors. The first matching element receives focus when the content skip link is used.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'skip_link_footer_target',
					'title'       => __( 'Skip to footer target selectors', 'divi-accessibility' ),
					'description' => __( 'Comma-separated selectors. The first matching element receives focus when the footer skip link is used.', 'divi-accessibility' ),
					'type'        => 'text',
				),
				array(
					'name'        => 'aria_hidden_icons',
					'title'       => __( 'Hide icons', 'divi-accessibility' ),
					'description' => __( 'Hide all icons to screen readers so text is read normally.', 'divi-accessibility' ),
					'subtext'     => __( 'This may not work for all icons', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'aria_mobile_menu',
					'title'       => __( 'Aria support for mobile menu', 'divi-accessibility' ),
					'description' => __( 'Apply Aria attributes to the mobile (burger) menu to make it accessible.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'fix_duplicate_menu_ids',
					'title'       => __( 'Fix duplicate menu ids', 'divi-accessibility' ),
					'description' => __( 'Because Divi uses the same menu twice (Once for the primary menu and again for the mobile menu), the unique ID\'s are duplicated causing validation issues. This option prevents WordPress from adding a unique ID to the menu list items.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'reduced_motion',
					'title'       => __( 'Reduced motion support', 'divi-accessibility' ),
					'description' => __( 'Respect user reduced motion preferences by minimizing non-essential Divi animations.', 'divi-accessibility' ),
					'subtext'     => __( 'Applies only when users have reduced motion enabled in their operating system/browser', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'underline_urls',
					'title'       => __( 'Underline URLs', 'divi-accessibility' ),
					'description' => __( 'Easily find out URLs when they are underlined.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'underline_urls_not_title',
					'title'       => __( 'Exclude underlines from titles and buttons', 'divi-accessibility' ),
					'description' => __( 'Disable URL underlines on titles, headings, and buttons.', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
			),
			'tools'         => array(
				array(
					'name'        => 'tota11y',
					'title'       => __( 'Tota11y', 'divi-accessibility' ),
					'description' => __( 'Add a small button to the bottom corner of site to visualize how your site performs with assistive technology.', 'divi-accessibility' ),
					'subtext'     => __( 'Admin users only', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
				array(
					'name'        => 'developer_mode',
					'title'       => __( 'Developer mode', 'divi-accessibility' ),
					'description' => __( 'Log plugin info to console.', 'divi-accessibility' ),
					'subtext'     => __( 'Admin users only', 'divi-accessibility' ),
					'type'        => 'checkbox',
				),
			),
			'resources'     => array(),
		);
	}

	/**
	 * Register all related settings of this plugin.
	 *
	 * @since    1.1.0
	 */
	public function register_settings() {

		register_setting(
			$this->da11y,
			$this->da11y_options,
			array( $this, 'divi_accessibility_validate_options' )
		);

	}

	/**
	 * Validate options before saving to DB.
	 *
	 * @since    1.0.0
	 * @param    array $input Input.
	 */
	public function divi_accessibility_validate_options( $input ) {

		if ( ! is_array( $input ) ) {
			$input = array();
		}

		$valid_options     = array();
		$option_list       = $this->get_options_list();
		$current_settings  = get_option( $this->da11y_options );
		$current_settings  = is_array( $current_settings ) ? $current_settings : array();
		$dashboard_tabs    = $this->get_dashboard_tabs();
		$dashboard_fields  = $this->get_dashboard_settings();
		$active_tab        = isset( $input['__active_tab'] ) ? sanitize_key( $input['__active_tab'] ) : 'accessibility';
		$active_tab        = isset( $dashboard_tabs[ $active_tab ] ) ? $active_tab : 'accessibility';
		$active_field_keys = array();
		$field_types       = array();

		foreach ( $dashboard_fields as $tab_fields ) {
			foreach ( $tab_fields as $field ) {
				$field_types[ $field['name'] ] = isset( $field['type'] ) ? $field['type'] : 'checkbox';
			}
		}

		if ( ! empty( $dashboard_fields[ $active_tab ] ) ) {
			foreach ( $dashboard_fields[ $active_tab ] as $field ) {
				$active_field_keys[] = $field['name'];
			}
		}

		// Loop through all available options.
		foreach ( $option_list as $key => $option ) {
			$is_active_field = in_array( $key, $active_field_keys, true );
			$field_type      = isset( $field_types[ $key ] ) ? $field_types[ $key ] : 'checkbox';

			// If color-picker.
			if ( 'outline_color' == $key ) {

				$default_color = $option;
				$color         = isset( $current_settings[ $key ] ) ? $current_settings[ $key ] : $default_color;

				if ( $is_active_field ) {
					$color = isset( $input[ $key ] ) ? $input[ $key ] : $default_color;
				}

				if ( $this->is_valid_color( $color ) ) {

					$valid_options[ $key ] = sanitize_text_field( $color );

				} else {

					$valid_options[ $key ] = $default_color;

				}
			} elseif ( in_array( $field_type, array( 'text', 'textarea' ), true ) ) {

				$default_text = (string) $option;
				$text         = isset( $current_settings[ $key ] ) ? (string) $current_settings[ $key ] : $default_text;

				if ( $is_active_field ) {
					$text = isset( $input[ $key ] ) ? (string) $input[ $key ] : $default_text;
				}

				$text = sanitize_text_field( $text );

				if ( '' === $text && '' !== $default_text ) {
					$text = $default_text;
				}

				$valid_options[ $key ] = $text;

			} elseif ( ! $is_active_field ) {

				$valid_options[ $key ] = isset( $current_settings[ $key ] )
					? ( 1 == $current_settings[ $key ] ? 1 : 0 )
					: ( 1 == $option ? 1 : 0 );

			} elseif ( isset( $input[ $key ] ) && 1 == $input[ $key ] ) {

				$valid_options[ $key ] = 1;

			} else {

				$valid_options[ $key ] = 0;

			}
		} // End foreach().

		return $valid_options;

	}

	/**
	 * Check if value is a valid HEX color.
	 *
	 * @since    1.0.0
	 * @param string $value Value to check.
	 * @return   boolean
	 */
	public function is_valid_color( $value ) {

		if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #.

			return true;

		}

		return false;

	}

	/**
	 * Callback for checkbox settings.
	 *
	 * @since    1.0.0
	 * @param    array $arg Input args.
	 */
	public function divi_accessibility_checkbox_cb( $arg ) {

		$name          = $arg['name'];
		$label_for     = $arg['label_for'];
		$label_text    = $arg['label_text'];
		$label_subtext = ! empty( $arg['label_subtext'] ) ? $arg['label_subtext'] : '';
		$label_class   = ! empty( $arg['label_class'] ) ? $arg['label_class'] : 'widefat';
		$labelledby    = ! empty( $arg['labelledby'] ) ? $arg['labelledby'] : '';
		$option_list   = $this->get_options_list();

		if ( isset( $this->settings[ $name ] ) ) {
			$checked = $this->settings[ $name ];
		} elseif ( isset( $option_list[ $name ] ) ) {
			$checked = $option_list[ $name ];
		} else {
			$checked = 0;
		}

		?>

		<fieldset>

			<?php if ( 'da11y-hurkan-switch' === $label_class ) { ?>
				<span class="checkbox <?php echo esc_attr( $label_class ); ?>">
					<input type="checkbox"
					<?php checked( $checked, 1 ); ?>
					name="<?php echo esc_attr( $this->da11y_options ) . '[' . esc_attr( $name ) . ']'; ?>"
					id="<?php echo esc_attr( $label_for ); ?>"
					class="hurkanSwitch-switch-plugin hurkanSwitch-switch-input"
					data-on-title="<?php esc_attr_e( 'Enabled', 'divi-accessibility' ); ?>"
					data-off-title="<?php esc_attr_e( 'Disabled', 'divi-accessibility' ); ?>"
					aria-describedby="<?php echo esc_attr( $label_for ); ?>-desc"
					<?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>
					value="1" />
					<span class="hurkanSwitch switch-responsive hurkanSwitch-switch-plugin-box">
						<span class="hurkanSwitch-switch-box switch-animated-on" role="switch" tabindex="0" aria-checked="<?php echo esc_attr( 1 === (int) $checked ? 'true' : 'false' ); ?>" <?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>>
							<a class="hurkanSwitch-switch-item <?php echo 1 === (int) $checked ? 'active ' : ''; ?>hurkanSwitch-switch-item-color-success hurkanSwitch-switch-item-status-on" href="#" tabindex="-1">
								<span class="lbl"><?php esc_html_e( 'Enabled', 'divi-accessibility' ); ?></span>
								<span class="hurkanSwitch-switch-cursor-selector"></span>
							</a>
							<a class="hurkanSwitch-switch-item <?php echo 1 === (int) $checked ? '' : 'active '; ?>hurkanSwitch-switch-item-color-default hurkanSwitch-switch-item-status-off" href="#" tabindex="-1">
								<span class="lbl"><?php esc_html_e( 'Disabled', 'divi-accessibility' ); ?></span>
								<span class="hurkanSwitch-switch-cursor-selector"></span>
							</a>
						</span>
					</span>
					<span class="screen-reader-text"><?php echo esc_html( $label_text ); ?></span>
				</span>
			<?php } else { ?>
				<label class="<?php echo esc_attr( $label_class ); ?>">
					<input type="checkbox"
					<?php checked( $checked, 1 ); ?>
					name="<?php echo esc_attr( $this->da11y_options ) . '[' . esc_attr( $name ) . ']'; ?>"
					id="<?php echo esc_attr( $label_for ); ?>"
					aria-describedby="<?php echo esc_attr( $label_for ); ?>-desc"
					<?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>
					value="1" />
					<?php echo wp_kses_post( $label_text ); ?>
				</label>
			<?php } ?>

			<?php if ( '' != $label_subtext ) { ?>
				<p id="<?php echo esc_attr( $label_for ); ?>-desc" class="description">(<em><?php echo esc_html( $label_subtext ); ?></em>)</p>
			<?php } ?>

		</fieldset>

		<?php
	}

	/**
	 * Callback for color picker settings.
	 *
	 * @since    1.0.0
	 * @param    array $arg Input args.
	 */
	public function divi_accessibility_color_picker_cb( $arg ) {

		$name          = $arg['name'];
		$label_for     = $arg['label_for'];
		$label_subtext = $arg['label_subtext'];
		$labelledby    = ! empty( $arg['labelledby'] ) ? $arg['labelledby'] : '';

		$option_list   = $this->get_options_list();
		$default_color = $option_list['outline_color'];
		$color         = $default_color;

		if ( isset( $this->settings['outline_color'] ) ) {
			$color = $this->settings['outline_color'];
		}

		?>

		<fieldset>
			<label class="widefat">
				<input type="text"
				name="<?php echo esc_attr( $this->da11y_options ) . '[' . esc_attr( $name ) . ']'; ?>"
					id="<?php echo esc_attr( $label_for ); ?>"
					value="<?php echo esc_attr( $color ); ?>"
					class="da11y-color-picker"
					data-default-color="<?php echo esc_attr( $default_color ); ?>"
					<?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>
					/>
			</label>

			<?php if ( '' != $label_subtext ) { ?>
				<p class="description">(<em><?php echo esc_html( $label_subtext ); ?></em>)</p>
			<?php } ?>

		</fieldset>

		<?php
	}

	/**
	 * Callback for text settings.
	 *
	 * @since    2.1.3
	 * @param    array $arg Input args.
	 */
	public function divi_accessibility_text_cb( $arg ) {

		$name          = $arg['name'];
		$label_for     = $arg['label_for'];
		$label_subtext = $arg['label_subtext'];
		$labelledby    = ! empty( $arg['labelledby'] ) ? $arg['labelledby'] : '';
		$type          = ! empty( $arg['type'] ) && 'textarea' === $arg['type'] ? 'textarea' : 'text';

		$option_list = $this->get_options_list();
		$value       = isset( $option_list[ $name ] ) ? $option_list[ $name ] : '';

		if ( isset( $this->settings[ $name ] ) ) {
			$value = $this->settings[ $name ];
		}

		?>

		<fieldset>
			<label class="widefat">
				<?php if ( 'textarea' === $type ) { ?>
					<textarea
						name="<?php echo esc_attr( $this->da11y_options ) . '[' . esc_attr( $name ) . ']'; ?>"
						id="<?php echo esc_attr( $label_for ); ?>"
						rows="3"
						<?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>
					><?php echo esc_textarea( $value ); ?></textarea>
				<?php } else { ?>
					<input type="text"
						name="<?php echo esc_attr( $this->da11y_options ) . '[' . esc_attr( $name ) . ']'; ?>"
						id="<?php echo esc_attr( $label_for ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						<?php echo '' !== $labelledby ? 'aria-labelledby="' . esc_attr( $labelledby ) . '"' : ''; ?>
					/>
				<?php } ?>
			</label>

			<?php if ( '' != $label_subtext ) { ?>
				<p class="description">(<em><?php echo esc_html( $label_subtext ); ?></em>)</p>
			<?php } ?>

		</fieldset>

		<?php
	}

	/**
	 * Register DIVI builder accessibility settings
	 *
	 * @param array $fields
	 * @return array
	 */
	function divi_builder_register_accessibilty_settings( $fields ) {
		$hide_aria_setting = array(
				'type'              => 'yes_no_button',
				'description'       => __( 'Hide this module from assistive technology. Do not use this on modules that contain links, buttons, form fields, or other focusable content.', 'divi-accessibility' ),
				'label'             => __( 'Hide From Screen Readers', 'divi-accessibility' ),
				'option_category'   => 'configuration',
				'options' => array(
					'off' => et_builder_i18n( 'No' ),
					'on' => et_builder_i18n( 'Yes' )
				),
				'default'     => 'off',
				'toggle_slug' => 'accessibility'
		);

		$fields['hide_aria_element'] = $hide_aria_setting;

		$show_for_screen_readers_only = array(
			'type'              => 'yes_no_button',
			'description'       => __( 'Visually hide this module while keeping it available to assistive technology.', 'divi-accessibility' ),
			'label'             => __( 'Show For Screen Readers Only', 'divi-accessibility' ),
			'option_category'   => 'configuration',
			'options' => array(
				'off' => et_builder_i18n( 'No' ),
				'on' => et_builder_i18n( 'Yes' )
			),
			'default'     => 'off',
			'toggle_slug' => 'accessibility'
		);
		$fields['show_for_screen_readers_only'] = $show_for_screen_readers_only;

		$fields['da11y_role'] = array(
			'type'            => 'select',
			'description'     => __( 'Add an allowed role to this module wrapper only when the native markup does not communicate the right semantics.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Role', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'options'         => array(
				''              => __( 'None', 'divi-accessibility' ),
				'region'        => 'region',
				'complementary' => 'complementary',
				'navigation'    => 'navigation',
				'list'          => 'list',
				'listitem'      => 'listitem',
				'button'        => 'button',
				'link'          => 'link',
				'dialog'        => 'dialog',
				'alertdialog'   => 'alertdialog',
				'presentation'  => 'presentation',
				'none'          => 'none',
			),
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		$fields['da11y_aria_label'] = array(
			'type'            => 'text',
			'description'     => __( 'Add an accessible name only when the module visible content is not sufficient. Prefer visible text or ARIA Labelledby when a visible label exists.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Label', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		$fields['da11y_aria_labelledby'] = array(
			'type'            => 'text',
			'description'     => __( 'Add a space-separated list of element IDs that label this module wrapper. Avoid combining this with ARIA Label unless you have tested the result.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Labelledby', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		$fields['da11y_aria_description'] = array(
			'type'            => 'textarea',
			'description'     => __( 'Add a short accessible description only when the module needs extra context beyond its visible content.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Description', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		$fields['da11y_aria_describedby'] = array(
			'type'            => 'text',
			'description'     => __( 'Add a space-separated list of element IDs that describe this module wrapper. Values are treated as ID references.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Describedby', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		$fields['da11y_aria_details'] = array(
			'type'            => 'text',
			'description'     => __( 'Add one element ID that provides extended details for this module wrapper. Values are treated as ID references.', 'divi-accessibility' ),
			'label'           => __( 'ARIA Details', 'divi-accessibility' ),
			'option_category' => 'configuration',
			'default'         => '',
			'toggle_slug'     => 'accessibility',
		);

		return $fields;
	}

	/**
	 * Add section in DIVI element options modal
	 * @param array $modules
	 * @param string $post_type
	 *
	 * @return array
	 */
	function divi_builder_add_accessibility_group( array $modules, string $post_type ): array {
		foreach ( $modules as &$module ) {
			if ( ! isset( $module->settings_modal_toggles['general']['toggles'] ) ) {
				continue;
			}
			$module->settings_modal_toggles['general']['toggles']['accessibility'] = array( 'title' => __( 'Accessibility Settings', 'divi-accessibility' ), 'priority' => 50 );
		}
		return $modules;
	}

	/**
	 * Register Divi 5 Visual Builder assets for module-level accessibility settings.
	 *
	 * @return void
	 */
	public function enqueue_divi_5_visual_builder_assets() {
		if ( ! function_exists( 'et_core_is_fb_enabled' ) || ! function_exists( 'et_builder_d5_enabled' ) ) {
			return;
		}

		if ( ! et_core_is_fb_enabled() || ! et_builder_d5_enabled() ) {
			return;
		}

		if ( ! class_exists( '\ET\Builder\VisualBuilder\Assets\PackageBuildManager' ) ) {
			return;
		}

		\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
			array(
				'name'    => 'divi-accessibility-d5-module-settings',
				'version' => $this->version,
				'script'  => array(
					'src'                => plugin_dir_url( __FILE__ ) . 'js/divi-accessibility-d5-module-settings.js',
					'deps'               => array(
						'lodash',
						'divi-vendor-wp-hooks',
						'divi-vendor-wp-i18n',
					),
					'enqueue_top_window' => false,
					'enqueue_app_window' => true,
					'args'               => array(
						'in_footer' => false,
					),
				),
			)
		);
	}

	/**
	 * Register D4 to D5 conversion mapping for accessibility module settings.
	 *
	 * @param array $conversion_map Existing conversion map.
	 * @return array
	 */
	public function register_divi_5_accessibility_conversion_map( $conversion_map ) {
		if ( ! class_exists( '\ET\Builder\Packages\ModuleLibrary\ModuleRegistration' ) ) {
			return $conversion_map;
		}

		$core_modules = \ET\Builder\Packages\ModuleLibrary\ModuleRegistration::get_all_core_modules_metadata();
		$attribute_map = array(
			'hide_aria_element'            => 'accessibility.advanced.hideAriaElement.*',
			'show_for_screen_readers_only' => 'accessibility.advanced.showForScreenReadersOnly.*',
			'da11y_role'                   => 'accessibility.advanced.da11yRole.*',
			'da11y_aria_label'             => 'accessibility.advanced.da11yAriaLabel.*',
			'da11y_aria_labelledby'        => 'accessibility.advanced.da11yAriaLabelledby.*',
			'da11y_aria_description'       => 'accessibility.advanced.da11yAriaDescription.*',
			'da11y_aria_describedby'       => 'accessibility.advanced.da11yAriaDescribedby.*',
			'da11y_aria_details'           => 'accessibility.advanced.da11yAriaDetails.*',
		);

		foreach ( array_keys( $core_modules ) as $module_slug ) {
			$module_conversion_map = array();

			if ( isset( $conversion_map[ $module_slug ] ) && is_array( $conversion_map[ $module_slug ] ) ) {
				$module_conversion_map = $conversion_map[ $module_slug ];
			}

			$module_conversion_map['attributeMap'] = array_merge(
				isset( $module_conversion_map['attributeMap'] ) && is_array( $module_conversion_map['attributeMap'] )
					? $module_conversion_map['attributeMap']
					: array(),
				$attribute_map
			);

			$conversion_map[ $module_slug ] = $module_conversion_map;
		}

		return $conversion_map;
	}
}
