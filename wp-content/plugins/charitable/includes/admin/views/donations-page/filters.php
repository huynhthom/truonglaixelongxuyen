<?php
/**
 * Display the date filters above the Donations table.
 *
 * @author  WP Charitable LLC
 * @package Charitable/Admin View/Donations Page
 * @since   1.4.0
 */

$filters = $_GET;

unset(
	$filters['post_type'],
	$filters['paged'],
	$filters['bulk_donation_status_update'],
	$filters['ids']
);

?>
<div class="alignleft actions charitable-export-actions charitable-donation-filter-actions">
	<a href="#charitable-donations-filter-modal" title="<?php esc_html_e( 'Filter', 'charitable' ); ?>" class="donation-export-with-icon trigger-modal hide-if-no-js" data-trigger-modal><img src="<?php echo esc_url( charitable()->get_path( 'directory', false ) . 'assets/images/icons/filter.svg' ); ?>" alt="<?php esc_html_e( 'Filter', 'charitable' ); ?>"  /><label><?php esc_html_e( 'Filter', 'charitable' ); ?></label></a></li>
	<?php if ( count( $filters ) ) : ?>
		<a href="<?php echo esc_url_raw( add_query_arg( array( 'post_type' => Charitable::DONATION_POST_TYPE ), admin_url( 'edit.php' ) ) ); ?>" class="charitable-donations-clear button dashicons-before dashicons-clear"><?php esc_html_e( 'Clear Filters', 'charitable' ); ?></a>
	<?php endif ?>
</div>