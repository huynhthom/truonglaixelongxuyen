<?php

namespace CharitablePluginUpdater;

/**
 * Class CharitablePluginUpdater
 */
class CharitablePluginUpdater {

	private $api_url  = '';
	private $api_data = array();
	private $name     = '';
	private $slug     = '';
	private $version  = '';

	/**
	 * Class constructor.
	 *
	 * @uses  plugin_basename()
	 * @uses  hook()
	 *
	 * @param string $_api_url     The URL pointing to the custom API endpoint.
	 * @param string $_plugin_file Path to the plugin file.
	 * @param array  $_api_data    Optional data to send with API calls.
	 */
	public function __construct( $_api_url, $_plugin_file, $_api_data = array() ) {

		// do not apply plugin updating to core plugin, updated 1.7.0.10.
		if ( 'charitable' === basename( $_plugin_file, '.php' ) ) {
			return;
		}

		$this->api_url  = trailingslashit( $_api_url );
		$this->api_data = $_api_data;
		$this->name     = plugin_basename( $_plugin_file );
		$this->slug     = basename( $_plugin_file, '.php' );
		$this->version  = $_api_data['version'];

		// Set up hooks.
		$this->init();
	}

	/**
	 * Set up WordPress filters to hook into WP's update process.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'load-plugins.php', array( $this, 'setup_update_notification' ), 30 );
		add_action( 'admin_init', array( $this, 'show_changelog' ) );
	}

	/**
	 * This disables the default update row shown for Charitable extensions,
	 * and sets up our own callback to show the update notification.
	 *
	 * @since  1.4.20
	 *
	 * @return void
	 */
	public function setup_update_notification() {
		remove_action( 'after_plugin_row_' . $this->name, 'wp_plugin_update_row', 10 );
		add_action( 'after_plugin_row_' . $this->name, array( $this, 'show_update_notification' ), 10, 2 );
	}

	/**
	 * Show update nofication row.
	 *
	 * This is a drop-in replacement for wp_plugin_update_row(),
	 * which is the function that will normally show the update row
	 * for a plugin. Replaced here to show our changelog and also
	 * prompt to the user to renew/set their license if it has
	 * expired or hasn't been added yet.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file
	 * @param array  $plugin
	 */
	public function show_update_notification( $file, $plugin ) {
		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		if ( $this->name != $file ) {
			return;
		}

		$version_info = Charitable_Licenses::get_instance()->get_version_info( $this->name );

		if ( ! $version_info ) {
			return;
		}

		if ( version_compare( $this->version, $version_info->new_version, '<' ) ) {

			// Build a plugin list row, with update notification.
			echo '<tr class="plugin-update-tr" id="' . $this->slug . '-update" data-slug="' . $this->slug . '" data-plugin="' . $this->slug . '/' . $file . '">';
			echo '<td colspan="3" class="plugin-update colspanchange">';
			echo '<div class="update-message notice inline notice-warning notice-alt">';

			$changelog_link = self_admin_url( 'index.php?edd_sl_action=view_plugin_changelog&plugin=' . $this->name . '&slug=' . $this->slug . '&TB_iframe=true&width=772&height=911' );

			if ( isset( $version_info->download_link ) ) {
				switch ( $version_info->download_link ) {
					case 'missing_license':
					case 'expired_license':
					case 'missing_requirements':
						echo htmlspecialchars_decode( $version_info->package_download_restriction );
						break;

					default:
						if ( isset( $version_info->download_link ) !== false ) {
							$name = esc_html( $version_info->name );
						} elseif ( isset( $version_info->slug ) !== false ) {
							$name = esc_html( $version_info->slug );
						} else {
							$name = 'Charitable';
						}
						printf(
							// translators: %1$s is the plugin name, %2$s is the changelog link, %3$s is the new version number, %4$s is the update link.
							__( '<p>There is a new version of %1$s available. <a target="_blank" class="thickbox" href="%2$s">View version %3$s details</a> or <a href="%4$s">update now</a>.</p>', 'charitable' ),
							$name,
							esc_url( $changelog_link ),
							esc_html( $version_info->new_version ),
							esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) )
						);
						break;
				}
			} else {
				if ( isset( $version_info->download_link ) !== false ) {
					$name = esc_html( $version_info->name );
				} elseif ( isset( $version_info->slug ) !== false ) {
					$name = esc_html( $version_info->slug );
				} else {
					$name = 'Charitable';
				}
				printf(
					// translators: %1$s is the plugin name, %2$s is the changelog link, %3$s is the new version number, %4$s is the update link.
					__( '<p>There is a new version of %1$s available. <a target="_blank" class="thickbox" href="%2$s">View version %3$s details</a> or <a href="%4$s">update now</a>.</p>', 'charitable' ),
					$name,
					esc_url( $changelog_link ),
					esc_html( $version_info->new_version ),
					esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) )
				);
			}

			do_action( "in_plugin_update_message-{$file}", $plugin, $version_info );

			echo '</div></td></tr>';
		}
	}

	/**
	 * Display the changelog.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function show_changelog() {
		if ( empty( $_REQUEST['edd_sl_action'] ) || 'view_plugin_changelog' != $_REQUEST['edd_sl_action'] ) {
			return;
		}

		if ( empty( $_REQUEST['plugin'] ) ) {
			return;
		}

		if ( empty( $_REQUEST['slug'] ) ) {
			return;
		}

		if ( ! current_user_can( 'update_plugins' ) ) {
			wp_die( __( 'You do not have permission to install plugin updates', 'charitable' ), __( 'Error', 'charitable' ), array( 'response' => 403 ) );
		}

		$version_info = Charitable_Licenses::get_instance()->get_version_info( $_REQUEST['plugin'] );

		if ( $version_info && isset( $version_info->sections['changelog'] ) ) {
			echo '<div style="padding:10px;">' . $version_info->sections['changelog'] . '</div>';
		}

		exit;
	}
}
