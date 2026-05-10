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
		add_filter( 'upgrader_pre_download', array( $this, 'verify_release_package_download' ), 10, 4 );
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
	 * Download and verify this plugin's release package before WordPress installs it.
	 *
	 * @since 2.1.7
	 * @param bool|WP_Error|string $reply      Whether to bail without returning the package.
	 * @param string               $package    The package file name.
	 * @param WP_Upgrader          $upgrader   WordPress upgrader instance.
	 * @param array                $hook_extra Extra arguments passed to hooked filters.
	 * @return bool|WP_Error|string Verified package path, an error, or the original reply.
	 */
	public function verify_release_package_download( $reply, $package, $upgrader, $hook_extra ) {
		unset( $upgrader );

		if ( false !== $reply || empty( $package ) || ! is_string( $package ) ) {
			return $reply;
		}

		if ( ! $this->is_this_plugin_update_context( $hook_extra ) ) {
			return $reply;
		}

		$release = $this->get_release();

		if ( ! $release || empty( $release['package'] ) || empty( $release['checksum'] ) || $package !== $release['package'] ) {
			return $reply;
		}

		$expected_checksum = $this->get_release_package_checksum( $release['checksum'] );

		if ( is_wp_error( $expected_checksum ) ) {
			return $expected_checksum;
		}

		if ( ! function_exists( 'download_url' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$download = download_url( $package );

		if ( is_wp_error( $download ) ) {
			return $download;
		}

		$actual_checksum = hash_file( 'sha256', $download );

		if ( ! $actual_checksum || ! hash_equals( strtolower( $expected_checksum ), strtolower( $actual_checksum ) ) ) {
			wp_delete_file( $download );
			return new WP_Error(
				'divi_accessibility_checksum_mismatch',
				__( 'The Divi Accessibility update package failed checksum verification.', 'divi-accessibility' )
			);
		}

		return $download;
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
			if ( null === $cached['release'] || $this->is_normalized_release_data( $cached['release'] ) ) {
				return $cached['release'];
			}

			delete_site_transient( self::TRANSIENT_KEY );
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
	 * Return whether cached release data matches the current normalized shape.
	 *
	 * @since 2.1.8
	 * @param mixed $release Cached release data.
	 * @return bool Whether the release data is usable.
	 */
	private function is_normalized_release_data( $release ) {
		if ( ! is_array( $release ) ) {
			return false;
		}

		foreach ( array( 'version', 'tag', 'name', 'url', 'package', 'checksum' ) as $required_key ) {
			if ( empty( $release[ $required_key ] ) ) {
				return false;
			}
		}

		return true;
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

		$release_assets = $this->find_release_assets( $release['assets'], $version );

		if ( empty( $version ) || empty( $release_assets['package'] ) || empty( $release_assets['checksum'] ) ) {
			return null;
		}

		return array(
			'version'      => $version,
			'tag'          => $release['tag_name'],
			'name'         => ! empty( $release['name'] ) ? $release['name'] : $release['tag_name'],
			'body'         => ! empty( $release['body'] ) ? $release['body'] : '',
			'url'          => ! empty( $release['html_url'] ) ? $release['html_url'] : self::REPOSITORY_URL,
			'published_at' => ! empty( $release['published_at'] ) ? $release['published_at'] : '',
			'package'      => $release_assets['package'],
			'checksum'     => $release_assets['checksum'],
		);
	}

	/**
	 * Find the packaged plugin zip and checksum in a GitHub release's assets.
	 *
	 * @since 2.1.1
	 * @param array  $assets  GitHub release assets.
	 * @param string $version Release version.
	 * @return array Release asset URLs.
	 */
	private function find_release_assets( $assets, $version ) {
		$preferred_name          = 'divi-accessibility-' . $version . '.zip';
		$preferred_checksum_name = 'divi-accessibility-' . $version . '.zip.sha256';
		$release_assets          = array(
			'package'  => null,
			'checksum' => null,
		);

		foreach ( $assets as $asset ) {
			if ( empty( $asset['name'] ) || empty( $asset['browser_download_url'] ) ) {
				continue;
			}

			if ( $preferred_name === $asset['name'] ) {
				$release_assets['package'] = esc_url_raw( $asset['browser_download_url'] );
				continue;
			}

			if ( $preferred_checksum_name === $asset['name'] ) {
				$release_assets['checksum'] = esc_url_raw( $asset['browser_download_url'] );
			}

		}

		return $release_assets;
	}

	/**
	 * Build WordPress plugin update data.
	 *
	 * @since 2.1.1
	 * @param array $release Normalized release data.
	 * @return object WordPress update data.
	 */
	private function build_update_data( $release ) {
		$checksum = ! empty( $release['checksum'] ) ? $release['checksum'] : '';

		return (object) array(
			'id'          => self::REPOSITORY_URL,
			'slug'        => $this->slug,
			'plugin'      => $this->plugin_file,
			'new_version' => $release['version'],
			'url'         => $release['url'],
			'package'     => $release['package'],
			'checksum'    => $checksum,
		);
	}

	/**
	 * Return whether the current update download belongs to this plugin.
	 *
	 * @since 2.1.7
	 * @param array $hook_extra Extra arguments passed to hooked filters.
	 * @return bool Whether this hook context is for this plugin.
	 */
	private function is_this_plugin_update_context( $hook_extra ) {
		if ( ! is_array( $hook_extra ) ) {
			return false;
		}

		if ( empty( $hook_extra['type'] ) || 'plugin' !== $hook_extra['type'] ) {
			return false;
		}

		$plugins = array();

		if ( ! empty( $hook_extra['plugin'] ) ) {
			$plugins[] = $hook_extra['plugin'];
		}

		if ( ! empty( $hook_extra['plugins'] ) && is_array( $hook_extra['plugins'] ) ) {
			$plugins = array_merge( $plugins, $hook_extra['plugins'] );
		}

		return empty( $plugins ) || in_array( $this->plugin_file, $plugins, true );
	}

	/**
	 * Fetch and parse the SHA-256 checksum published with a release package.
	 *
	 * @since 2.1.7
	 * @param string $checksum_url GitHub release checksum asset URL.
	 * @return string|WP_Error SHA-256 checksum or an error.
	 */
	private function get_release_package_checksum( $checksum_url ) {
		$response = wp_remote_get(
			$checksum_url,
			array(
				'timeout' => 10,
				'headers' => array(
					'Accept'     => 'text/plain',
					'User-Agent' => 'Divi-Accessibility-Updater/' . $this->version,
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return new WP_Error(
				'divi_accessibility_checksum_unavailable',
				__( 'The Divi Accessibility update checksum could not be downloaded.', 'divi-accessibility' )
			);
		}

		$checksum = $this->parse_checksum( wp_remote_retrieve_body( $response ) );

		if ( ! $checksum ) {
			return new WP_Error(
				'divi_accessibility_invalid_checksum',
				__( 'The Divi Accessibility update checksum is invalid.', 'divi-accessibility' )
			);
		}

		return $checksum;
	}

	/**
	 * Parse a SHA-256 checksum from a bare checksum or sha256sum-formatted file.
	 *
	 * @since 2.1.7
	 * @param string $body Checksum file contents.
	 * @return string|null SHA-256 checksum.
	 */
	private function parse_checksum( $body ) {
		if ( ! is_string( $body ) ) {
			return null;
		}

		if ( preg_match( '/(?:^|sha256:|\s)([a-f0-9]{64})(?:\s|$)/i', trim( $body ), $matches ) ) {
			return strtolower( $matches[1] );
		}

		return null;
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
