<?php
/**
 * Cinnamon Theme Customizer
 *
 * @package Cinnamon
 */

/**
 * Safer way to check if plugin is active
 * is_plugin_active() throws error when being used inside customize_register hook
 * 
 * @param string plugin file
 * @return bool
 */
if( ! function_exists( 'cinnamon_is_plugin_active' ) ):
function cinnamon_is_plugin_active( $plugin ){
	$active_plugins = get_option( 'active_plugins' );

	if( in_array( $plugin, $active_plugins ) ){
		return true;
	} else {
		return false;
	}
}
endif;

/**
 * WordPress' native sanitize_hex_color seems to be hasn't been loaded
 * Provide theme's customizer with its own hex color sanitation
 */
if( ! function_exists( 'cinnamon_sanitize_hex_color' ) ) :
function cinnamon_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}
endif;

if ( ! function_exists( 'cinnamon_sanitize_hex_color_no_hash' ) ) :
function cinnamon_sanitize_hex_color_no_hash( $color ){
	$color = ltrim( $color, '#' );

	if ( '' === $color )
		return '';

	return cinnamon_sanitize_hex_color( '#' . $color ) ? $color : null;	
}
endif;

/**
 * Adding custom field for theme's customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if( ! function_exists( 'cinnamon_customize_register' ) ) :
function cinnamon_customize_register( $wp_customize ) {
	// Remove  header textcolor control
	$wp_customize->remove_control( 'header_textcolor' );

	// Add accent color control
	// This option relies on Jetpack's preprocessor. Display if Jetpack is active
	if( cinnamon_is_plugin_active( 'jetpack/jetpack.php' ) ){
		
		$wp_customize->add_setting( 'accent_color', array(
			'default'           => '#F2E6D7',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
			'label'       => esc_html__( 'Accent color', 'cinnamon' ),
			'description' => esc_html__( 'Select one light color of your choice. Cinnamon will adjust its color scheme based on this color of choice..', 'cinnamon' ),
			'section'     => 'colors',
		) ) );

	}
}
endif;
add_action( 'customize_register', 'cinnamon_customize_register' );


/**
 * Provide scss which is used for generating color schemes
 */
if ( ! function_exists( 'cinnamon_color_scheme_scss' ) ) :
function cinnamon_color_scheme_scss( $accent_color ){

	// Sanitize color scheme hexacode
	if( ! cinnamon_sanitize_hex_color( $accent_color ) ){
		return false;
	}

	$scss = '
		// Colors
		$color__accent: '. $accent_color .';
		$color__link: darken( $color__accent, 60% );
		$color__link-visited: darken( $color__accent, 50% );
		$color__link-hover: darken( $color__accent, 40% );
		$color__link-shadow: darken( $color__link, 20% );
		$color__text-title: darken( $color__accent, 78% );
		$color__secondary-bg: lighten( $color__accent, 10% );

		// _header
		body{
			border-color: $color__accent;
		}

		#masthead{			
			.site-title{
				a{
					color: $color__text-title;
				}
			}
		}		

		#site-navigation{
			.menu-toggle{
				color: $color__text-title;
			}
		}

		.page-header{
			.background{
				background: $color__accent;
			}

			&.no-background-image{
				.page-title,
				.page-description{
					color: $color__text-title;

					a{				
						color: $color__text-title;
					}
				}
			}
		}

		// _buttons
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"] {
			background: $color__link;
			box-shadow: 0 3px 0 $color__link-shadow;
		}

		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover {
			background: $color__link-hover;
		}

		button:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		input[type="submit"]:focus,
		button:active,
		input[type="button"]:active,
		input[type="reset"]:active,
		input[type="submit"]:active {
			background: $color__link-visited;
		}

		// _fields
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		textarea:focus {
			border-color: $color__link;
		}

		// _links
		a{
			color: $color__link;

			&:hover,
			&:focus,
			&:active {
				color: $color__link-hover;
			}
		}

		// _menus
		.main-navigation {
			a {
				color: $color__text-title;
			}
		}

		.paging-navigation{
			a{
				border-color: $color__link;

				&:hover{
					border-color: $color__link-hover;
				}
			}
		}

		// _comments 
		#cancel-comment-reply-link,
		.comment-reply-link{
			&:hover{
				border-color: $color__link;
				color: $color__link;
			}

			&:active{
				border-color: $color__link-visited;
			}
		}

		// _posts-and-pages
		.hentry {
			.entry-header{
				.edit-link{
					a{
						border: 1px solid $color__link;
						color: $color__link;
					}
				}		
			}

			.entry-title{
				color: $color__text-title;

				a{
					color: $color__text-title;
				}
			}

			.tags-links{
				a{
					color: $color__link;
					border-color: $color__link;
				}
			}
		}

		// _copy 
		.comment-content,
		.entry-content{
			h1{
				color: $color__text-title;
			}

			h2{
				color: $color__text-title;
			}

			h3{
				color: $color__text-title;
			}

			h4{
				color: $color__text-title;
			}

			b, strong {
				color: $color__text-title;
			}

			address {
				color: $color__text-title;
			}

			code, kbd, tt, var {
				color: $color__text-title;
			}
		}

		// _widgets 
		#secondary{
			background: $color__secondary-bg;
		}

		.widget-title,
		.widgettitle{
			color: $color__text-title;
		}

		// _jetpack
		.single-jetpack-portfolio{
			.entry-title{
				color: $color__text-title;
			}

			.entry-subtitle{
				color: $color__text-title;

				a{
					color: $color__text-title;			
				}
			}
		}		
	';

	return $scss;
}
endif;

