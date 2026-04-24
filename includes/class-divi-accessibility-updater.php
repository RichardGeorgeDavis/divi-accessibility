<?php
/**
 * GitHub release updater integration.
 *
 * @link       https://github.com/RichardGeorgeDavis/divi-accessibility
 * @since      2.1.1
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Adds GitHub Releases to WordPress' native plugin update flow.
 *
 * @since      2.1.1
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/includes
 */
class Divi_Accessibility_Updater {

	const API_URL        = 'https://api.github.com/repos/RichardGeorgeDavis/divi-accessibility/releases/latest';
	const REPOSITORY_URL = 'https://github.com/RichardGeorgeDavis/divi-accessibility';
	const TRANSIENT_KEY  = 'divi_accessibility_github_release';
	const CACHE_TTL      = 21600;

	/**
	 * Plugin basename.
	 *
	 * @since 2.1.1
	 * @access private
	 * @var string
	 */
	private $plugin_file;

	/**
	 * Plugin slug.
	 *
	 * @since 2.1.1
	 * @access private
	 * @var string
	 */
	private $slug;

	/**
	 * Current plugin version.
	 *
	 * @since 2.1.1
	 * @access private
	 * @var string
	 */
	private $version;

	/**
	 * Initialize the updater.
	 *
	 * @since 2.1.1
	 * @param string $plugin_file Plugin basename.
	 * @param string $version     Current plugin version.
	 */
	public function __construct( $plugin_file, $version ) {
		$this->plugin_file = $plugin_file;
		$this->slug        = dirname( $plugin_file );
		$this->version     = $version;

		if ( '.' === $this->slug ) {
			$this->slug = 'divi-accessibility';
		}
	}

