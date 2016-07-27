# Google Maps PAPI Property
**By The Shipyard Crew**
robert.eliason@theshipyard.se
richard.sweeney@theshipyard.se
___

## Installation
Copy files to your theme.
Enqueue the property thusly:

<pre><code>/**
 * Carefully check for PAPI before loading custom properties
 */
if ( class_exists( 'Papi_Property' ) ) {
	require_once get_template_directory() . '/papi/custom-controls/class-property-googlemap.php';
}
</pre></code>

## Sample property config
<pre><code>papi_property( [
	'title'    => __( 'Map', 'my_theme_slug' ),
	'slug'     => 'location_map',
	'type'     => 'googlemap',
	'settings' => [
		'api_key' => 'AN_ACTUAL_GOOGLE_MAPS_API_KEY'
	],
] )
</code></pre>