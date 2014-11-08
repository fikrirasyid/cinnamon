<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Cinnamon
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php printf( __( 'Powered by %s &amp; %s', 'cinnamon' ), '<a href="http://wordpress.org/">WordPress</a>', '<a href="http://fikrirasy.id/portfolio/cinnamon/">Cinnamon Theme</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
