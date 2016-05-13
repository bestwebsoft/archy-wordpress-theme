<?php
/**
 * The template for displaying all single posts
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
		<div id="archy-content" role="main">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() ); ?>
				<nav class="archy-nav-single archy-clearfix">
					<span class="archy-nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav-arrow">' . _x( '&lsaquo;&lsaquo;', 'Previous post link', 'archy' ) . '</span> %title' ); ?></span>
					<span class="archy-nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav-arrow">' . _x( '&rsaquo;&rsaquo;', 'Next post link', 'archy' ) . '</span>' ); ?></span>
				</nav><!-- .archy-nav-single -->
				<?php comments_template( '', true );
			endwhile; // end of the loop. ?>
		</div><!-- #archy-content -->
	</div><!-- #archy-content-container -->
<?php get_footer();
