<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one.
 *
 * @link       http://codex.wordpress.org/Template_Hierarchy
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
		<?php if ( have_posts() ) { ?>
			<article class="page-header post archive">
				<header class="entry-header">
					<h1 class="entry-title">
						<?php the_archive_title() ?>
					</h1>
				</header>
			</article>
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
			do_action( 'archy_content_nav' ); // create post in article tag
		} else {
			get_template_part( 'content', 'none' );
		} ?>
	</div><!-- #archy-content-container -->
<?php get_footer();