/**
 * Load and binds JS handlers to make certain parts of Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'cinnamon_customize_preview_js' ) ) :
function cinnamon_customize_preview_js() {
	// Enqueue the script
	wp_enqueue_script( 'cinnamon-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20141215', true );

	// Attaching variables
	wp_localize_script( 'cinnamon-customizer', 'cinnamon_customizer_params', array(
		'generate_color_scheme_endpoint' 		=> admin_url( 'admin-ajax.php?action=cinnamon_generate_customizer_color_scheme' ),
		'generate_color_scheme_error_message' 	=> __( 'Error generating color scheme. Please try again.', 'cinnamon' ),
		'clear_customizer_settings'				=> admin_url( 'admin-ajax.php?action=cinnamon_clear_customizer_settings' ),
	) );

	// Display color scheme previewer
	$color_scheme = get_theme_mod( 'color_scheme_customizer', false );

	if( $color_scheme ){
		remove_action( 'wp_enqueue_scripts', 'cinnamon_color_scheme' );

		wp_enqueue_style( 'cinnamon-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );

		$inline_style = wp_add_inline_style( 'cinnamon-style', $color_scheme );
	}	
}
endif;
add_action( 'customize_preview_init', 'cinnamon_customize_preview_js' );

/**
 * Generate color scheme based on one accent color choosen by user
 * This function requires Jetpack to be active
 */

/**
 * Jetpack's preprocessor's file path
 */
function cinnamon_jetpack_sass_preprocessor_path(){
	return WP_PLUGIN_DIR . '/jetpack/modules/custom-css/custom-css/preprocessors.php';
}

/**
 * Generate color scheme based on one accent color choosen by user
 * This function requires Jetpack to be active
 */
if ( ! function_exists( 'cinnamon_generate_color_scheme' ) ) :
function cinnamon_generate_color_scheme(){

	// Only process this if Jetpack is active and jetpack preprocessors file exists
	if( cinnamon_is_plugin_active( 'jetpack/jetpack.php') && file_exists( cinnamon_jetpack_sass_preprocessor_path() ) ) :

		$accent_color = get_theme_mod( 'accent_color', false );

		if( $accent_color ){

			// SCSS template
			$color_scheme = cinnamon_color_scheme_scss( $accent_color );
 
			// Bail if color scheme doesn't generate valid CSS
			if( ! $color_scheme ){
				return;
			}

			// Make sure that jetpack_sass_css_preprocess() exists
			if( ! function_exists( 'jetpack_sass_css_preprocess' ) ){
				require_once( cinnamon_jetpack_sass_preprocessor_path() );
			}

			// Generate CSS
			$css 	= jetpack_sass_css_preprocess( $color_scheme );

			// Set Color Scheme
			set_theme_mod( 'color_scheme', $css );

			// Remove Customizer Color Scheme
			remove_theme_mod( 'color_scheme_customizer' );
		}

	endif;

}
endif;
add_action( 'customize_save_after', 'cinnamon_generate_color_scheme' );

/**
 * AJAX endpoint for generating color scheme in near real time for customizer
 */
if( ! function_exists( 'cinnamon_generate_customizer_color_scheme' ) ) :
function cinnamon_generate_customizer_color_scheme(){

	if( isset( $_GET['accent_color'] ) && cinnamon_sanitize_hex_color_no_hash( $_GET['accent_color'] ) && cinnamon_is_plugin_active( 'jetpack/jetpack.php' ) && file_exists( cinnamon_jetpack_sass_preprocessor_path() ) ){

		// Get accent color
		$accent_color = cinnamon_sanitize_hex_color_no_hash( $_GET['accent_color'] );

		if( $accent_color ){

			$accent_color = '#' . $accent_color;

			// SCSS template
			$color_scheme = cinnamon_color_scheme_scss( $accent_color );

			// Make sure that jetpack_sass_css_preprocess() exists
			if( ! function_exists( 'jetpack_sass_css_preprocess' ) ){
				require_once( cinnamon_jetpack_sass_preprocessor_path() );
			}

			// Generate CSS
			$css 	= jetpack_sass_css_preprocess( $color_scheme );

			// Set Color Scheme
			set_theme_mod( 'color_scheme_customizer', $css );

			$generate = array( 'status' => true, 'colorscheme' => $css );

		} else {

			$generate = array( 'status' => false, 'colorscheme' => false );

		}
	} else {

		$generate = array( 'status' => false, 'colorscheme' => false );

	}

	// Transmit message

	echo json_encode( $generate ); 

	die();
}
endif;
add_action( 'wp_ajax_cinnamon_generate_customizer_color_scheme', 'cinnamon_generate_customizer_color_scheme' );

/**
 * Endpoint for clearing all customizer temporary settings
 * This is made to be triggered via JS call (upon tab is closed)
 * 
 * @return void
 */
if( ! function_exists( 'cinnamon_clear_customizer_settings' ) ) :
function cinnamon_clear_customizer_settings(){
	if( current_user_can( 'customize' ) ){
		remove_theme_mod( 'color_scheme_customizer' );		
	}

	die();
}
endif;
add_action( 'wp_ajax_cinnamon_clear_customizer_settings', 'cinnamon_clear_customizer_settings' );