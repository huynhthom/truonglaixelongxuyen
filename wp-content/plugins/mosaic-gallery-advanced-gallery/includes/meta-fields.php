<?php 
	if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!-- Tab: content and style -->
<div class="migy-content-and-style-tabs">
	<ul>
		<li class="migy-tab-content migy-tab-active">Contents</li>
		<li class="migy-tab-style">Styles</li>
		<li class="migy-tab-shortcode">Shortcode</li>
	</ul>
</div>



<!-- Start content tab-->
<div class="migy-tab-data-contents">
	<h4 class="migy-gallery-settings-heading"><?php echo esc_html__('Gallery type', 'mosaic-image-gallery'); ?></h4>
	<div class="migy-filter-type-tabs">
	<?php
		$migy_gallery_type = !empty(get_post_meta($post->ID, 'migy_gallery_type', true)) ? get_post_meta($post->ID, 'migy_gallery_type', true) : 'image_gallery';
		?>
	<input class="migy_gallery_type" type="radio" name="migy_gallery_type" id="migy_type_image_gallery" value="image_gallery" <?php checked('image_gallery', $migy_gallery_type, true); ?>>
	<label for="migy_type_image_gallery" class="migy-filter-type-tab"><?php echo esc_html__('Image gallery', 'mosaic-image-gallery'); ?></label>
	<input class="migy_gallery_type" type="radio" name="migy_gallery_type" id="migy_type_filterable_gallery" value="filterable_gallery" <?php checked('filterable_gallery', $migy_gallery_type, true); ?>>
	<label for="migy_type_filterable_gallery" class="migy-filter-type-tab"><?php echo esc_html__('Filterable image gallery', 'mosaic-image-gallery'); ?></label>
</div>


	<hr>
	<?php
		$hide_show_category_field = '';
		if($migy_gallery_type == 'image_gallery'){
			$hide_show_category_field = 'hidden-if-image-gallery';
		}
		?>
	<h4 class="migy-gallery-settings-heading left-align"><?php echo esc_html__('Add gallery images','mosaic-image-gallery'); ?></h4>
	<div class="migy-repeater-container">
		<div class="migy-field-item-clone" style="display:none">
			<div id="migy_field_item_clone" class="migy-field-item">
				<div class="migy-repeater-action-buttons">
					<span class="dashicons dashicons-move"></span>
					<img class="migy-gallery-perview-image" src="">
					<div><span class="toggle-button dashicons dashicons-arrow-up-alt2"></span><a href="#" class="migy-remove-field"><?php echo esc_html__('Remove','mosaic-image-gallery'); ?></a></div>
				</div>
				<div class="migy-gallery-fields-wrapper">
					<ul>
					<li>
	<label class="migy-gallery-form-control-lebel"><?php echo esc_html__('Upload Image or Enter URL', 'mosaic-image-gallery'); ?></label>
	<div class="migy-image-field-wrappper">
		<input class="migy-gallery-form-control migy-image-url" type="text" name="xxx_migy_gallery_image_url[]" value="" placeholder="<?php echo esc_html__('Enter image URL', 'mosaic-image-gallery'); ?>">
		<a class="migy-gallery-image-upload button button-primary button-large migy-image-upload" href="#"><?php echo esc_html__('Upload', 'mosaic-image-gallery'); ?></a>
	</div>
</li>
<li>
<label class="migy-gallery-form-control-label"><?php echo esc_html__('Image Title', 'mosaic-image-gallery'); ?></label>
<input class="migy-gallery-form-control" type="text" name="xxx_migy_image_title[]" value="" placeholder="<?php echo esc_html__('Enter image title', 'mosaic-image-gallery'); ?>">

</li>

<li>
	<label class="migy-gallery-form-control-lebel"><?php echo esc_html__('Image Description', 'mosaic-image-gallery'); ?></label>
	<input class="migy-gallery-form-control" type="text" name="xxx_migy_image_description[]" value="" placeholder="<?php echo esc_html__('Enter image description', 'mosaic-image-gallery'); ?>">
</li>
<!-- i add -->
<li>
	<label class="migy-gallery-form-control-lebel"><?php echo esc_html__('Image alt tag', 'mosaic-image-gallery'); ?></label>
	<input class="migy-gallery-form-control" type="text" name="xxx_migy_image_alt[]" value="" placeholder="<?php echo esc_html__('Enter image alt', 'mosaic-image-gallery'); ?>">
