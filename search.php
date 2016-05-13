<?php
/**
 * The template for displaying Search Results pages
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
		<?php if ( have_posts() ) : ?>
			<article class="page-header post">
				<header class="entry-header">
					<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'archy' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
			</article>
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
			do_action( 'archy_content_nav' ); // create post in article tag
		else : ?>
			<article class="page-header post">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'archy' ); ?></h1>
				</header>
				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'archy' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article>
			<?php do_action( 'archy_content_nav' ); // create post in article tag
		endif; ?>
	</div><!-- #archy-content-container -->
<?php get_footer();
