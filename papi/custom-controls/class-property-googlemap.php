<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if PAPI class exists
if ( ! class_exists( 'Papi_Property' ) ) {
	return;
}

/**
 * Property GoogleMap
 *
 * @version 2.0.0
 */

class Papi_Property_GoogleMap extends Papi_Property {

	/**
	 * Generate the HTML for the property.
	 *
	 * @since 2.0.0
	 */

	public function html() {
		// Property options.
		$value = $this->get_value();
		$lat   = isset( $value->lat ) ? $value->lat : '';
		$lng   = isset( $value->lng ) ? $value->lng : '';

		// Render the input field
		$this->input();
		?>
		<style type="text/css">
			.map-canvas {
				width: 100%;
				height: 400px;
			}

			.map-search {
				font-weight: 300;
				line-height: 1.5;
				width: 100% !important;
				margin: 5px 0;
			}
		</style>
		<div id="<?php echo md5( $this->get_slug() ) ?>" class="map-canvas" data-slug="<?php echo md5( $this->get_slug() ) ?>" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>"></div>
		<?php

		$this->js();
	}

	/**
	 * Output custom JavaScript for the property.
	 *
	 * @since 2.0.0
	 */
	public function js() {
		?>
		<script type="text/javascript">
			( function ( $ ) {

				$( function () {
					var slug = '<?php echo md5( $this->get_slug() ) ?>';
					initMap( slug );
				});

			})( jQuery );
		</script>
		<?php
	}


	/**
	 * Generate the html for searching adress.
	 *
	 * @since 2.0.0
	 */
	public function input() {
		$value   = $this->get_value();
		$address = isset( $value->address ) ? $value->address : '';
		$lat     = isset( $value->lat ) ? $value->lat : '';
		$lng     = isset( $value->lng ) ? $value->lng : ''; ?>

		<input type="search" class="map-search"
		       name="<?php echo $this->get_slug() ?>[address]"
		       value="<?php echo esc_attr( $address ) ?>"
		       id="<?php echo md5( $this->get_slug() ) ?>_search"
		       placeholder="<?php _e( 'Search for address...' ) ?>"
		>

		<input type="hidden"
		       id="<?php echo md5( $this->get_slug() ) ?>_papi-property-map-lat"
		       name="<?php echo $this->get_slug() ?>[lat]"
		       value="<?php echo esc_attr( $lat ) ?>"
		>

		<input type="hidden"
		       id="<?php echo md5( $this->get_slug() ) ?>_papi-property-map-lng"
		       name="<?php echo $this->get_slug() ?>[lng]"
		       value="<?php echo esc_attr( $lng ) ?>"
		>
	<?php }


	/**
	 * Get value.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function get_value() {
		$value = $this->get_option( 'value' );

		if ( papi_is_empty( $value ) ) {
			$slug = $this->get_slug( true );
			$value = papi_get_field( $this->get_post_id(), $slug );
		}

		if ( empty( $value->address ) ) {
			$value->address = 'Greenwich Observatory, London';
			$value->lat     = 51.4976934;
			$value->lng     = -0.17549170000006598;
		} else {
			$value->address = $this->cleanAddress( $value->address );
		}

		return $value;
	}


	/**
	 * Setup actions.
	 */
	protected function setup_actions() {
		$options = $this->get_options();
		$api_key = isset( $options->settings->api_key ) ? $options->settings->api_key : 'GOOGLE_MAPS_API_KEY_CONSTANT?';

		wp_enqueue_script( 'google_maps', "https://maps.googleapis.com/maps/api/js?key=".$api_key."&signed_in=false", 'jquery', false, true );
		wp_enqueue_script( 'papi_property_googlemap', get_template_directory_uri() . '/js/papi-property-googlemap.js', [ 'jquery', 'google_maps' ], false, true );
	}

}
