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
			'site-title',
			'site-description'
		),
		'size' => 'site-logo',
	));
}
endif;
add_action( 'after_setup_theme', 'cinnamon_jetpack_setup' );


/**
 * Jetpack site logo enhancement
 */
if( ! function_exists( 'cinnamon_jetpack_the_site_logo' ) ) :
function cinnamon_jetpack_the_site_logo( $html, $logo, $size ){

	// Site logo will display nothing on the site logo section if there's no site-logo defined
	// Override it. It's similar to Jetpack's default placeholder, except for title tag for replacing default site name
	// If no logo is set, but we're in the Customizer, leave a placeholder (needed for the live preview).
	if ( ! jetpack_has_site_logo() ) {
		if ( jetpack_is_customize_preview() ) {
			$customizer_site_logo = sprintf( '<a href="%1$s" class="site-logo-link"><img class="site-logo" data-size="%2$s" title="%3$s" /></a>',
				esc_url( home_url( '/' ) ),
				esc_attr( $size ),
				esc_attr( get_bloginfo( 'name' ) )
			);

			return $customizer_site_logo;
		}
	}	


	if( '' == $html ){

		return cinnamon_get_site_title();

	} else {

		return $html;

	}
}
endif;
add_filter( 'jetpack_the_site_logo', 'cinnamon_jetpack_the_site_logo', 10, 3 );