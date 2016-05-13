<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link       http://codex.wordpress.org/Template_Hierarchy
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div class="archy-main-content">
		<?php if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
			do_action( 'archy_content_nav' );
		else :
			get_template_part( 'content', 'none' );
		endif; ?>
	</div><!-- .archy-main-content -->
<?php get_footer();
