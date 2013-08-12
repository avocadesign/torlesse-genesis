<?php
/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

// Set TRUE / FALSE depending on which layout you want
// TRUE = Full width layout
// FALSE = Boxed layout

$design_fullwidth = TRUE; 
//$design_fullwidth = FALSE; 

/**
 * Add site wide body class to determine design layout
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 *
 *@since 2.0.1
 */
if ( $design_fullwidth == TRUE ) {
	add_filter( 'body_class', 'torlesse_body_class_fullwidth' );
} else {
	add_filter( 'body_class', 'torlesse_body_class_boxed' );
}

// adds .design-fullwidth to body tag
function torlesse_body_class_fullwidth( $classes ) {
$classes[] = 'design-fullwidth';
	return $classes;
}

// adds .design-boxed to body tag
function torlesse_body_class_boxed( $classes ) {
$classes[] = 'design-boxed';
	return $classes;
}