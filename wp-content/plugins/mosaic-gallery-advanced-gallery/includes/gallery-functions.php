<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}

class MIGY_Gallery_Functions {
	
	public function __construct(){
        
        add_action( 'init', array($this, 'init_plugin') );
        add_shortcode(MIGY_GALLERY_SHORTCODE, array($this, 'mosaic_image_gallery_scode'));
        add_action( 'init', array($this, 'migy_register_taxonomy') );
		add_action('wp_enqueue_scripts', array($this,'mosaic_image_gallery_scripts'));
        add_action('enqueue_block_editor_assets', array($this,'mosaic_image_gallery_editor_scripts'));
		add_action('admin_enqueue_scripts', array($this,'admin_scripts'));
    }
	
	//Initializes the plugin
    public function init_plugin(){
        
		//Register post type
        register_post_type('migy_image_gallery', array(
            'labels'=>array(
                'name'=>'Mosaic Gallery',
                'all_items'=> __( 'All Galleries', 'mosaic-image-gallery' ),
                'add_new'=> __( 'Add Gallery', 'mosaic-image-gallery' ),
                'add_new_item' => __( 'Add new Gallery', 'mosaic-image-gallery' ),
                'edit_item'  => __( 'Edit Gallery', 'mosaic-image-gallery' ),
                'view_items' => __( 'View Galleries', 'mosaic-image-gallery' ),
                'not_found' => __( 'No gallery found', 'mosaic-image-gallery' ),
                'not_found_in_trash' => __( 'No gallery found in trash', 'mosaic-image-gallery' )
            ),
            'public'=>true,
            'menu_icon'=>'dashicons-images-alt2',
            'supports'=>array('title')
        ));
        
    }
	
	//Register taxonomy
	public function migy_register_taxonomy() {
        $taxonomy = 'migy-filter-category';
		$args = array(
            'label'        => __( 'Filter category', 'mosaic-image-gallery' ),
            'public'       => true,
            'rewrite'      => false,
            'hierarchical' => true
        );

        register_taxonomy( $taxonomy, 'migy_image_gallery', $args );
		
		//Create Uncategorized term
		$uncategorized = array(
			'name' => 'Uncategorized',
			'slug' => 'uncategorized',
		);
		
		$term = wp_insert_term( $uncategorized['name'], $taxonomy, array(
			'slug' => $uncategorized['slug'],
		));
		
		// Set the term as default for the taxonomy
		if ( !is_wp_error( $term ) ) {
			update_option($taxonomy . "_default", $term['term_id']);
		}
    }

    public function mosaic_image_gallery_editor_scripts() {

        wp_enqueue_style('migy-editor-css', MIGY_CSS_URI . '/editor.css', array(), MIGY_VERSION);

        wp_register_script(
            'migy-editor-js',
            MIGY_JS_URI . '/editor.js',
            array( 'jquery' ),
            MIGY_VERSION,
            true
        );

        $localize_arr = array(
            'bundle_image'      =>  MIGY_PLUGIN_ASSEST . '/images/bundle-image.png'
        );
    
        wp_localize_script(
            'migy-editor-js',
            'migy_editor_js',
            $localize_arr
        );
        wp_enqueue_script( 'migy-editor-js' );
    }
    
	//Enqueue scripts
    public function mosaic_image_gallery_scripts() {
        // Define the version number
        $version = MIGY_VERSION; // Assuming MIGY_VERSION is defined elsewhere in your codebase
    
        // CSS style
        wp_enqueue_style('migy-viewercss', MIGY_CSS_URI.'/viewer.css', array(), $version);
        wp_enqueue_style('migy-styles', MIGY_CSS_URI.'/styles.css', array(), $version);

        wp_enqueue_script('masonry');
    
        // JS script
        wp_enqueue_script('migy-viewerjs', MIGY_JS_URI.'/viewer.js', array('jquery'), $version, true);
        wp_enqueue_script('migy-mixitup', MIGY_JS_URI.'/mixitup.min.js', array('jquery'), $version, true);
        wp_enqueue_script('migy-scripts', MIGY_JS_URI.'/scripts.js', array('jquery'), $version, true);
    }
	
	//Enqueue admin scripts
    public function admin_scripts($hook){

        if ( $hook == 'migy_image_gallery_page_migy_templates' ) {
            wp_enqueue_style('migy-admin-menu-page', MIGY_PLUGIN_ASSEST.'admin/css/admin-templates.css', array(), MIGY_VERSION);    
        }
        //CSS style
        wp_enqueue_style('migy-admin-styles', MIGY_PLUGIN_ASSEST.'admin/css/admin-style.css', array(), MIGY_VERSION);
        //JS script
		global $post_type;
		if( 'migy_image_gallery' == $post_type) {
			if(function_exists('wp_enqueue_media')) {
				wp_enqueue_media();
			}
			else {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
			}
		}
        wp_enqueue_script('migy-admin-scripts', MIGY_PLUGIN_ASSEST.'admin/js/admin-scripts.js', array('jquery'), MIGY_VERSION, true);

        wp_localize_script('migy-admin-scripts', 'migy_pagination_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('migy_create_pagination_nonce_action')
        ));
    }
	
    //Gallery shortcode
    public function mosaic_image_gallery_scode($imigy_attr, $imigy_content){
        $scode_atts = shortcode_atts(array(
                'id'=>''
        ),$imigy_attr);
        
        extract($scode_atts);

        $filter_button_bg_color = !empty(get_post_meta($id, 'migy_filter_button_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_bg_color', true) : '#f5f5f5';
        $filter_button_text_color = !empty(get_post_meta($id, 'migy_filter_button_text_color', true)) ? get_post_meta($id, 'migy_filter_button_text_color', true) : '#222';

        $filter_button_bg_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_bg_color', true)) ? get_post_meta($id, 'migy_filter_button_active_bg_color', true) : '#16a085';
        $filter_button_text_active_color = !empty(get_post_meta($id, 'migy_filter_button_active_text_color', true)) ? get_post_meta($id, 'migy_filter_button_active_text_color', true) : '#fff';

        $custom_css = "";
        $custom_css .= ".migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button {
            background-color: " . $filter_button_bg_color . ";
            border: 1px solid " . $filter_button_bg_color . ";
            color: " . $filter_button_text_color . ";
        }";

        $custom_css .= ".migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button.active,
        .migy-img-viewer-" . $id . " .migy-filter-buttons button.migy-filter-button:hover {
            background-color: " . $filter_button_bg_active_color . ";
            color: " . $filter_button_text_active_color . ";
            border: 1px solid " . $filter_button_bg_active_color . ";
        }";

        wp_enqueue_style('migy-custom-styles', MIGY_CSS_URI.'/custom-styles.css', array(), MIGY_VERSION);
        wp_add_inline_style('migy-custom-styles', $custom_css);

        ob_start();

        include plugin_dir_path( __FILE__ ) . '../templates/gallery.php';

    	return ob_get_clean();
    }
}

new MIGY_Gallery_Functions();
