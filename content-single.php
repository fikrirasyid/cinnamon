<?php
/**
 * @package Cinnamon
 */
?>

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

	<footer class="entry-footer">
		<div class="entry-meta">
			<?php cinnamon_posted_on(); ?>
		</div><!-- .entry-meta -->
		
		<?php cinnamon_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
