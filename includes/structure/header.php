<?php
/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

/**
 * Cleanup <head>
 *
 * @since 2.0.0
 */
remove_action( 'wp_head', 'rsd_link' );									// RSD link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );				// Parent rel link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );				// Start post rel link
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	// Adjacent post rel link
remove_action( 'wp_head', 'wp_generator' );								// WP Version

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'torlesse_load_stylesheets', 999 );
/**
 * Overrides the default Genesis stylesheet with child theme specific.
 *
 * Only load these styles on the front-end.
 *
 * @since 2.0.0
 */
function torlesse_load_stylesheets() {
    if( ( is_single() || is_page() || is_attachment() ) && comments_open() & get_option( 'thread_comments' ) == 1 ) {
		wp_enqueue_script( 'comment-reply' );
    } else {
		wp_dequeue_script( 'comment-reply' );
    }

    if( !is_admin() ) {
		// Main theme stylesheet
	    wp_enqueue_style( 'bfg', get_stylesheet_directory_uri() . '/css/style.css', array(), null );

	    // IE-only stylesheet
	    wp_enqueue_style( 'bfg-ie', get_stylesheet_directory_uri() . '/css/ie.css', array(), null );

	    // Fallback for old IE
	    wp_enqueue_style( 'bfg-ie-universal', 'http://universal-ie6-css.googlecode.com/files/ie6.1.1.css', array(), null );

	    // Google Fonts
    	// wp_enqueue_style(
    	// 	'google-fonts',
    	// 	'http://fonts.googleapis.com/css?family=Open+Sans:300,400,700',		// Open Sans (light, normal, and bold), for example
    	// 	array(),
    	// 	null
    	// );
	}

}

add_action( 'wp_enqueue_scripts', 'torlesse_load_scripts' );
/**
 * Load scripts
 *
 * Only load these scripts on the front-end.
 *
 * @since 2.0.0
 */
function torlesse_load_scripts() {

    if( !is_admin() ) {
		// Override WP'd default self-hosted jQuery with version from Google's CDN
		//wp_deregister_script( 'jquery' );
		//wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js', array(), null);

		// Main script file (in footer)
	    wp_enqueue_script( 'bfg', get_stylesheet_directory_uri() . '/js/scripts-ck.js', array( 'jquery' ), null, true );
	    wp_enqueue_script( 'responsive-nav-toggle', get_stylesheet_directory_uri() . '/js/responsive-nav.min.js', array( 'jquery' ), null, true );
    }

}

add_filter( 'genesis_pre_get_option_nav_superfish', 'nrp_get_option_nav_superfish' );
function nrp_get_option_nav_superfish( $opt ) {
    $opt = '1';
    return $opt;
}

add_action ( 'wp_footer' , 'torlesse_responsive_nav', 40 );

function torlesse_responsive_nav() {
	?>
		<script>
		  var navigation = responsiveNav("#menu-main-menu", { // Selector: The ID of the wrapper
			  transition: 400, // Integer: Speed of the transition, in milliseconds
			  label: "Menu", // String: Label for the navigation toggle
			  insert: "before", // String: Insert the toggle before or after the navigation
			  openPos: "relative", // String: Position of the opened nav, relative or static
			  jsClass: "js", // String: 'JS enabled' class which is added to <html> el
			  init: function(){}, // Function: Init callback
			  open: function(){}, // Function: Open callback
			  close: function(){} // Function: Close callback
			});
		</script>
	<?php
}

add_filter( 'style_loader_tag', 'torlesse_ie_conditionals', 10, 2 );
/**
 * Wrap stylesheets in IE conditional comments.
 *
 * Load the main stylesheet for all non-IE browsers & IE8+, the IE stylesheet for IE8+, and the IE universal stylesheet for IE 7-.
 *
 * @since 1.x
 */
function torlesse_ie_conditionals( $tag, $handle ) {

	if( 'bfg' == $handle ) {
        $output = '<!--[if !IE]> -->' . "\n" . $tag . '<!-- <![endif]-->' . "\n";
        $output .= '<!--[if gte IE 8]>' . "\n" . $tag . '<![endif]-->' . "\n";
	} elseif( 'bfg-ie' == $handle ) {
        $output = '<!--[if gte IE 8]>' . "\n" . $tag . '<![endif]-->' . "\n";
	} elseif( 'bfg-ie-universal' == $handle ) {
        $output = '<!--[if lt IE 8]>' . "\n" . $tag . '<![endif]-->' . "\n";
	} else {
		$output = $tag;
	}

    return $output;

}

// add_filter( 'genesis_pre_load_favicon', 'torlesse_pre_load_favicon' );
/**
 * Simple favicon override to specify your favicon's location
 *
 * @since 2.0.0
 */
function torlesse_pre_load_favicon() {

	return get_stylesheet_directory_uri() . '/images/favicon.ico';

}

// remove_action( 'wp_head', 'genesis_load_favicon' );
// add_action( 'wp_head', 'torlesse_load_favicons' );
/**
 * Show the best favicon, within reason
 *
 * See: http://www.jonathantneal.com/blog/understand-the-favicon/
 *
 * @since 2.0.4
 */
function torlesse_load_favicons() {

	$favicon_path = get_stylesheet_directory_uri() . '/images/favicons';

	// Use a 144px X 144px PNG for the latest iOS devices
	echo '<link rel="apple-touch-icon" href="' . $favicon_path . '/favicon-144.png">';

	// Alternative: tell iOS not to gloss your icon
	// echo '<link rel="apple-touch-icon-precomposed" href="' . $favicon_path . '/favicon-144.png">';

	// Use a 96px X 96px PNG for modern desktop browsers
	echo '<link rel="icon" href="' . $favicon_path . '/favicon-96.png">';

	// Give IE <= 9 the old favicon.ico (16px X 16px)
	echo '<!--[if IE]><link rel="shortcut icon" href="' . $favicon_path . '/favicon.ico"><![endif]-->';

	// Use a 144px X 144px PNG for Windows tablets
	echo '<meta name="msapplication-TileImage" content="' . $favicon_path . '/favicon-144.png">';

	// Optional: specify a background color for your Windows tablet icon
	// echo '<meta name="msapplication-TileColor" content="#d83434">';

}


add_filter( 'body_class', 'torlesse_no_js_body_class' );
/**
 * Adds a 'no-js' class to <body>, for testing the presence of JavaScript
 *
 * @since 2.0.0
 */
function torlesse_no_js_body_class( $classes ) {

	$classes[] = 'no-js';
	return $classes;

}

/**
 * Remove the header
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_header', 'genesis_do_header' );

/**
 * Remove the site title and/or description
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
// remove_action( 'genesis_site_description', 'genesis_seo_site_description' );