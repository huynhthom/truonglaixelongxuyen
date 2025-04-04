<?php 
/*
Plugin Name: Wp Service Box
Plugin URI: httts://wordpress.org/plugins/wp-service-box
Author: Nayon
Author Uri: http://www.nayonbd.com
Description:Service Box is simple, responsive, lightweight plugin for creating responsive service box.
Version:1.0
*/

class sbw_main_class{

	public function __construct(){
		add_action('init',array($this,'sbw_main_area'));
		add_action('wp_enqueue_scripts',array($this,'sbw_main_script_area'));
		add_shortcode('service-box',array($this,'sbw_main_shortcode_area'));
	}

	public function sbw_main_area(){
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		load_plugin_textdomain('sbw_photo_textdomain', false, dirname( __FILE__).'/lang');
		register_post_type('service-box',array(
			'labels'=>array(
				'name'=>'Service Box'
			),
			'public'=>true,
			'supports'=>array('title','thumbnail','editor'),
			'menu_icon'=>'dashicons-palmtree'
	    ));

	}
	public function sbw_main_script_area(){
		wp_enqueue_style('bootstrapcss',PLUGINS_URL('css/bootstrap.min.css',__FILE__));
		wp_enqueue_style('font-awesome',PLUGINS_URL('css/font-awesome.min.css',__FILE__));
		wp_enqueue_style('owl-carouselcss',PLUGINS_URL('css/owl.carousel.min.css',__FILE__));
		wp_enqueue_style('service-maincss',PLUGINS_URL('css/style.css',__FILE__));
		wp_enqueue_script('owl-carouseljs',PLUGINS_URL('js/owl.carousel.min.js',__FILE__),array('jquery'));
		wp_enqueue_script('customjs',PLUGINS_URL('js/main.js',__FILE__),array('jquery'));

	}

	public function sbw_main_shortcode_area($attr,$content){
	ob_start();
	?>
	<!-- TESTIMONIALS -->
	<section class="testimonials">
		<div class="container">
			  <div class="row">
			    <div class="col-sm-12">
			      <div id="customers-testimonials" class="owl-carousel">
					<?php $sbox = new wp_Query(array(
						'post_type'=>'service-box'
					));
					while( $sbox->have_posts() ) : $sbox->the_post();
					?>		
			        <!--TESTIMONIAL 1 -->
			        <div class="item">
			            <div class="shadow-effect">
			                <?php the_post_thumbnail(); ?>
			                <div class="item-details">
							<h5><?php the_title(); ?></h5>
							<p><?php the_content(); ?></p>
							</div>
			            </div>
			        </div>
			        <!--END OF TESTIMONIAL 1 -->
					<?php endwhile; ?>	            
			      </div>
			    </div>
			  </div>
		  </div>
	</section>
	<!-- END OF TESTIMONIALS -->
	<?php
	return ob_get_clean();
}

}
new sbw_main_class();