</li>

						<!-- end -->

						<li class="migy_filter_category_field <?php echo esc_attr($hide_show_category_field); ?>">
	<label class="migy-gallery-form-control-lebel"><?php echo esc_html__('Filter Category', 'mosaic-image-gallery'); ?></label>
	<select name="migy_filter_category[]" class="migy-filter-category migy-gallery-form-control">
		<?php 
		$taxonomy = 'migy-filter-category';
		$migy_terms = get_terms( array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
		) );
		
		$default_term_id = get_option($taxonomy . "_default");
		
		// Reorder the terms array to make the default term appear first
		usort( $migy_terms, function( $a, $b ) use ( $default_term_id ) {
			if ( $a->term_id == $default_term_id ) {
				return -1;
			}
			if ( $b->term_id == $default_term_id ) {
				return 1;
			}
			return 0;
		});
		
		foreach ( $migy_terms as $migy_term ) {
			echo '<option value="' . esc_attr($migy_term->term_id) . '">' . esc_html($migy_term->name) . '</option>';
		}
		?>
	</select>
</li>

					</ul>
				</div>
			</div>
		</div>
		<div id="migy-repeatable-fields">
		<?php 
    $migy_gallery_items = !empty(get_post_meta($post->ID, 'migy_gallery_items', true)) ? get_post_meta($post->ID, 'migy_gallery_items', true) : array(); 
    $xx = 0;
    foreach( $migy_gallery_items as $migy_gallery_item ):
        if (array_key_exists("image_url", $migy_gallery_item)){
            $image_url = $migy_gallery_item['image_url'];
        } else {
            $image_url = '';
        }
        if (array_key_exists("image_title", $migy_gallery_item)){
            $image_title = $migy_gallery_item['image_title'];
        } else {
            $image_title = '';
        }
        if (array_key_exists("image_description", $migy_gallery_item)){
            $image_description = $migy_gallery_item['image_description'];
        } else {
            $image_description = '';
        }
        if (array_key_exists("image_alt", $migy_gallery_item)){
            $image_alt = $migy_gallery_item['image_alt'];
        } else {
            $image_alt = '';
        }
?>




<div class="migy-field-item">
    <div class="migy-repeater-action-buttons">
        <span class="dashicons dashicons-move"></span>
        <img class="migy-gallery-perview-image" src="<?php echo esc_url($image_url); ?>">
        <div><span class="toggle-button dashicons dashicons-arrow-up-alt2"></span><a href="#" class="migy-remove-field"><?php echo esc_html__('Remove','mosaic-image-gallery'); ?></a></div>
    </div>
    <div class="migy-gallery-fields-wrapper">
        <ul>
		<li>
    <label class="migy-gallery-form-control-label"><?php echo esc_html__('Upload Image or Enter URL', 'mosaic-image-gallery'); ?></label>
    <div class="migy-image-field-wrapper">
        <input class="migy-gallery-form-control migy-image-url" type="text" name="migy_gallery_image_url[]" value="<?php echo esc_url($image_url); ?>" placeholder="<?php echo esc_html__('Enter image URL', 'mosaic-image-gallery'); ?>">
        <a class="migy-gallery-image-upload button button-primary button-large migy-image-upload" href="#"><?php echo esc_html__('Upload', 'mosaic-image-gallery'); ?></a>
    </div>
</li>
<li>
    <label class="migy-gallery-form-control-label"><?php echo esc_html__('Image Title', 'mosaic-image-gallery'); ?></label>
    <input class="migy-gallery-form-control" type="text" name="migy_image_title[]" value="<?php echo esc_html($image_title); ?>" placeholder="<?php echo esc_html__('Enter image title', 'mosaic-image-gallery'); ?>">
</li>
<li class="migy_disabled_field-">
    <label class="migy-gallery-form-control-label"><?php echo esc_html__('Image Description', 'mosaic-image-gallery'); ?></label>
    <input class="migy-gallery-form-control" type="text" name="migy_image_description[]" value="<?php echo esc_html($image_description); ?>" placeholder="<?php echo esc_html__('Enter image description', 'mosaic-image-gallery'); ?>">
</li>
<li class="migy_disabled_field-">
    <label class="migy-gallery-form-control-label"><?php echo esc_html__('Image Alt', 'mosaic-image-gallery'); ?></label>
    <input class="migy-gallery-form-control" type="text" name="migy_image_alt[]" value="<?php echo esc_html($image_alt); ?>" placeholder="<?php echo esc_html__('Enter image Alt', 'mosaic-image-gallery'); ?>">
