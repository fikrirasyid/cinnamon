<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Cinnamon
 */
global $paged;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'cinnamon' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrap">
			<div class="site-branding">
				<h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle dashicons dashicons-menu"><?php _e( 'Primary Menu', 'cinnamon' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #site-navigation -->		
		</div>
	</header><!-- #masthead -->
	
	<?php if ( is_home() && 0 == $paged  ) : // Homepage ?>

		<div class="page-header">
			<div class="background"></div>
			<h1 class="page-title"><?php bloginfo( 'name' ); ?></h1>
			<h2 class="page-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- #home-cover -->

	<?php elseif ( is_archive() ) : // Archive Template ?>

			<header class="page-header">
				<div class="background"></div>
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'cinnamon' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'cinnamon' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( '%s', 'cinnamon' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cinnamon' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'cinnamon' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cinnamon' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'cinnamon' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'cinnamon' );

						else :
							_e( 'Archives', 'cinnamon' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="page-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

	<?php elseif ( is_search() ) : // Search Template ?>

			<header class="page-header">
				<div class="background"></div>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'cinnamon' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

	<?php elseif ( is_singular() || is_page() ) : // Search Template ?>

		<?php global $post; ?>
		
		<?php 
			if( has_post_thumbnail( $post->ID ) ) : 
				
				$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

				if( isset( $featured_image_url[0] ) ) :
					?>

					<header class="page-header entry-featured-image-wrap">
						<div class="background" style="background: url( <?php echo $featured_image_url[0]; ?> ) no-repeat center center; background-size: cover;"></div>
						<h1 class="page-title"><?php echo get_the_title( $post->ID ); ?></h1>
						<?php cinnamon_entry_subtitle( $post->ID, 'page-description' ); ?>						
					</header><!-- .page-header -->	

					<?php 

				else :

					?>

					<header class="page-header">
						<div class="background"></div>
						<h1 class="page-title"><?php echo get_the_title( $post->ID ); ?></h1>
						<?php cinnamon_entry_subtitle( $post->ID, 'page-description' ); ?>						
					</header><!-- .page-header -->	

					<?php
				endif; 

				else :
					
				?>

				<header class="page-header">
					<div class="background"></div>
					<h1 class="page-title"><?php echo get_the_title( $post->ID ); ?></h1>
					<?php cinnamon_entry_subtitle( $post->ID, 'page-description' ); ?>						
				</header><!-- .page-header -->	

				<?php

			endif; 
		?>

	<?php elseif ( is_404() ) : // Search Template ?>

				<header class="page-header">
					<div class="background"></div>
					<h1 class="page-title"><?php _e( 'Page Not Found', 'cinnamon' ); ?></h1>
					<h2 class="page-description"><?php _e( 'Nothing was found at this location. Try one of the links below or a search:', 'cinnamon' ); ?></h2>
				</header><!-- .page-header -->

	<?php endif; ?>

	<div id="content" class="site-content wrap">
