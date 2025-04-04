<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit; // Exit if accessed directly
	}

	// Load existing options or set defaults
	$tp_scroll_top_option_enable         = get_option( 'tp_scroll_top_option_enable', 'true' );
	$tp_scroll_top_visibility_fade_speed = get_option( 'tp_scroll_top_visibility_fade_speed', '400' );
	$tp_scroll_top_scroll_fade_speed     = get_option( 'tp_scroll_top_scroll_fade_speed', '400' );
	$tp_scroll_top_scroll_position       = get_option( 'tp_scroll_top_scroll_position', 'bottom right' );
	$tp_scroll_top_scrollbg              = get_option( 'tp_scroll_top_scrollbg', '#ffc107' );
	$tp_scroll_top_scrollbg_hover        = get_option( 'tp_scroll_top_scrollbg_hover', '#212121' );
	$tp_scroll_top_scrollradious         = get_option( 'tp_scroll_top_scrollradious', '50' );



	// Handle form submission
	if ( isset( $_POST['tp_scroll_to_top_hidden'] ) && wp_verify_nonce( $_POST['tp_scroll_top_nonce'], 'tp_scroll_top_save_settings' ) ) {
	    $tp_scroll_top_option_enable         = sanitize_text_field( $_POST['tp_scroll_top_option_enable'] );
	    $tp_scroll_top_visibility_fade_speed = sanitize_text_field( $_POST['tp_scroll_top_visibility_fade_speed'] );
	    $tp_scroll_top_scroll_fade_speed     = sanitize_text_field( $_POST['tp_scroll_top_scroll_fade_speed'] );
	    $tp_scroll_top_scroll_position       = sanitize_text_field( $_POST['tp_scroll_top_scroll_position'] );
	    $tp_scroll_top_scrollbg              = sanitize_hex_color( $_POST['tp_scroll_top_scrollbg'] );
	    $tp_scroll_top_scrollbg_hover        = sanitize_hex_color( $_POST['tp_scroll_top_scrollbg_hover'] );
	    $tp_scroll_top_scrollradious         = sanitize_text_field( $_POST['tp_scroll_top_scrollradious'] );

	    // Update options
	    update_option( 'tp_scroll_top_option_enable', $tp_scroll_top_option_enable );
	    update_option( 'tp_scroll_top_visibility_fade_speed', $tp_scroll_top_visibility_fade_speed );
	    update_option( 'tp_scroll_top_scroll_fade_speed', $tp_scroll_top_scroll_fade_speed );
	    update_option( 'tp_scroll_top_scroll_position', $tp_scroll_top_scroll_position );
	    update_option( 'tp_scroll_top_scrollbg', $tp_scroll_top_scrollbg );
	    update_option( 'tp_scroll_top_scrollbg_hover', $tp_scroll_top_scrollbg_hover );
	    update_option( 'tp_scroll_top_scrollradious', $tp_scroll_top_scrollradious );

	    echo '<div class="updated"><p><strong>' . __( 'Changes saved.', 'scrolltop' ) . '</strong></p></div>';
	}

	?>

	<div class="wrap">
		<h2><?php esc_html_e( 'Scroll Top Settings', 'scrolltop' ); ?></h2>
		<form method="post" action="">
			<?php wp_nonce_field( 'tp_scroll_top_save_settings', 'tp_scroll_top_nonce' ); ?>
			<input type="hidden" name="tp_scroll_to_top_hidden" value="Y">
	        <?php 
	        	settings_fields( 'tp_scroll_to_top_plugin_options' );
				do_settings_sections( 'tp_scroll_to_top_plugin_options' );
			?>
	        <table class="form-table">
	            <tr>
	                <th scope="row">
	                    <label for="tp_scroll_top_option_enable"><?php esc_html_e( 'Show/Hide:', 'scrolltop' ); ?></label>
	                </th>
	                <td>
	                    <select name="tp_scroll_top_option_enable" id="tp_scroll_top_option_enable">
	                        <option value="true" <?php selected( $tp_scroll_top_option_enable, 'true' ); ?>><?php esc_html_e( 'Show', 'scrolltop' ); ?></option>
	                        <option value="false" <?php selected( $tp_scroll_top_option_enable, 'false' ); ?>><?php esc_html_e( 'Hide', 'scrolltop' ); ?></option>
	                    </select>
	                    <p class="description"><?php esc_html_e( 'Enable or disable the scroll-to-top button.', 'scrolltop' ); ?></p>
	                </td>
	            </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="tp_scroll_top_visibility_fade_speed"><?php esc_html_e( 'Visibility Fade Speed:', 'scrolltop' ); ?></label>
                    </th>
                    <td>
                        <select name="tp_scroll_top_visibility_fade_speed">
                            <?php
                            $speeds = array( '100', '400', '600', '800' );
                            foreach ( $speeds as $speed ) {
                                echo '<option value="' . esc_attr( $speed ) . '" ' . selected( $tp_scroll_top_visibility_fade_speed, $speed, false ) . '>' . esc_html( $speed ) . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <span><?php esc_html_e( 'Set fade speed for button visibility.', 'scrolltop' ); ?></span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="tp_scroll_top_scroll_fade_speed"><?php esc_html_e( 'Scroll Speed:', 'scrolltop' ); ?></label>
                    </th>
                    <td>
                        <select name="tp_scroll_top_scroll_fade_speed">
                            <?php
                            $speeds = array( '100', '400', '500', '600', '700' );
                            foreach ( $speeds as $speed ) {
                                echo '<option value="' . esc_attr( $speed ) . '" ' . selected( $tp_scroll_top_scroll_fade_speed, $speed, false ) . '>' . esc_html( $speed ) . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <span><?php esc_html_e( 'Set scrolling speed.', 'scrolltop' ); ?></span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="tp_scroll_top_scrollbg"><?php esc_html_e( 'Background Color:', 'scrolltop' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="scroll-bg" name="tp_scroll_top_scrollbg" value="<?php echo esc_attr( $tp_scroll_top_scrollbg ); ?>">
                        <br>
                        <span><?php esc_html_e( 'Set button background color.', 'scrolltop' ); ?></span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="tp_scroll_top_scrollbg_hover"><?php esc_html_e( 'Hover Background Color:', 'scrolltop' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="scroll-hoverbg" name="tp_scroll_top_scrollbg_hover" value="<?php echo esc_attr( $tp_scroll_top_scrollbg_hover ); ?>">
                        <br>
                        <span><?php esc_html_e( 'Set hover background color.', 'scrolltop' ); ?></span>
                    </td>
                </tr>

				<tr valign="top">
				    <th scope="row">
				        <label for="tp_scroll_top_scrollradious"><?php esc_html_e( 'Border Radius:', 'scrolltop' ); ?></label>
				    </th>
				    <td>
				        <input type="range" name="tp_scroll_top_scrollradious" 
				               id="tp_scroll_top_scrollradious" 
				               min="0" max="100" 
				               value="<?php echo esc_attr( $tp_scroll_top_scrollradious ); ?>" 
				               oninput="document.getElementById('radius-value').textContent = this.value + '%'">
				        <span id="radius-value"><?php echo esc_html( $tp_scroll_top_scrollradious ) . '%'; ?></span>
				        <br>
				        <span><?php esc_html_e( 'Set button border radius (default: 50%).', 'scrolltop' ); ?></span>
				    </td>
				</tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="tp_scroll_top_scroll_position"><?php echo __( 'Position:', 'scrolltop' ); ?></label>
                    </th>
                    <td>
                        <select name="tp_scroll_top_scroll_position">
                            <?php
                            $positions = array(
                                'bottom right' => __( 'Bottom Right', 'scrolltop' ),
                                'bottom center' => __( 'Bottom Center', 'scrolltop' ),
                                'bottom left' => __( 'Bottom Left', 'scrolltop' ),
                                'top right' => __( 'Top Right', 'scrolltop' ),
                                'top center' => __( 'Top Center', 'scrolltop' ),
                                'top left' => __( 'Top Left', 'scrolltop' ),
                            );
                            foreach ( $positions as $key => $label ) {
                                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $tp_scroll_top_scroll_position, $key, false ) . '>' . esc_html( $label ) . '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <span><?php echo __( 'Set button position.', 'scrolltop' ); ?></span>
                    </td>
                </tr>

	        </table>

            <p class="submit">
                <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'scrolltop' ); ?>">
            </p>
            
		</form>
	    <script>
	        jQuery(document).ready(function($) {
	            $('#scroll-bg, #scroll-hoverbg').wpColorPicker();
	        });
	    </script>
	</div>