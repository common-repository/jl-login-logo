<?php

/*
Plugin Name: JL Login Logo
Description: Set your Jetpack-defined site logo or your site icon as your login page logo.
Version: 1.0
Author: João Luís
Author URI: http://joaopluis.pt
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


function jl_login_logo() {

	$has_logo = false;

	if ( function_exists( 'jetpack_get_site_logo' ) ) {

		$logo_id = jetpack_get_site_logo( 'id' );

		if ( $logo_id ) {

			$has_logo = true;

			list( $logo_url, $logo_w, $logo_h, $logo_original ) = wp_get_attachment_image_src( $logo_id, 'medium' );

			$ratio = $logo_w / $logo_h;

			if ( $logo_h > 100 ) {

				$logo_h = 100;
				$logo_w = $logo_h * $ratio;

			}

			if ( $logo_w > 250 ) {
				$logo_w = 250;
				$logo_h = $logo_w / $ratio;
			}

			?>
			<style type="text/css">
				.login h1 a {
					background-size: <?php echo $logo_w; ?>px;
					background-image: url(<?php echo $logo_url; ?>);
					width: <?php echo $logo_w; ?>px;
					height: <?php echo $logo_h; ?>px;
				}
			</style>
		<?php }
	}

	if ( ! $has_logo && has_site_icon() ) {
		?>
		<style type="text/css">
			.login h1 a {
				background-image: url(<?php echo get_site_icon_url(); ?>);
				border-radius: 10px;
			}
		</style>
		<?php
	}
}

add_action( 'login_enqueue_scripts', 'jl_login_logo' );