<?php
/**
 * Display password field.
 *
 * @author    David Bisset
 * @package   Charitable/Admin View/Settings
 * @copyright Copyright (c) 2023, WP Charitable LLC
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.0
 * @version   1.6.0
 */

$value = charitable_get_option( $view_args['key'] );

if ( empty( $value ) ) :
	$value = isset( $view_args['default'] ) ? $view_args['default'] : '';
endif;

?>
<input type="password"
	id="<?php printf( 'charitable_settings_%s', esc_attr( implode( '_', $view_args['key'] ) ) ); ?>"
	name="<?php printf( 'charitable_settings[%s]', esc_attr( $view_args['name'] ) ); ?>"
	value="<?php echo esc_attr( $value ); ?>"
	class="<?php echo esc_attr( $view_args['classes'] ); ?>"
	<?php echo esc_attr( charitable_get_arbitrary_attributes( $view_args ) ); ?> />
<?php if ( isset( $view_args['help'] ) ) : ?>
	<div class="charitable-help"><?php echo ( $view_args['help'] ); ?></div>
<?php endif; ?>
