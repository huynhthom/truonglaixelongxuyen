<?php
/**
 * Activation handler for Charitable extensions.
 *
 * @package     Charitable\Activation Handler
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Charitable_Extension_Activation
 *
 * @since       1.0.0
 */
class Charitable_Extension_Activation {

	public $plugin_name, $plugin_path, $plugin_file, $has_charitable, $charitable_base;

	/**
	 * Setup the activation class
	 *
	 * @param   string $plugin_path Path to this plugin's directory.
	 * @param   string $plugin_file Core plugin file.
	 * @return  void
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct( $plugin_path, $plugin_file ) {
		// We need plugin.php!
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // @codingStandardsIgnoreLine

		$plugins = get_plugins();

		// Set plugin directory.
		$plugin_path       = array_filter( explode( '/', $plugin_path ) );
		$this->plugin_path = end( $plugin_path );

		// Set plugin file.
		$this->plugin_file = $plugin_file;

		// Set plugin name.
		if ( isset( $plugins[ $this->plugin_path . '/' . $this->plugin_file ]['Name'] ) ) {
			$this->plugin_name = str_replace( 'Charitable - ', '', $plugins[ $this->plugin_path . '/' . $this->plugin_file ]['Name'] );
		} else {
			$this->plugin_name = __( 'This plugin', 'charitable' );
		}

		// Is EDD installed?
		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( $plugin['Name'] == 'Charitable' ) {
				$this->has_charitable  = true;
				$this->charitable_base = $plugin_path;
				break;
			}
		}
	}


	/**
	 * Process plugin deactivation
	 *
	 * @return      void
	 * @access      public
	 * @since       1.0.0
	 */
	public function run() {
		add_action( 'admin_notices', [ $this, 'missing_charitable_notice' ] );
	}


	/**
	 * Display notice if Charitable isn't installed
	 *
	 * @return  void
	 * @access  public
	 * @since   1.0.0
	 */
	public function missing_charitable_notice() {
		if ( $this->has_charitable ) {
			$url  = esc_url( wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $this->charitable_base ), 'activate-plugin_' . $this->charitable_base ) );
			$link = '<a href="' . $url . '">' . __( 'activate it', 'charitable' ) . '</a>';
		} else {
			$url  = esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=charitable' ), 'install-plugin_charitable' ) );
			$link = '<a href="' . $url . '">' . __( 'install it', 'charitable' ) . '</a>';
		}

		// translators: %s is a link to the Charitable plugin.
		echo '<div class="error"><p>' . esc_html( $this->plugin_name ) . wp_kses_post( sprintf( __( ' requires Charitable! Please %s to continue!', 'charitable' ), $link ) ) . '</p></div>';
	}
}
