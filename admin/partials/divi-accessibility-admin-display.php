<?php

/**
 * Provide an admin area view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://campuspress.com
 * @since      1.0.0
 *
 * @package    Divi_Accessibility
 * @subpackage Divi_Accessibility/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$tabs              = $this->get_dashboard_tabs();
$settings_by_tab   = $this->get_dashboard_settings();
$active_tab        = $this->get_active_dashboard_tab();
$active_tab_config = $tabs[ $active_tab ];
$active_settings   = isset( $settings_by_tab[ $active_tab ] ) ? $settings_by_tab[ $active_tab ] : array();
$settings_url      = admin_url( 'admin.php?page=' . $this->da11y );
$accessibility_url = add_query_arg( 'tab', 'accessibility', $settings_url );
$resources_url     = add_query_arg( 'tab', 'resources', $settings_url );
$github_url        = 'https://github.com/RichardGeorgeDavis/divi-accessibility';
$resources         = array(
	array(
		'title'       => __( 'Web Content Accessibility Guidelines (WCAG) 2.2', 'divi-accessibility' ),
		'description' => __( 'The current W3C accessibility standard used as the primary reference for accessible web content.', 'divi-accessibility' ),
		'url'         => 'https://www.w3.org/TR/WCAG22/',
	),
	array(
		'title'       => __( 'WAI-ARIA Authoring Practices Guide', 'divi-accessibility' ),
		'description' => __( 'Patterns for keyboard interaction, roles, states, and properties in accessible interfaces.', 'divi-accessibility' ),
		'url'         => 'https://www.w3.org/WAI/ARIA/apg/',
	),
	array(
		'title'       => __( 'Tota11y', 'divi-accessibility' ),
		'description' => __( 'An accessibility visualization tool that can be enabled from the Tools tab for admin users.', 'divi-accessibility' ),
		'url'         => 'https://khan.github.io/tota11y/',
	),
	array(
		'title'       => __( 'Divi Accessibility on GitHub', 'divi-accessibility' ),
		'description' => __( 'Source code, releases, and issue tracking for this maintained fork.', 'divi-accessibility' ),
		'url'         => $github_url,
	),
	array(
		'title'       => __( 'CampusPress', 'divi-accessibility' ),
		'description' => __( 'Original creator credit is preserved while this fork is maintained independently.', 'divi-accessibility' ),
		'url'         => 'https://campuspress.com',
	),
);
?>

<div class="wrap da11y-wrap">
	<?php settings_errors(); ?>

	<div id="da11y-dashboard">
		<div class="lc-kit-head da11y-dashboard-head">
			<div>
				<h1 id="da11y-dashboard-title"><?php esc_html_e( 'Divi Accessibility', 'divi-accessibility' ); ?></h1>
				<p>
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: plugin version */
							__( 'Version %s', 'divi-accessibility' ),
							$this->version
						)
					);
					?>
				</p>
			</div>
			<div class="da11y-dashboard-actions">
				<a class="t-sett" href="<?php echo esc_url( $resources_url ); ?>"><?php esc_html_e( 'Resources', 'divi-accessibility' ); ?></a>
				<a href="<?php echo esc_url( $github_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'GitHub', 'divi-accessibility' ); ?></a>
			</div>
		</div>

		<h2 class="nav-tab-wrapper da11y-nav-tab-wrapper">
			<?php foreach ( $tabs as $tab_key => $tab ) : ?>
				<a
					href="<?php echo esc_url( add_query_arg( 'tab', $tab_key, $settings_url ) ); ?>"
					class="nav-tab <?php echo $active_tab === $tab_key ? 'nav-tab-active' : ''; ?>"
					<?php echo $active_tab === $tab_key ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $tab['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</h2>

		<div class="page-container da11y-page-container">
			<div class="toolbox da11y-tab-intro-wrap">
				<div class="info da11y-tab-intro">
					<h4><?php echo esc_html( $active_tab_config['label'] ); ?></h4>
					<p><?php echo esc_html( $active_tab_config['description'] ); ?></p>
				</div>
			</div>

			<?php if ( ! empty( $active_tab_config['has_form'] ) ) : ?>
				<form action="options.php" method="post" class="et-divi-lc-kit-form da11y-settings-form" id="da11y_settings_form">
					<?php settings_fields( $this->da11y ); ?>
					<input type="hidden" name="<?php echo esc_attr( $this->da11y_options ); ?>[__active_tab]" value="<?php echo esc_attr( $active_tab ); ?>" />

					<div class="tool-wrap da11y-tool-wrap">
						<?php foreach ( $active_settings as $setting ) : ?>
							<?php
							$name        = $setting['name'];
							$type        = $setting['type'];
							$label_for   = $this->da11y . '_' . $name;
							$title_id    = $label_for . '_title';
							$description = isset( $setting['description'] ) ? $setting['description'] : '';
							$subtext     = isset( $setting['subtext'] ) ? $setting['subtext'] : '';
							?>
							<div class="lc-kit da11y-setting-row">
								<div class="box-title da11y-setting-title">
									<h3 id="<?php echo esc_attr( $title_id ); ?>"><?php echo esc_html( $setting['title'] ); ?></h3>
									<?php if ( '' !== $description ) : ?>
										<div class="box-descr da11y-setting-description">
											<p><?php echo wp_kses_post( $description ); ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="box-content minibox da11y-setting-control <?php echo 'color' === $type ? 'da11y-setting-control-color' : ''; ?> <?php echo in_array( $type, array( 'text', 'textarea', 'select' ), true ) ? 'da11y-setting-control-text' : ''; ?>">
									<?php
									if ( 'color' === $type ) {
										$this->divi_accessibility_color_picker_cb(
											array(
												'name'          => $name,
												'label_for'     => $label_for,
												'label_subtext' => $subtext,
												'labelledby'    => $title_id,
											)
										);
									} elseif ( in_array( $type, array( 'text', 'textarea' ), true ) ) {
										$this->divi_accessibility_text_cb(
											array(
												'name'          => $name,
												'label_for'     => $label_for,
												'label_subtext' => $subtext,
												'labelledby'    => $title_id,
												'type'          => $type,
											)
										);
									} elseif ( 'select' === $type ) {
										$this->divi_accessibility_select_cb(
											array(
												'name'          => $name,
												'label_for'     => $label_for,
												'label_subtext' => $subtext,
												'labelledby'    => $title_id,
												'options'       => isset( $setting['options'] ) ? $setting['options'] : array(),
											)
										);
									} else {
										$this->divi_accessibility_checkbox_cb(
											array(
												'name'          => $name,
												'label_for'     => $label_for,
												'label_text'    => __( 'Enabled', 'divi-accessibility' ),
												'label_subtext' => $subtext,
												'label_class'   => 'da11y-hurkan-switch',
												'labelledby'    => $title_id,
											)
										);
									}
									?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div id="et-epanel-bottom" class="da11y-save-bar">
						<button type="submit" id="da11y-epanel-save" class="button et-save-button da11y-save-button"><?php esc_html_e( 'Save Settings', 'divi-accessibility' ); ?></button>
					</div>
				</form>
			<?php else : ?>
				<div class="sett-wrap da11y-resource-grid">
					<?php foreach ( $resources as $resource ) : ?>
						<div class="tool-wrap da11y-resource-card">
							<a class="lc-kit" href="<?php echo esc_url( $resource['url'] ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
								<span class="da11y-resource-title"><?php echo esc_html( $resource['title'] ); ?></span>
								<span class="da11y-resource-description"><?php echo esc_html( $resource['description'] ); ?></span>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="da11y-foot-links">
		<a href="<?php echo esc_url( $accessibility_url ); ?>"><?php esc_html_e( 'Plugin Settings', 'divi-accessibility' ); ?></a>
		<a href="<?php echo esc_url( $resources_url ); ?>"><?php esc_html_e( 'Resources', 'divi-accessibility' ); ?></a>
		<a href="<?php echo esc_url( $github_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Support', 'divi-accessibility' ); ?></a>
	</div>
</div>
