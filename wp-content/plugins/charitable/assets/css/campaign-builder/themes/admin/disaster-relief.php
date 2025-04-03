<?php
/**
 * Display custom CSS.
 *
 * @package Charitable
 * @author  WP Charitable LLC
 * @since   1.8.0
 * @version 1.8.3.7
 */

header( 'Content-type: text/css; charset: UTF-8' );

if ( ! function_exists( 'charitable_sanitize_hex_color' ) ) {
	/**
	 * Sanitize a hex color.
	 *
	 * @param string $color The color to sanitize.
	 * @return string|null The sanitized color or null if the color is invalid.
	 */
	function charitable_sanitize_hex_color( $color ) {
		// Ensure the value is a string.
		$color = trim( $color );

		// Check if it's a valid 6-character hex color including the hash.
		if ( preg_match( '/^#[a-fA-F0-9]{6}$/', $color ) ) {
			return $color;
		}

		// Optionally return a default color or handle errors.
		return null; // Or return default color.
	}
}

if ( ! function_exists( 'charitable_esc_attr_php' ) ) {
	/**
	 * Escapes a string for use in PHP.
	 *
	 * @param string $text The text to escape.
	 * @return string The escaped text.
	 */
	function charitable_esc_attr_php( $text ) {
		return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );
	}
}

// @codingStandardsIgnoreStart

$primary   = isset( $_GET['p'] ) ? '#' . preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['p'] ) : '#9F190E';
$secondary = isset( $_GET['s'] ) ? '#' . preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['s'] ) : '#202020';
$tertiary  = isset( $_GET['t'] ) ? '#' . preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['t'] ) : '#FFFFFF';
$button    = isset( $_GET['b'] ) ? '#' . preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['b'] ) : '#9F190E';

$slug    = 'disaster-relief';
$wrapper = '.charitable-preview.charitable-builder-template-' . $slug . ' #charitable-design-wrap .charitable-campaign-preview';

?>

.charitable-preview.charitable-builder-template-<?php echo $slug; ?> { /* everything wraps in this */

  font-family: -apple-system, BlinkMacSystemFont, sans-serif;

}

/* this narrows things down a little to the preview area header/tabs */

