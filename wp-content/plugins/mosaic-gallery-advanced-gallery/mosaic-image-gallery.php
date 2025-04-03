<?php 
/*
* Plugin Name: Mosaic Gallery - Advanced Gallery
* Description: Mosaic Gallery is an advanced WordPress plugin for creating stunning, responsive mosaic-style galleries with ease, offering customizable layouts and effects.
* Version: 1.0.8
* Author: misbahwp
* Plugin URI: 
* Text Domain: mosaic-image-gallery
* License: GPL-2.0+
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}

class Mosaic_Image_Gallery {

	/**
     * Constructor for the Mosaic_Image_Gallery class
     */
    public function __construct(){
        define( 'MIGY_VERSION', '1.0.8' );
        define( 'MIGY_GALLERY_SHORTCODE', 'migy_gallery' );
		define( 'MIGY_PLUGIN_ASSEST', trailingslashit(plugins_url( 'assets', __FILE__ )) );
		define( 'MIGY_CSS_URI', MIGY_PLUGIN_ASSEST.'css' );
        define( 'MIGY_JS_URI', MIGY_PLUGIN_ASSEST.'js' );
        define( 'MIGY_API_URL', 'https://license.misbahwp.com/api/general/' );
        define( 'MIGY_MAIN_URL', 'https://www.misbahwp.com/' );
		
        add_action('init', array($this, 'mosaic_image_gallery_localization_setup'));
		
		//Require gallery functions
		require_once plugin_dir_path( __FILE__ ) . 'includes/gallery-functions.php';

		//Require admin functions
		require_once plugin_dir_path( __FILE__ ) . 'includes/admin.php';

        // Require our themes menu functions
        require_once plugin_dir_path( __FILE__ ) . 'menu/admin-menu.php';

        // Require for data request
        require_once plugin_dir_path( __FILE__ ) . 'ajax/ajax.php';

        // Require templates modal files
        require_once plugin_dir_path( __FILE__ ) . 'includes/template-modal.php';
    }
	
	/**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function mosaic_image_gallery_localization_setup() {
        load_plugin_textdomain('mosaic-image-gallery', false, dirname(__FILE__));
    }    
    
}
new Mosaic_Image_Gallery();


add_action('admin_notices', 'migy_admin_notice_with_html');
function migy_admin_notice_with_html() {
    ?>
    <div class="notice is-dismissible migy">
        <div class="migy-notice-banner-wrap">
            <img src="<?php echo esc_url( MIGY_PLUGIN_ASSEST . '/images/notice-background.png'); ?>" alt="">
            <div class="migy-notice-heading">
                <h1 class="migy-main-head"><?php echo esc_html('WORDPRESS THEME BUNDLE - 80+ THEMES');?></h1>
                <h4 class="migy-sub-head"><?php echo esc_html('Get Our Theme Pack of 80+ Wordpress Themes');?><strong><?php echo esc_html(' AT $89'); ?></strong></h4>
                <div class="migy-notice-btn">
                    <a class="migy-buy-btn" target="_blank" href="<?php echo esc_url( MIGY_MAIN_URL . 'products/wordpress-bundle' ); ?>"><?php echo esc_html('Shop Now');?></a>
                </div>
            </div>

        </div>
    </div>
    <?php
}