</li>

            <li class="migy_filter_category_field  <?php echo esc_attr($hide_show_category_field); ?>">
                <label class="migy-gallery-form-control-lebel"><?php echo esc_html__('Filter Category','mosaic-image-gallery'); ?></label>
                <?php
                $filter_category = is_array($migy_gallery_item['filter_category']) ? $migy_gallery_item['filter_category'] : array();
                ?>
                <select name="migy_filter_category[]" class="migy-filter-category migy-gallery-form-control">
                    <?php
                    $taxonomy = 'migy-filter-category';
                    $migy_terms = get_terms( array(
                        'taxonomy' => $taxonomy,
                        'hide_empty' => false,
                    ) );
                    
                    $default_term_id = get_option($taxonomy . "_default");
                    
                    // Reorder the terms array to make the default term appear first
                    usort( $migy_terms, function( $a, $b ) use ( $default_term_id ) {
                        if ( $a->term_id == $default_term_id ) {
                            return -1;
                        }
                        if ( $b->term_id == $default_term_id ) {
                            return 1;
                        }
                        return 0;
                    });
                    
                    foreach ( $migy_terms as $migy_term ) {
                        $selected = '';
                        if(in_array($migy_term->term_id, $filter_category)){
                            $selected = 'selected';
                        }
                        echo '<option value="' . esc_attr($migy_term->term_id) . '" '.esc_attr($selected).'>' . esc_html($migy_term->name) . '</option>';
                    }
                    ?>
                </select>
            </li>
        </ul>
    </div>
</div>




			<?php $xx++; endforeach; //end item?>
		</div>
		<div class="migy-add-more-wrapper"><a href="#" id="migy-add-field"><span class="dashicons dashicons-plus-alt2"></span> <?php echo esc_html__('Add image','mosaic-image-gallery'); ?></a></div>
	</div>
	<hr>
	<p>
    <?php
        $display_image_title = !empty(get_post_meta($post->ID, 'migy_display_image_title', true)) ? get_post_meta($post->ID, 'migy_display_image_title', true) : '';
    ?>
    <label for="display-title">
        <input id="display-title" name="migy_display_image_title" type="checkbox" value="yes" <?php checked('yes', $display_image_title, true); ?>> 
        <strong>Display Image Info</strong>
    </label>
</p>

	<hr>
	<p>
    <?php
        $migy_display_image_description = !empty(get_post_meta($post->ID, 'migy_display_image_description', true)) ? get_post_meta($post->ID, 'migy_display_image_description', true) : '';
    ?>
    <label for="display-description">
        <input id="display-description" name="migy_display_image_description" type="checkbox" value="yes" <?php checked('yes', $migy_display_image_description, true); ?>> 
        <strong>Display Image Description</strong>
    </label>
</p>



	<hr>
	<p>
    <?php
        $migy_masonry_layout = !empty(get_post_meta($post->ID, 'migy_masonry_layout', true)) ? get_post_meta($post->ID, 'migy_masonry_layout', true) : '';
    ?>
    <label for="masonry_layout">
        <input id="masonry_layout" name="migy_masonry_layout" type="checkbox" value="yes" <?php checked('yes', $migy_masonry_layout, true); ?>> 
        <strong>Enable Masonry Layout</strong>
    </label>
</p>

</div>
<!-- End content tab -->

<!-- Start style tab -->
<div class="migy-tab-data-styles">
	<h4 class="migy-gallery-settings-heading left-align"><?php echo esc_html__('Style Settings','mosaic-image-gallery'); ?></h4>
	<table class="migy-style-meta-table">
		<tbody>
			<tr>
				<td>
					<?php
					$migy_gallery_column = !empty(get_post_meta($post->ID, 'migy_gallery_column', true)) ? get_post_meta($post->ID, 'migy_gallery_column', true) : 'three-column';
					?>
					<label for="gallery_column"><strong>Item Columns</strong></label>
				</td>
				<td>
				<select id="gallery_column" class="migy-form-field" name="migy_gallery_column">
    <option value="two-column" <?php selected('two-column', $migy_gallery_column, true); ?>>2 Columns</option>
    <option value="three-column" <?php selected('three-column', $migy_gallery_column, true); ?>>3 Columns</option>
    <option value="four-column" <?php selected('four-column', $migy_gallery_column, true); ?>>4 Columns</option>
</select>

				</td>
			</tr>
			<tr>
				<td>
					<?php
$migy_gallery_item_space = !empty(get_post_meta($post->ID, 'migy_gallery_item_space', true)) ? get_post_meta($post->ID, 'migy_gallery_item_space', true) : 'five-px';
?>
					<label for="gallery_item_space"><strong>Item Space</strong></label>
				</td>
				<td>
				<select id="gallery_item_space" class="migy-form-field" name="migy_gallery_item_space">
    <option value="five-px" <?php selected('five-px', $migy_gallery_item_space, true); ?>>5 PX</option>
    <option value="ten-px" <?php selected('ten-px', $migy_gallery_item_space, true); ?>>10 PX</option>
    <option value="fifteen-px" <?php selected('fifteen-px', $migy_gallery_item_space, true); ?>>15 PX</option>
