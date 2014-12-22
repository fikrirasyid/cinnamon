<?php
/**
 * @package Cinnamon
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>

		<div class="entry-featured-image as-background">
			<?php the_post_thumbnail( 'full' ); ?>			
		</div>

	<?php endif; ?>

	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php cinnamon_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>		

		<?php cinnamon_entry_subtitle(); ?>
	</header><!-- .entry-header -->

</article><!-- #post-## -->