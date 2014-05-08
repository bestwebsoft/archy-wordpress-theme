<?php 
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @subpackage Archy
 * @since Archy 1.4
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
if ( have_comments() ) : ?>
	<h3 id="comments">
		<?php printf( _n( __( 'One Response to %2$s', 'archy' ), __( '%1$s Responses to %2$s', 'archy' ), get_comments_number() ), number_format_i18n( get_comments_number() ), '&#8220;' . get_the_title() . '&#8221;' ); ?>
	</h3>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php else : // this is displayed if there are no comments so far 
 	if ( comments_open() ) :
 	else : // comments are closed ?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'archy' ); ?></p>
	<?php endif;
endif;
comment_form(); ?>