</select>

				</td>
			</tr>
			<tr>
				<td>
					<?php
					$migy_border_radius = !empty(get_post_meta($post->ID, 'migy_border_radius', true)) ? get_post_meta($post->ID, 'migy_border_radius', true) : '';
					?>
					<label for="border_radius"><strong>Item Border Radius</strong></label>
				</td>
				<td>
					<input id="border_radius" class="migy-form-field" name="migy_border_radius" type="number" min="0" max="120" value="<?php echo esc_attr($migy_border_radius); ?>" placeholder="0">PX
				</td>
			</tr>
			<tr>
				<?php
				$migy_filter_button_bg_color = !empty(get_post_meta($post->ID, 'migy_filter_button_bg_color', true)) ? get_post_meta($post->ID, 'migy_filter_button_bg_color', true) : '#f5f5f5';
				?>
				<td>
					<label><strong>Filter Button Color</strong></label>
				</td>
				<td>
    <label for="migy_filter_button_bg_color"><strong>Background</strong></label><br>
    <input type="color" name="migy_filter_button_bg_color" id="migy_filter_button_bg_color" class="migy-form-field" value="<?php echo esc_html($migy_filter_button_bg_color); ?>">
</td>

			</tr>
			<tr>
				<?php
				$migy_filter_button_text_color = !empty(get_post_meta($post->ID, 'migy_filter_button_text_color', true)) ? get_post_meta($post->ID, 'migy_filter_button_text_color', true) : '#222';
				?>
				<td></td>
				<td>
					<label for="migy_filter_button_text_color"><strong>Text</strong></label><br>
					<input type="color" name="migy_filter_button_text_color" id="migy_filter_button_text_color" class="migy-form-field" value="<?php echo esc_html($migy_filter_button_text_color); ?>">
				</td>
			</tr>
			<tr>
				<?php
				$migy_filter_button_active_bg_color = !empty(get_post_meta($post->ID, 'migy_filter_button_active_bg_color', true)) ? get_post_meta($post->ID, 'migy_filter_button_active_bg_color', true) : '#16a085';
				?>
				<td></td>
				<td>
					<label for="migy_filter_button_active_bg_color"><strong>Hover and Active Background</strong></label><br>
					<input type="color" name="migy_filter_button_active_bg_color" id="migy_filter_button_active_bg_color" class="migy-form-field" value="<?php echo esc_html($migy_filter_button_active_bg_color); ?>">
				</td>
			</tr>
			<tr>
				<?php
				$migy_filter_button_active_text_color = !empty(get_post_meta($post->ID, 'migy_filter_button_active_text_color', true)) ? get_post_meta($post->ID, 'migy_filter_button_active_text_color', true) : '#fff';
				?>
				<td></td>
				<td>
					<label for="migy_filter_button_active_text_color"><strong>Hover and Active Text</strong></label><br>
					<input type="color" name="migy_filter_button_active_text_color" id="migy_filter_button_active_text_color" class="migy-form-field" value="<?php echo esc_html($migy_filter_button_active_text_color); ?>">
				</td>
			</tr>
		</tbody>
	</table>
</div>

<!-- Start shortcode tab -->
<div class="migy-tab-data-shortcode">
	<?php
	$post_id = isset($_GET['post']) ? intval(wp_unslash($_GET['post'])) : 0;
	$migy_scode = $post_id ? '[migy_gallery id="' . $post_id . '"]' : '';
	if(!empty($migy_scode)) {
	?>
	<input type="text" name="migy_display_shortcode" class="migy_display_shortcode" value="<?php echo esc_attr($migy_scode); ?>" readonly>

	<div id="migy_shortcode_copied_notice"><?php echo esc_html__('Shortcode Copied!', 'mosaic-image-gallery'); ?></div>
	
	<ul>
		<li>To display the gallery on your website, just copy and paste <code style="color:#16a085"><?php echo esc_attr($migy_scode); ?></code> into any post, page, or custom post type content.</li>
		<li>If you want to include the gallery directly in your theme files, use <code style="color:#16a085">&lt;?php echo do_shortcode('<?php echo esc_attr($migy_scode); ?>'); ?&gt;</code>.</li>
	</ul>
	<?php 
	}else{
		echo '<p>Please create and publish the gallery to view the shortcode.</p>';
	} 
	?>
</div>
<!-- End style tab -->
<?php wp_nonce_field( 'migy_meta_box_nonce', 'migy_meta_box_noncename' ); ?>