	/**
	 * Register updater hooks.
	 *
	 * @since 2.1.1
	 */
	public function register_hooks() {
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'filter_update_plugins_transient' ) );
		add_filter( 'plugins_api', array( $this, 'filter_plugins_api' ), 10, 3 );
		add_action( 'upgrader_process_complete', array( $this, 'clear_release_cache_after_update' ), 10, 2 );
	}

	/**
	 * Add GitHub release metadata to WordPress' plugin update transient.
	 *
	 * @since 2.1.1
	 * @param object $transient Plugin update transient.
	 * @return object Plugin update transient.
	 */
	public function filter_update_plugins_transient( $transient ) {
		if ( ! is_object( $transient ) ) {
			return $transient;
		}

		$release = $this->get_release();

		if ( ! $release ) {
			return $transient;
		}

		$plugin_data = $this->build_update_data( $release );

		if ( version_compare( $release['version'], $this->version, '>' ) ) {
			if ( empty( $transient->response ) || ! is_array( $transient->response ) ) {
				$transient->response = array();
			}

			if ( ! empty( $transient->no_update ) && is_array( $transient->no_update ) ) {
				unset( $transient->no_update[ $this->plugin_file ] );
			}

			$transient->response[ $this->plugin_file ] = $plugin_data;
		} else {
			if ( empty( $transient->no_update ) || ! is_array( $transient->no_update ) ) {
				$transient->no_update = array();
			}

			if ( ! empty( $transient->response ) && is_array( $transient->response ) ) {
				unset( $transient->response[ $this->plugin_file ] );
			}

			$transient->no_update[ $this->plugin_file ] = $plugin_data;
		}

		return $transient;
	}

	/**
	 * Provide plugin information for the WordPress update details modal.
	 *
	 * @since 2.1.1
	 * @param false|object|array $result The result object or array. Default false.
	 * @param string             $action The type of information being requested.
	 * @param object             $args   Plugin API arguments.
	 * @return false|object|array Plugin information result.
	 */
	public function filter_plugins_api( $result, $action, $args ) {
		if ( 'plugin_information' !== $action || empty( $args->slug ) || $this->slug !== $args->slug ) {
			return $result;
		}

		$release = $this->get_release();

		if ( ! $release ) {
			return $result;
		}

		return (object) array(
			'name'          => 'Divi Accessibility',
			'slug'          => $this->slug,
			'version'       => $release['version'],
			'author'        => '<a href="https://github.com/RichardGeorgeDavis">Richard George Davis</a>',
			'author_profile' => 'https://github.com/RichardGeorgeDavis',
			'homepage'      => self::REPOSITORY_URL,
			'download_link' => $release['package'],
			'trunk'         => $release['package'],
			'last_updated'  => $release['published_at'],
			'sections'      => array(
				'description' => '<p>' . esc_html__( 'Improve Divi accessibility across Divi 4 and Divi 5 with WCAG-aligned fixes.', 'divi-accessibility' ) . '</p>',
				'changelog'   => $this->format_release_notes( $release ),
			),
		);
	}

	/**
	 * Clear cached GitHub release data after this plugin is updated.
	 *
	 * @since 2.1.1
	 * @param WP_Upgrader $upgrader   WordPress upgrader instance.
	 * @param array       $hook_extra Upgrader hook context.
	 */
	public function clear_release_cache_after_update( $upgrader, $hook_extra ) {
		unset( $upgrader );

		if ( empty( $hook_extra['type'] ) || 'plugin' !== $hook_extra['type'] ) {
			return;
		}

		$plugins = array();

		if ( ! empty( $hook_extra['plugin'] ) ) {
			$plugins[] = $hook_extra['plugin'];
		}

		if ( ! empty( $hook_extra['plugins'] ) && is_array( $hook_extra['plugins'] ) ) {
			$plugins = array_merge( $plugins, $hook_extra['plugins'] );
		}

		if ( in_array( $this->plugin_file, $plugins, true ) ) {
			delete_site_transient( self::TRANSIENT_KEY );
		}
	}

	/**
	 * Retrieve and normalize the latest GitHub release.
	 *
	 * @since 2.1.1
	 * @return array|null Release data, or null when no usable release exists.
	 */
	private function get_release() {
		$cached = get_site_transient( self::TRANSIENT_KEY );

		if ( is_array( $cached ) && array_key_exists( 'release', $cached ) ) {
			return $cached['release'];
		}

		$response = wp_remote_get(
			self::API_URL,
			array(
				'timeout' => 10,
				'headers' => array(
					'Accept'     => 'application/vnd.github+json',
					'User-Agent' => 'Divi-Accessibility-Updater/' . $this->version,
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			set_site_transient( self::TRANSIENT_KEY, array( 'release' => null ), HOUR_IN_SECONDS );
			return null;
		}

		$release = json_decode( wp_remote_retrieve_body( $response ), true );
		$release = $this->normalize_release( $release );

		set_site_transient( self::TRANSIENT_KEY, array( 'release' => $release ), self::CACHE_TTL );

		return $release;
	}

	/**
	 * Normalize a GitHub release response into WordPress update metadata.
	 *
	 * @since 2.1.1
	 * @param array|null $release GitHub release response.
	 * @return array|null Normalized release data.
	 */
	private function normalize_release( $release ) {
		if (
			! is_array( $release )
			|| ! empty( $release['draft'] )
			|| ! empty( $release['prerelease'] )
			|| empty( $release['tag_name'] )
			|| empty( $release['assets'] )
			|| ! is_array( $release['assets'] )
		) {
			return null;
		}

		$version = preg_replace( '/^v/i', '', $release['tag_name'] );

		if ( ! preg_match( '/^\d+(?:\.\d+){1,3}(?:[-+][0-9A-Za-z.-]+)?$/', $version ) ) {
			return null;
		}

		$package = $this->find_package_asset( $release['assets'], $version );

		if ( empty( $version ) || empty( $package ) ) {
			return null;
		}

		return array(
			'version'      => $version,
			'tag'          => $release['tag_name'],
			'name'         => ! empty( $release['name'] ) ? $release['name'] : $release['tag_name'],
			'body'         => ! empty( $release['body'] ) ? $release['body'] : '',
			'url'          => ! empty( $release['html_url'] ) ? $release['html_url'] : self::REPOSITORY_URL,
			'published_at' => ! empty( $release['published_at'] ) ? $release['published_at'] : '',
			'package'      => $package,
		);
	}

	/**
	 * Find the packaged plugin zip in a GitHub release's assets.
	 *
	 * @since 2.1.1
	 * @param array  $assets  GitHub release assets.
	 * @param string $version Release version.
	 * @return string|null Package URL.
	 */
	private function find_package_asset( $assets, $version ) {
		$preferred_name = 'divi-accessibility-' . $version . '.zip';
		foreach ( $assets as $asset ) {
			if ( empty( $asset['name'] ) || empty( $asset['browser_download_url'] ) ) {
				continue;
			}

			if ( $preferred_name === $asset['name'] ) {
				return $asset['browser_download_url'];
			}

		}

		return null;
	}

	/**
	 * Build WordPress plugin update data.
	 *
	 * @since 2.1.1
	 * @param array $release Normalized release data.
	 * @return object WordPress update data.
	 */
	private function build_update_data( $release ) {
		return (object) array(
			'id'          => self::REPOSITORY_URL,
			'slug'        => $this->slug,
			'plugin'      => $this->plugin_file,
			'new_version' => $release['version'],
			'url'         => $release['url'],
			'package'     => $release['package'],
		);
	}

	/**
	 * Format release notes for WordPress' plugin information modal.
	 *
	 * @since 2.1.1
	 * @param array $release Normalized release data.
	 * @return string Release notes HTML.
	 */
	private function format_release_notes( $release ) {
		if ( empty( $release['body'] ) ) {
			return sprintf(
				'<p><a href="%s">%s</a></p>',
				esc_url( $release['url'] ),
				esc_html__( 'View release notes on GitHub.', 'divi-accessibility' )
			);
		}

		return wp_kses_post( wpautop( esc_html( $release['body'] ) ) );
	}
}
