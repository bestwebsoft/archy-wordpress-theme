<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #wrapper, .archy-main-site-container and .archy-main-site div
 * elements.
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
?>
</div><!-- #wrapper -->
<footer>
	<div class="archy-copyright">&copy; <?php echo date_i18n( 'Y' ) . ' ' . wp_get_theme()->get( 'Name' ); ?></div>
	<div class="archy-powered-by"><?php _e( 'Powered by', 'archy' ); ?>
		<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ); ?>">BestWebLayout</a> <?php _e( 'and', 'archy' ); ?>
		<a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>">WordPress</a>
	</div>
</footer>
</div><!-- .archy-main-site-container -->
</div><!-- .archy-main-site -->
<?php wp_footer(); ?>
</body>
</html>
