<?php
/**
 * @package Cinnamon
 */
?>

<?php if( has_post_thumbnail() ) : ?>

	<div class="entry-featured-post">
		<?php the_post_thumbnail( 'full' ); ?>
	</div><!-- .entry-featured-post -->

<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php cinnamon_posted_on(); ?>
		</div><!-- .entry-meta -->
		
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php cinnamon_entry_subtitle(); ?>		
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'cinnamon' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php cinnamon_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