<?php echo charitable_esc_attr_php( $wrapper ); ?> {
  /* field items in preview area */
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field {
    display: flex;
}
/* wide spread changes in header vs tabs */

<?php echo charitable_esc_attr_php( $wrapper ); ?> header {
    background-color: <?php echo $tertiary; ?>;
    color: #606060;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h1,
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h2,
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h3,
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h4,
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h5,
<?php echo charitable_esc_attr_php( $wrapper ); ?> header h6 {
    color: <?php echo $secondary; ?>
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h1,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h2,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h3,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h4,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h5,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content h6 {
    color: <?php echo $primary; ?>;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content > * {
    color: black;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> header h5 {
    font-size: 24px;
    line-height: 28px;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?>  .placeholder {
    padding: 0;
}

/* aligns */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-left > div,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-left img.charitable-campaign-builder-preview-photo {
    margin-left: 0;
    margin-right: auto;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-center > div,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-center img.charitable-campaign-builder-preview-photo {
    margin-left: auto;
    margin-right: auto;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-right > div,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-preview-align-right img.charitable-campaign-builder-preview-photo {
    margin-left: auto;
    margin-right: 0;
}



/* column specifics */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .column[data-column-id="0"] {
    flex: 0 0 66%;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .column[data-column-id="1"] {
    border: 1px solid #ECECEC;
}

/* headlines in general */
<?php echo charitable_esc_attr_php( $wrapper ); ?>  h5.charitable-field-preview-headline {
    color: <?php echo $primary; ?>;
}

/* field: campaign title */

<?php echo charitable_esc_attr_php( $wrapper ); ?>  .charitable-field-campaign-title h1 {
    margin: 5px 0 5px 0;
    color: <?php echo $primary; ?>;
    font-size: 27px;
    line-height: 29px;
    font-weight: 600;
}

/* field: campaign description */

<?php echo charitable_esc_attr_php( $wrapper ); ?>  .charitable-field-campaign-description .charitable-campaign-builder-placeholder-preview-text {
    padding: 0;
    color: #202020;
}


/* field: text */

<?php echo charitable_esc_attr_php( $wrapper ); ?>  .charitable-field-text .charitable-campaign-builder-placeholder-preview-text {
    padding: 0;
    color: #202020;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  .charitable-field-text h5.charitable-field-preview-headline {
    color: <?php echo $primary; ?>;
}


/* field: button */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-donate-button .charitable-field-preview-donate-button span.placeholder.button {
  background-color: <?php echo $button; ?> !important;
  border-color: <?php echo $button; ?> !important;
  text-transform: uppercase;
  border-radius: 35px;
  margin-top: 0;
  margin-bottom: 0;
  width: 100%;
  font-weight: 400;
  min-height: 50px;
  height: 50px;
  font-size: 16px;
  line-height: 50px;
}

/* field: photo */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-photo .primary-image {
  border: transparent;
  border-radius: 0px;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> .primary-image-container {
    margin: 0;
    padding: 0;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> .tab-content .primary-image-container {
    margin: 0;
    padding: 0;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?>  img.charitable-campaign-builder-preview-photo {
    max-width: 100%;
    display: block;
}



/* field: progress bar */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-progress-bar .progress-bar-info-row div.campaign-percent-raised {
    color: #202020;
    font-weight: 500;
    font-size: 18px;
    line-height: 21px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-progress-bar .progress-bar-info-row div.campaign-goal {
    color: <?php echo $primary; ?>;
    font-weight: 600;
    font-size: 24px;
    line-height: 28px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-progress-bar .progress {
  border: 0;
  padding: 0;
  background-color: #E0E0E0;
  border-radius: 5px;
  margin-top: 15px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-progress-bar .progress-bar {
  background-color: <?php echo $primary; ?>;
  height: 8px !important;
  border-radius: 5px;
  text-align: right;
  opacity: 1.0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field.charitable-field-progress-bar .progress-bar span {
  display: inline-block;
  background-color: <?php echo $primary; ?>;
  border-radius: 25px;
  width: 25px;
  height: 25px;
  margin-right: -15px;
  margin-top: -10px;
}

/* field: social linking */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-linking {
    display: table;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-linking .charitable-field-preview-social-linking-headline-container {
    display: block;
    float: left;
    padding: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-linking .charitable-field-row {
    display: block;
    float: left;
    width: auto;
    margin: 0 0 0 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-linking h5.charitable-field-preview-headline {
    font-size: 14px;
    line-height: 16px;
    color: #24231E;
    font-weight: 300;
    margin: 0 15px 0 0;
    padding: 5px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-linking .charitable-placeholder {
    padding: 10px;
}

/* field: social sharing */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-sharing {
    display: table;
}

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-sharing .charitable-field-preview-social-sharing-headline-container {
    display: block;
    float: left;
    padding: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-sharing .charitable-field-row {
    display: block;
    float: left;
    width: auto;
    margin: 0 0 0 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-sharing h5.charitable-field-preview-headline {
    font-size: 14px;
    line-height: 16px;
    color: #24231E;
    font-weight: 300;
    margin: 0 15px 0 0;
    padding: 5px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-social-sharing .charitable-placeholder {
    padding: 10px;
}

/* field: campaign summary */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-campaign-summary {
    padding-left: 0;
    padding-right: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-campaign-summary div {
    color: #92918E;
    font-weight: 400;
    font-size: 14px;
    line-height: 16px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-campaign-summary div span {
    color: <?php echo $secondary; ?>;
    font-weight: 600;
    font-size: 32px;
    line-height: 38px;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-preview-campaign-summary .campaign-summary-item {
    border: 0;
    margin-top: 5px;
    margin-bottom: 5px;
}

/* field: donate amount */

<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-donate-amount label,
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-donate-amount input.custom-donation-input[type="text"] {
    color: <?php echo $secondary; ?>;
    border: 1px solid <?php echo $secondary; ?> !important;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-donate-amount ul li.suggested-donation-amount.selected {
    background-color: <?php echo $primary; ?>;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> .charitable-field-donate-amount ul li.suggested-donation-amount.selected span.amount {
    color: <?php echo $tertiary; ?>;
}

/* tabs: tab nav */

<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav {
    border: 1px solid transparent;
    background-color: transparent;
    width: auto;
    margin-left: 0;
    margin-right: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li {
    border-top: 0;
    border-right: 0;
    border-bottom: 0;
    border-left: 0;
    background-color: transparent;
    margin: 0 10px 0 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li a {
    color: black;
    display: block;
    text-transform: none;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li.active {
    background-color: <?php echo $primary; ?>;
    color: white;
    text-decoration: none;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li:hover {
    background-color: <?php echo $primary; ?>;
    color: white;
    text-decoration: none;
    filter: brightness(90%);
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li.active a,
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav li:hover a {
    color: white;
}

/* tabs: style */

<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-boxed li {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-boxed li a {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-rounded li {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-rounded li a {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li {
    background-color: transparent;
    border-top: 0;
    border-right: 0;
    border-left: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li:hover {
    background-color: transparent;
    border-bottom: 1px solid <?php echo $button; ?> !important;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li:hover a {
    color: black;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li.active {
    background-color: transparent;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li a {
    color: <?php echo $primary; ?>;
    border-top: 0;
    border-right: 0;
    border-left: 0;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-style-minimum li.active {
  border-bottom: 1px solid <?php echo $button; ?> !important;
}

/* tabs: sized */

<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-small li {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-small li a {
    font-weight: 500;
    font-size: inherit;
    line-height: inherit;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-medium li {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-medium li a {
    font-weight: 500;
    font-size: inherit;
    line-height: inherit;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-large li {

}
<?php echo charitable_esc_attr_php( $wrapper ); ?> article nav.tab-size-large li a {
    font-weight: 500;
    font-size: inherit;
    line-height: inherit;
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-small li {
  font-size:10px;
  padding:0
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-small li a {
  font-size:16px;
  padding:18px
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-medium li {
  font-size:14px;
  padding:0
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-medium li a {
  font-size:21px;
  padding:23px
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-large li {
  font-size:21px;
  padding:0
}
<?php echo charitable_esc_attr_php( $wrapper ); ?>  article nav.tab-size-large li a {
  font-size:30px;
  padding:32px
}
// @codingStandardsIgnoreEnd