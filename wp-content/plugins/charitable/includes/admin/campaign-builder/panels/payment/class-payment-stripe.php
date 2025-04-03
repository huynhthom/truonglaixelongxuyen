<?php
/**
 * The class that defines a subpanel for the payment area for the campaign builder.
 *
 * @package   Charitable/Admin/Charitable_Campaign_Meta_Boxes
 * @author    David Bisset
 * @copyright Copyright (c) 2023, WP Charitable LLC
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.8.0
 * @version.  1.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Charitable_Builder_Panel_Payment_Stripe' ) ) :

	/**
	 * Stripe subpanel for Marketing Panel for campaign builder.
	 *
	 * @since 1.8.0
	 */
	class Charitable_Builder_Panel_Payment_Stripe {

		/**
		 * Slug.
		 *
		 * @since 1.8.0
		 *
		 * @var string
		 */
		private $slug = 'stripe';

		/**
		 * The label/headline at the top of the panel.
		 *
		 * @since 1.8.0
		 *
		 * @var string
		 */
		private $primary_label = '';

		/**
		 * Determines if the tab is initially active on a fresh new page load.
		 *
		 * @since 1.8.0
		 *
		 * @var string
		 */
		private $active = false;

		/**
		 * Determines if the tab is available for the lite version. If not, the CTA popup will be displayed when clicked in the submenu.
		 *
		 * @since 1.8.1.12
		 *
		 * @var string
		 */
		private $not_available_for_lite = false;

		/**
		 * Get things going. Add action hooks for the sidebar menu and the panel itself.
		 *
		 * @since 1.8.0
		 */
		public function __construct() {

			$this->primary_label = esc_html__( 'Stripe', 'charitable' );

			add_action( 'charitable_campaign_builder_payment_sidebar', array( $this, 'sidebar_tab' ) );
			add_action( 'charitable_campaign_builder_payment_panels', array( $this, 'panel_content' ) );
		}

		/**
		 * Generate sidebar html.
		 *
		 * @since 1.8.0
		 * @version 1.8.1.12 Added logic to show popup message if user is on lite version.
		 */
		public function sidebar_tab() {

			$not_available = ! charitable_is_pro() && $this->not_available_for_lite ? 'charitable-not-available' : '';
			$css_class     = ( '' === $not_available && true === apply_filters( 'charitable_campaign_builder_marketing_sidebar_active', $this->active, esc_attr( $this->slug ) ) ) ? 'active' : $not_available;
			$data_name     = esc_html__( 'ability to use', 'charitable' ) . ' ' . $this->primary_label;

			echo '<a href="#" class="charitable-panel-sidebar-section charitable-panel-sidebar-section-' . esc_attr( $this->slug ) . ' ' . esc_attr( $css_class ) . '" data-name="' . esc_html( $data_name ) . '" data-section="' . esc_attr( $this->slug ) . '">'
				. '<img class="charitable-builder-sidebar-icon" src="' . esc_url( charitable()->get_path( 'assets', false ) . 'images/campaign-builder/settings/payment/' . esc_attr( $this->slug ) . '.png' ) . '" />'
				. esc_html( $this->primary_label ) . '<span class="charitable-badge charitable-badge-sm charitable-badge-inline charitable-badge-green charitable-badge-rounded"><i class="fa fa-star" aria-hidden="true"></i>' . esc_html__( 'Recommended', 'charitable' ) . '</span>'
				. ' <i class="fa fa-angle-right charitable-toggle-arrow"></i></a>';
		}

		/**
		 * Generate panel content.
		 *
		 * @since 1.8.0
		 */
		public function panel_content() {

			$active = ( true === apply_filters( 'charitable_campaign_builder_settings_sidebar_active', $this->active, $this->slug ) ) ? 'active' : false;
			$style  = ( true === apply_filters( 'charitable_campaign_builder_settings_sidebar_active', $this->active, $this->slug ) ) ? 'display: block;' : false;

			$panel = new Charitable_Builder_Panel_Payment();

			ob_start();

			?>

			<div class="charitable-panel-content-section charitable-panel-content-section-parent-payment charitable-panel-content-section-<?php echo $this->slug; ?> <?php echo $active; ?>" style="<?php echo $style; ?>">

				<div class="charitable-panel-content-section-title"><?php echo esc_html( $this->primary_label ); ?> <?php echo esc_html__( 'Settings', 'charitable' ); ?></div>

				<div class="charitable-panel-content-section-interior">

				<?php

					do_action( 'charitable_campaign_builder_before_payment_' . $this->slug );

				?>

				<?php $panel->education_payment_text( $this->primary_label, $this->slug ); ?>


				<?php

					do_action( 'charitable_campaign_builder_after_payment_' . $this->slug );

				?>

				</div>

			</div>

			<?php

			$html = ob_get_clean();

			echo $html;
		}
	}

	new Charitable_Builder_Panel_Payment_Stripe();

endif;