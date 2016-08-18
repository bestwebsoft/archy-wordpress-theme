<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="archy-featured-post">
			<?php _e( 'Featured post', 'archy' ); ?>
		</div>
	<?php endif; ?>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
			<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>
		<h2 class="date-category">
			<?php _e( 'Posted on', 'archy' );
			if ( is_singular() ) {
				$archy_date_link = get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) );
			} else {
				$archy_date_link = get_the_permalink();
			} ?>
			<a href="<?php echo esc_url( $archy_date_link ); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_date(); ?></a>
			<?php if ( has_category() ) :
				_e( ' in', 'archy' );
				echo '&nbsp;';
				the_category( ', ' );
			endif; // if this post aren't page ?>
		</h2>
		<?php the_post_thumbnail( 'post-featured-image' );
		do_action( 'archy_post_caption' ); ?>
	</header><!-- .entry-header -->
	<?php if ( is_search() ) : // is search() ?>
		<div class="entry-summary archy-clearfix">
			<?php the_excerpt(); ?>
		</div>
	<?php else : ?>
		<div class="entry-content archy-clearfix">
			<?php the_content();
			wp_link_pages( array(
				'before'      => '<div class="post-page-links"><span class="post-page-links-title">' . __( 'Pages:', 'archy' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) ); ?>
		</div><!-- .entry-content -->
	<?php endif;
	if ( ( comments_open() && ! is_single() )
	     || ( $wp_query->current_post > 0 && ! is_single() )
	     || get_the_tag_list()
	     || current_user_can( 'edit_post', get_the_ID() )
	) : ?>
		<footer class="entry-meta">
			<?php printf( '<hr class = "tags-separator" />' );
			if ( has_tag() ) {
				echo '<div class="tag-list"';
				if ( ( comments_open() && ! is_singular() )
				     || ( $wp_query->current_post > 0 && ! is_single() )
				) {
					echo '<div class="tag-list" style="width: 100%;">';
				} else {
					echo '<div class="tag-list">';
				}
				the_tags();
				echo '</div>';
			}
			if ( comments_open() && ! is_singular() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'archy' ) . '</span>', __( 'One comment so far', 'archy' ), __( 'View all comments: ', 'archy' ) . '%' ); ?>
				</div>
			<?php endif; // comments_open() 
			if ( $wp_query->current_post > 0 && ! is_single() ) :
				printf( '<div class="top-link"><a href = "#wrapper">[' . __( 'Top', 'archy' ) . ']</a></div>' );
			endif;
			edit_post_link( '[' . __( 'Edit', 'archy' ) . ']', '<div class="edit-link">', '</div>' ); ?>
		</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post -->
