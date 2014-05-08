<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #wrapper, .archy-main-site-container and .archy-main-site div elements.
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
?>
		</div><?php // end wrapper ?>
		<footer>
			<div class="archy-copyright">&copy; <?php echo date( 'Y' ); ?> <?php echo wp_get_theme()->get( 'Name' ); ?></div>
			<div class="archy-powered-by"><?php _e( 'Powered by', 'archy' ); ?> 
				<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ); ?>">BestWebSoft</a> <?php _e( 'and', 'archy' ); ?> 
				<a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>">WordPress</a>
			</div>
		</footer>
		</div><?php //.archy-main-site-container ?>
	</div><?php //.archy-main-site 
	wp_footer(); ?>
</body>
</html> 