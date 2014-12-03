<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cinnamon
 */

if( ! function_exists( 'cinnamon_paging_nav_newer' ) ) :
/**
 * Display navigation to newer set of posts when applicable.
 */
function cinnamon_paging_nav_newer() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<?php if ( get_previous_posts_link() ) : ?>

	<nav class="navigation paging-navigation newer" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'cinnamon' ); ?></h1>
		<div class="nav-links">
			<div class="nav-next"><?php previous_posts_link( __( 'Newer stories', 'cinnamon' ) ); ?></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->

	<?php endif; ?>

	<?php
}
endif; 

if ( ! function_exists( 'cinnamon_paging_nav_older' ) ) :
/**
 * Display navigation to older set of posts when applicable.
 */
function cinnamon_paging_nav_older() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<?php if ( get_next_posts_link() ) : ?>

	<nav class="navigation paging-navigation older" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'cinnamon' ); ?></h1>
		<div class="nav-links">
			<div class="nav-previous"><?php next_posts_link( __( 'More stories', 'cinnamon' ) ); ?></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->

	<?php endif; ?>

	<?php
}
endif;

if ( ! function_exists( 'cinnamon_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function cinnamon_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'cinnamon' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav nav-previous">%link</div>', _x( '<span class="meta-label">Previously</span>%title', 'Previous post link', 'cinnamon' ) );
				next_post_link(     '<div class="nav nav-next">%link</div>',     _x( '<span class="meta-label">Read Next</span>%title', 'Next post link',     'cinnamon' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'cinnamon_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function cinnamon_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'M j, Y' ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	if( is_singular() ){

		$posted_on = __( 'Posted on: ', 'cinnamon' ) . '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	} else {

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	}

	echo '<span class="posted-on">' . $posted_on . '</span>';

	if( is_singular() ){
		edit_post_link( __( 'Edit', 'cinnamon' ), '<span class="edit-link">', '</span>' );
	}
}
endif;

if ( ! function_exists( 'cinnamon_entry_subtitle' ) ) :
/**
 * Prints HTML "sub-title" if there's any subtitle plugin. If there's no subtitle plugin, print category elegantly (using ampersand for the last category)
 */
function cinnamon_entry_subtitle( $post_id = false, $class = 'entry-subtitle' ){

	// If no post_id defined, assume that this is used inside the loop
	if( ! $post_id ){
		$post_id = get_the_ID();
	}

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type( $post_id ) && 'aside' != get_post_format( $post_id ) ) {
		// Get category list
		$categories = get_the_category_list( __( ', ', 'cinnamon' ), '', $post_id );
		
		// Explode into array by comma
		$categories_list = explode(', ', $categories );

		// Count the number of category. 1 = just print it, 2 = separate with ampersand, n = separate the last category with ampersand (oxford style)
		$categories_count = count( $categories_list );

		// Check category count, prepare the categories to be printed
		if ( 2 < $categories_count ) {

			$the_categories = '';
	
			$cat_index = 0;

			// Loop and printc categories
			foreach ( $categories_list as $cat ) {
				$cat_index++;

				if( $cat_index > 1 && $cat_index < $categories_count ){
					$the_categories .= ', ';
				}

				if( $cat_index > 1 && $cat_index == $categories_count ){
					$the_categories .= ', &amp; ';
				}

				$the_categories .= $cat;
			}

		} elseif( 2 == $categories_count ) {

			$the_categories = '';
	
			$cat_index = 0;

			// Loop and printc categories
			foreach ( $categories_list as $cat ) {
				$cat_index++;

				if( $cat_index > 1 && $cat_index == $categories_count ){
					$the_categories .= ' &amp; ';
				}

				$the_categories .= $cat;
			}			

		} else {
			$the_categories = $categories;
		}

		printf( '<h3 class="'. $class  .'">' . __( 'on %1$s', 'cinnamon' ) . '</h3>', $the_categories );
	}
}
endif;

if ( ! function_exists( 'cinnamon_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function cinnamon_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'cinnamon' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="section-title">' . __( 'Tagged', 'cinnamon' ) . '</span> %1$s</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'cinnamon' ), __( '1 Comment', 'cinnamon' ), __( '% Comments', 'cinnamon' ) );
		echo '</span>';
	}
}
endif;

if( ! function_exists( 'cinnamon_comment' ) ) :
/**
 * Prints HTML of single comment
 */
function cinnamon_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	
	<div class="comment-identity">
		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
		</div>

		<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date*/
				printf( __('on %1$s'), get_comment_date( 'M j, Y' ) ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
			?>
		</div>
		
	</div>

	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
	<?php endif; ?>
	
	<div class="comment-content">
		<?php comment_text(); ?>	
	</div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cinnamon_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'cinnamon_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'cinnamon_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so cinnamon_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so cinnamon_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in cinnamon_categorized_blog.
 */
function cinnamon_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'cinnamon_categories' );
}
add_action( 'edit_category', 'cinnamon_category_transient_flusher' );
add_action( 'save_post',     'cinnamon_category_transient_flusher' );

