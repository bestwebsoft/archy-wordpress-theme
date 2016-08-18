<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */
?>
<div id="secondary" class="widget-area">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) :
		dynamic_sidebar( 'sidebar-1' );
	else :
		$args = array(
			'before_widget' => '<aside class="widget %s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		);
		$instance = array();
		the_widget( 'WP_Widget_Search', $instance, $args );
		the_widget( 'WP_Widget_Recent_Posts', $instance, $args );
		the_widget( 'WP_Widget_Recent_Comments', $instance, $args );
		the_widget( 'WP_Widget_Archives', $instance, $args );
		the_widget( 'WP_Widget_Categories', $instance, $args );
	endif; /* is_active_sidebar */ ?>
</div><!-- #secondary -->
