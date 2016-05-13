<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
		<div id="archy-content" role="main">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
				comments_template( '', true );
			endwhile; // end of the loop. ?>
		</div><!-- #archy-content -->
	</div><!-- #archy-content-container -->
<?php get_footer();
