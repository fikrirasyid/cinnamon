<?php
/**
 * Subtitles Compatibility File
 * See: https://wordpress.org/plugins/subtitles/
 * 
 * @package Cinnamon
 */

/**
 * Making sure that Subtitles has been activated
 */
if( function_exists( 'get_the_subtitle' ) ) :

	/**
	 * Remove default Subtitles front end UI implementation which is filtering the_title
	 * 
	 * @param bool  	current subtitled support
	 * @return bool 	modified subtitles support
	 */
	if( ! function_exists( 'cinnamon_subtitles_remove_default' ) ) :
	function cinnamon_subtitles_remove_default( $subtitle_view_supported ){

		if( ! is_admin() ){

			$subtitle_view_supported = false;

		}

		return $subtitle_view_supported;
	}
	endif;
	add_filter( 'subtitle_view_supported', 'cinnamon_subtitles_remove_default' );

	/**
	 * Replacing categories with subtitle added by Subtitles plugin
	 * 
	 * @param string 	string of categories
	 * @param int 		post ID
	 * @return string 	subtitle or categories list
	 */
	if( ! function_exists( 'cinnamon_subtitles_implementation' ) ) :
	function cinnamon_subtitles_implementation( $the_categories, $post_id ){

		// Get subtitles
		$subtitle = get_the_subtitle( $post_id );

		if( $subtitle ){

			return $subtitle;

		} else {
			
			return $the_categories;

		}
	}
	endif;
	add_filter( 'cinnamon_entry_subtitle', 'cinnamon_subtitles_implementation', 10, 2 );

	/**
	 * Appending categories / taxonomy to posted on section on singular view
	 * To keep the layout simple, we're making a tradeoff, as subtitle is more significant rather than taxonomy list
	 * 
	 * @param string 	posted on data
	 * @param int 		post ID
	 * @return string 	posted on + taxonomy list data
	 */
	if( ! function_exists( 'cinnamon_subtitles_posted_on' ) ) :
	function cinnamon_subtitles_posted_on( $posted_on, $post_id ){

		// Get subtitles
		$subtitle = get_the_subtitle( $post_id );

		if( $subtitle && is_singular() ){

			$entry_subtitle = cinnamon_get_entry_subtitle( $post_id );

			if( $entry_subtitle ){

				return sprintf( __( '%s under <span class="taxonomies">%s</span>', 'cinnamon' ), $posted_on, $entry_subtitle );

			} else {

				return $posted_on;

			}

		} else {
			
			return $posted_on;

		}
	}
	endif;
	add_filter( 'cinnamon_posted_on', 'cinnamon_subtitles_posted_on', 10, 2 );

endif;

/**
 * Removing Subtitles styling
 */
if ( class_exists( 'Subtitles' ) &&  method_exists( 'Subtitles', 'subtitle_styling' ) ) {
    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}