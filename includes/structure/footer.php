<?php
/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

// add_filter( 'genesis_footer_creds_text', 'torlesse_footer_creds_text' );
/**
 * Custom footer 'creds' text
 *
 * @since 2.0.0
 */
function torlesse_footer_creds_text() {

	 return 'Copyright [footer_copyright] [footer_childtheme_link] &middot; [footer_genesis_link] [footer_studiopress_link] &middot; [footer_wordpress_link] &middot; [footer_loginout]';

}

//* Customize the return to top of page text
add_filter( 'genesis_footer_backtotop_text', 'custom_footer_backtotop_text' );
function custom_footer_backtotop_text($backtotop) {
	$backtotop = '[footer_backtotop text="Return to Top"]';
	return $backtotop;
}
