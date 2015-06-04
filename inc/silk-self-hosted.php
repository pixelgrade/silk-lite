<?php
/*
 * This hook is called only when the theme gets activated and it validates your license.
 * It also provides you future premium features and we recommend you to keep it this way.
 * @TODO: allow this function to get a 'force_kit_update' parameter
 */
function pixelgrade_activate_silk() {
	/**
	 * Some settings needed for the first activation
	 */
	$theme_name = 'silk';
	$typekit_fonts =  array(
		array( "id" => "ltc-bodoni-175" ),
		array( "id" => "futura-pt" ),
		array( "id" => "gkmg" ),
		array( "id" => "brandon-grotesque" ),
		array( "id" => "abril-display" ),
		array( "id" => "ff-market-web" ),
	);

	// try to get the current license if there is one
	$license_key = get_option('silk_license_key');

	// when this is empty, try to get it from the license_key.txt file
	// usually this happens only the first time
	if ( empty($license_key) && file_exists(get_template_directory() . '/license_key.txt' )) {
		$license_key = file_get_contents( get_template_directory() . '/license_key.txt');
	}

	$url = 'https://themesapi.pixelgrade.com/wp-json/api/licenses/activate_theme';

	$request_args = array(
		'method' => 'GET',
		'blocking' => true,
		'body' => array(
			'license' =>  $license_key,
			'site_name' => get_bloginfo(),
			'site_url' => site_url(),
			'domain' => $_SERVER['HTTP_HOST'],
			'theme_name' => $theme_name,
			'typekit_fonts' => $typekit_fonts
		),
	);

	// now send all these args to pixelgrade API and the server will return the valid data(license, typekit_id or fonts list)
	$response_body = wp_remote_retrieve_body( wp_safe_remote_post( $url , $request_args) );
	$response_array = json_decode($response_body, true);

	if ( isset( $response_array['status'] ) && $response_array['status'] === 'failed' ) {
		return;
	}

	if ( isset( $response_array['valid_license'] ) && ! empty( $response_array['valid_license'] ) ) {
		update_option( 'silk_license_key', $response_array['valid_license'] );
	}

	if ( isset( $response_array['typekit_kit_id'] ) ) {
		update_option( 'silk_typekit_id', $response_array['typekit_kit_id'] );
	}

	if ( isset( $response_array['typekit_fonts'] ) ) {
		update_option( 'typekit_fonts', $response_array['typekit_fonts'] );
	}
	return;
}

add_action( 'after_switch_theme', 'pixelgrade_activate_silk' );

function silk_typekit_script_embed() {
	$id = get_option('silk_typekit_id');
	if ( ! empty ( $id ) ) { ?>
		<script>
(function() {
	var config = {
		kitId: '<?php echo $id; ?>',
		classes: false,
		events: false
	};
	var d = false;
	var tk = document.createElement('script');
	tk.src = '//use.typekit.net/' + config.kitId + '.js';
	tk.type = 'text/javascript';
	tk.async = 'true';
	tk.onload = tk.onreadystatechange = function() {
		var rs = this.readyState;
		if (d || rs && rs != 'complete' && rs != 'loaded') return;
		d = true;
		try { Typekit.load( config ); } catch (e) {}
	};
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(tk, s);
})();
		</script><?php return;
	}
}

add_action( 'wp_head', 'silk_typekit_script_embed'); ?>