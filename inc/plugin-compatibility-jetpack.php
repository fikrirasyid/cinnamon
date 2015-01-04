<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Cinnamon
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
if ( ! function_exists( 'cinnamon_jetpack_setup' ) ):
function cinnamon_jetpack_setup() {
	// Declaring infinite scroll support
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );

	// Declaring site logo support
	add_image_size( 'site-logo', 0, 22 );
	add_theme_support( 'site-logo', array(
		'header-text' => array(
			'site-title'
		),
		'size' => 'site-logo',
	));
}
endif;
add_action( 'after_setup_theme', 'cinnamon_jetpack_setup' );