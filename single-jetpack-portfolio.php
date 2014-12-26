<?php
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php cinnamon_entry_subtitle(); ?>
				
				<div class="entry-featured-image">
					<?php the_post_thumbnail(); ?>					
				</div><!-- .entry-featured-image -->

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'cinnamon' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>
