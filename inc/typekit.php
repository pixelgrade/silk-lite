<?php

/*
 * When a theme is activated read the license file if there is one and try to register this domain to a kit
 */

function activate_typekit() {

	$license_key = get_option('silk_license_key');

	if ( empty($license_key) && file_exists(get_template_directory() . '/license_key.txt' )) {
		$license_key = file_get_contents( get_template_directory() . '/license_key.txt');
		update_option('silk_license_key', $license_key);
	} else {
		return;
	}

	$url = 'http://themesapi.pixelgrade.com/wp-json/api/licenses/activate_theme';

	$request_args = array(
		'method' => 'GET',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'body' => array(
			'license' =>  $license_key,
			'site_name' => get_bloginfo(),
			'site_url' => site_url(),
			'domain' => $_SERVER['HTTP_HOST'],
			'theme_name' => 'silk',
			'typekit_fonts' => array(
				array( "id" => "ltc-bodoni-175" ),
				array( "id" => "gkmg" ),
			)
		),
	);

	$response_body = wp_remote_retrieve_body( wp_safe_remote_post( $url , $request_args) );
	$response_array = json_decode($response_body, true);

	if ( isset( $response_array['status'] ) && $response_array['status'] === 'failed' ) {
		return;
	}

	if ( isset( $response_array['typekit_kit_id'] ) ) {
		update_option( 'silk_typekit_id', $response_array['typekit_kit_id'] );
	}

	return;
}

add_action( 'after_switch_theme', 'activate_typekit' );
//add_action( 'init', 'activate_typekit' );

function silk_typekit_script_embed() {
	$id = get_option('silk_typekit_id');
	if ( ! empty ( $id ) ) { ?>
<script>
(function(d) {
	var config = {
			kitId: '<?php echo $id; ?>',
			scriptTimeout: 3000
		},
		h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
})(document);
</script><?php }

}

add_action( 'wp_head', 'silk_typekit_script_embed');