<?php 
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
?>
<div id="secondary" class="widget-area">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) :
		dynamic_sidebar( 'sidebar-1' );
	else : /* is_active_sidebar */ ?>
		<aside class="widget widget_search">
			<h4 class="widget-title"><?php _e( 'Search', 'archy' ) ?></h4>
			<form role="search" method="get" id="searchform" class="searchform" action="http://task2.kra.loc/">
				<div>
					<label class="screen-reader-text" for="s" style=""><?php _e( 'Enter search keyword', 'archy' ) ?></label>
					<input type="text" value="" name="s" id="s">
					<input type="submit" id="searchsubmit" value="Search">
				</div>
			</form>
		</aside>
		<aside class="widget widget_recent_posts">
			<h4 class="widget-title" ><?php _e( 'recent posts', 'archy' ); ?></h4>
			<ul>
				<?php $args = array( 'numberposts' => 5 );
				$recent_posts = wp_get_recent_posts( $args );
				foreach ( $recent_posts as $recent ) : ?>
					<li class="recentposts"><a href="<?php echo get_permalink( $recent["ID"] ); ?>" title="Look <?php echo esc_attr( $recent["post_title"] ); ?>" ><?php echo $recent["post_title"]; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</aside>
		<aside class="widget widget_recent_comments">
			<h4 class="widget-title"><?php _e( 'recent comments', 'archy' ); ?></h4>
			<ul>
				<?php $args = array( 'number' => 5, );
				$comments = get_comments( $args );
				foreach( $comments as $comment ) : ?>
					<li class="recentcomments">
						<?php if( esc_url( $comment->comment_author_url ) ) : ?>
							<a href="<?php echo esc_url( $comment->comment_author_url ) . " "; ?>">
						<?php endif; echo $comment->comment_author;
						if( esc_url( $comment->comment_author_url ) . "&nbsp;" ) : ?>
							</a>
						<?php endif;
						_e( 'on', 'archy' ) ?>&nbsp;<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</aside>
		<aside class="widget widget_archive">
			<h4 class="widget-title"><?php _e( 'archives', 'archy' ); ?></h4>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>
		<aside class="widget widget_categories">
			<h4 class="widget-title"><?php _e( 'categories','archy' ); ?></h4>
			<ul>
				<?php	$args = array( 'orderby' => 'name',	'parent' => 0 );
				$categories = get_categories();
				foreach ( $categories as $category ) : ?>
					<li><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo $category->name; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</aside>
	<?php endif; /* is_active_sidebar */ ?>
</div><!-- #secondary -->
