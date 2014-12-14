<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package Cinnamon
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses cinnamon_header_style()
 * @uses cinnamon_admin_header_style()
 * @uses cinnamon_admin_header_image()
 */
function cinnamon_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'cinnamon_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/images/cinnamon-default-header.jpg',
		'width'                  => 1440,
		'height'                 => 450,
		'wp-head-callback'       => 'cinnamon_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'cinnamon_custom_header_setup' );

if ( ! function_exists( 'cinnamon_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see cinnamon_custom_header_setup().
 */
function cinnamon_header_style() {
	$header_image = get_header_image();

	// Header image on page and single page is defined by featured image
	if ( is_singular() || is_page() ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		#page .page-header .background{
			background: url( <?php echo $header_image; ?> ) no-repeat center center; 
			background-size: cover;
		}
	</style>
	<?php
}
endif; // cinnamon_header_style