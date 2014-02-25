<?php 
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
get_header();
get_sidebar(); ?>
	<div id="archy-content-container" role="main">
		<?php if ( have_posts() ) : ?>
			<article class="page-header post category">
				<header class="entry-header">
					<h1 class="entry-title"><?php printf( __( 'Category Archives: %s', 'archy' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
					<?php if ( category_description() ) : // Show an optional category description ?>
						<div class="archive-meta"><?php echo category_description(); ?></div>
					<?php endif; ?>
				</header>
			</article>
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
			do_action( 'archy_content_nav' ); // create post in article tag
		else :
			get_template_part( 'content', 'none' );
		endif; ?>
	</div><!-- #archy-content-container -->
<?php get_footer(); ?>