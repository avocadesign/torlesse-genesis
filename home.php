<?php
/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

add_filter( 'body_class', 'torlesse_add_page_body_class' );
/**
 * Add page specific body class
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 */
function torlesse_add_page_body_class( $classes ) {
   $classes[] = 'homepage-widgets';
   return $classes;
}

/**
 * Test if the homepage widget area has widgets.
 * If yes then remove post loop and display widgets instead
 *
 * @since 2.0.1
 */
if ( is_active_sidebar( 'homepage-widgets' )) {

	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'torlesse_home_loop_helper' );

}
	

/**
 * Display widget content for "Homepage Widgets".
 *
 * @since 2.0.1
 */
function torlesse_home_loop_helper() {
	
	genesis_widget_area( 'homepage-widgets', array(
		'before' => '<div class="slider-wide"><div class="wrap">',
		'after' => '</div></div>',
	) );
		
}

/**
 * Force a layout setting for the page
 *
 * See: http://www.briangardner.com/code/force-layout-setting/
 *
 * @since 2.0.0
 */
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
//Other possible layouts: __genesis_return_content_sidebar, __genesis_return_sidebar_content, __genesis_return_content_sidebar_sidebar, __genesis_return_sidebar_sidebar_content, __genesis_return_sidebar_content_sidebar, __genesis_return_full_width_content


// All Customisations above this comment
genesis();