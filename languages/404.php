<?php 
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
			<article id="post-0" class="page-header post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'archy' ); ?></h1>
				</header>
				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'archy' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
	</div><!-- #archy-content-container -->
<?php get_footer(); ?>