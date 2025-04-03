<?php
/**
 * Charitable Tools Settings UI.
 *
 * @package   Charitable/Classes/Charitable_Tools_Settings
 * @author    David Bisset
 * @copyright Copyright (c) 2023, WP Charitable LLC
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.7.0.7
 * @version   1.8.1.6
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Charitable_Tools_Settings' ) ) :

	/**
	 * Charitable_Tools_Settings
	 *
	 * @since 1.8.1.6
	 */
	final class Charitable_Tools_Settings {

		/**
		 * The single instance of this class.
		 *
		 * @since  1.8.1.6
		 *
		 * @var    Charitable_Tools_Settings|null
		 */
		private static $instance = null;

		/**
		 * Create object instance.
		 *
		 * @since   1.8.1.6
		 */
		private function __construct() {
		}

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since   1.8.1.6
		 *
		 * @return  Charitable_Tools_Settings
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Add the tools tab settings fields.
		 *
		 * @since   1.8.1.6
		 *
		 * @return  array<string,array>
		 */
		public function add_tools_import_fields() {

			if ( ! charitable_is_tools_view( 'import' ) ) {
				return array();
			}

			return array(
				'section'          => array(
					'title'    => '',
					'type'     => 'hidden',
					'priority' => 1000,
					'value'    => 'import',
				),
				'import_campaign'  => array(
					'label_for'         => __( 'Campaign Import', 'charitable' ),
					'type'              => 'file',
					'wrapper_class'     => 'test',
					'nonce_action_name' => 'import_campaign',
					'nonce_field_name'  => 'charitable_nonce',
					'name'              => 'campaign',
					'action'            => 'tools-campaign',
					'button_label'      => esc_html__( 'Import Campaign', 'charitable' ),
					'help'              => sprintf(
						/* translators: %1$s: HTML strong tag. %2$s: HTML closing strong tag. %1$s: HTML break tag. */
						esc_html__( 'Imports a campaign JSON file into this website. It will not overwrite any previous campaigns, and it will set to "inactive" with a new campaign ID.%3$s %1$sCampaign tools do not include donations or campaign creators%2$s.', 'charitable' ),
						'<strong>',
						'</strong>',
						'<br />'
					),
					'priority'          => 25,
					'default'           => 2,
				),
				'import_donations' => array(
					'label_for'         => __( 'Campaign Donations', 'charitable' ),
					'type'              => 'file',
					'wrapper_class'     => 'test',
					'nonce_action_name' => 'import_donations',
					'nonce_field_name'  => 'charitable_nonce',
					'name'              => 'donations',
					'action'            => 'tools-donation',
					'button_label'      => esc_html__( 'Import Donations', 'charitable' ),
					'help'              => sprintf(
						/* translators: %1$s: HTML strong tag. %2$s: HTML closing strong tag. %1$s: HTML break tag. */
						esc_html__( 'Imports a donation JSON file into the selected campaign. It will not overwrite any previous donations or prevent duplicates.%3$s %1$sDonation tools do not include users - if a donor\'s email address is not found, the donation will not be assigned to a user%2$s.', 'charitable' ),
						'<strong>',
						'</strong>',
						'<br />'
					),
					'priority'          => 25,
					'default'           => 2,
					'options'           => $this->get_campaign_list( true ),
					'select_name'       => 'tools_campaign',
				),
			);
		}

		/**
		 * Add the tools tab settings fields.
		 *
		 * @since   1.8.1.6
		 *
		 * @return  array<string,array>
		 */
		public function add_tools_export_fields() {

			if ( ! charitable_is_tools_view( 'export' ) ) {
				return array();
			}

			return array(
				'section'          => array(
					'title'    => '',
					'type'     => 'hidden',
					'priority' => 2000,
					'value'    => 'export',
				),
				'export_campaign'  => array(
					'label_for'         => __( 'Campaign Export', 'charitable' ),
					'type'              => 'select-form',
					'wrapper_class'     => 'test',
					'nonce_action_name' => 'export_campaign',
					'nonce_field_name'  => 'charitable_nonce',
					'name'              => 'campaign',
					'action'            => 'export-campaign',
					'button_label'      => __( 'Export Campaign', 'charitable' ),
					'help'              => sprintf(
						/* translators: %1$s: HTML strong tag. %2$s: HTML closing strong tag. %1$s: HTML break tag. */
						__( 'Campaign exports files can be used to create a backup of your campaigns or to import campaigns into another site with Charitable installed.%3$s %1$sCampaign exports do not include donations or campaign creators%2$s.', 'charitable' ),
						'<strong>',
						'</strong>',
						'<br />'
					),
					'priority'          => 225,
					'default'           => 2,
					'options'           => $this->get_campaigns_to_export(),
				),
				'export_donations' => array(
					'label_for'         => __( 'Donations Export', 'charitable' ),
					'type'              => 'select-form',
					'wrapper_class'     => 'test',
					'nonce_action_name' => 'export_donations_from_campaign',
					'nonce_field_name'  => 'charitable_nonce',
					'name'              => 'donations',
					'action'            => 'export-donations-from-campaign',
					'button_label'      => __( 'Export Donations', 'charitable' ),
					'help'              => sprintf(
						/* translators: %1$s: HTML strong tag. %2$s: HTML closing strong tag. %1$s: HTML break tag. */
						__( 'Donation exports files can be used to create a backup of your donations or to import donations if you are migrating campaigns to another site with Charitable installed. %3$s All donation types (paid, refunded, pending) will be exported. %1$sRecurring donations are not included%2$s.', 'charitable' ),
						'<strong>',
						'</strong>',
						'<br />'
					),
					'priority'          => 227,
					'default'           => 2,
					'options'           => $this->get_campaigns_to_export( true ),
				),
			);
		}

		/**
		 * Placeholder function.
		 *
		 * @since 1.8.1.6
		 */
		public function add_tools_snippets_fields() {

			return array();
		}

		/**
		 * Placeholder function.
		 *
		 * @since 1.8.2
		 */
		public function add_tools_customize_fields() {

			return array();
		}

		/**
		 * Return the list of user donation field options.
		 *
		 * @since  1.8.1.6
		 *
		 * @return string[]
		 */
		protected function get_user_donation_field_options() {
			$fields = charitable()->donation_fields()->get_data_type_fields( 'user' );

			return array_combine(
				array_keys( $fields ),
				wp_list_pluck( $fields, 'label' )
			);
		}

		/**
		 * Return the list of user donation field options.
		 *
		 * @since  1.7.0.7
		 *
		 * @param  boolean $include_donations Whether to include the number of donations in the campaign name.
		 *
		 * @return string[]
		 */
		protected function get_campaign_list( $include_donations = false ) {

			$campaigns = array();

			$args = array(
				'posts_per_page' => -1,
				'orderby'        => 'post_title',
				'order'          => 'ASC',
				'fields'         => array( 'post_title', 'ID' ),
			);

			$results = Charitable_Campaigns::query( $args );

			if ( empty( $results->posts ) ) {
				return array();
			}

			foreach ( $results->posts as $index => $post ) :
				$campaigns[ $post->ID ] = $post->post_title;
				if ( $include_donations ) {
					$donations              = charitable_get_table( 'campaign_donations' )->get_donations_on_campaign( $post->ID );
					$donation_count         = count( $donations );
					$plural                 = ( ( $donation_count > 1 ) || 0 === $donation_count ) ? 's' : '';
					$campaigns[ $post->ID ] = $post->post_title . ' (' . count( $donations ) . ' donation' . $plural . ') ';
				}
			endforeach;

			return( $campaigns );
		}

		/**
		 * Return the list of user donation field options.
		 *
		 * @since  1.7.0.7
		 *
		 * @param  boolean $include_donations Whether to include the number of donations in the campaign name.
		 *
		 * @return string[]
		 */
		protected function get_campaigns_to_export( $include_donations = false ) {

			$campaigns = array();

			$args = array(
				'posts_per_page' => -1,
				'orderby'        => 'post_title',
				'order'          => 'ASC',
				'fields'         => array( 'post_title', 'ID' ),
			);

			$results = Charitable_Campaigns::query( $args );

			if ( empty( $results->posts ) ) {
				return array();
			}

			foreach ( $results->posts as $index => $post ) :
				$campaigns[ $post->ID ] = $post->post_title;
				if ( $include_donations ) {
					$donations              = charitable_get_table( 'campaign_donations' )->get_donations_on_campaign( $post->ID );
					$donation_count         = count( $donations );
					$plural                 = ( ( $donation_count > 1 ) || 0 === $donation_count ) ? 's' : '';
					$campaigns[ $post->ID ] = $post->post_title . ' (' . count( $donations ) . ' donation' . $plural . ') ';
				}
			endforeach;

			return( $campaigns );
		}
	}

endif;
