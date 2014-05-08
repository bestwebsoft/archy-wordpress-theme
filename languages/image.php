<?php
/**
 * The template for displaying image attachments
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
get_header();
get_sidebar(); ?>
<div id="archy-content-container" role="main">
	<div id="archy-content" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<h2 class="date-category">
						<?php $metadata = wp_get_attachment_metadata();
						_e( 'Published', 'archy' ); ?>
						<span class="entry-date">
							<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</span>
						<?php _e( 'at', 'archy' ); ?>
						<a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="Link to full-size image">
							<?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?>
						</a>
						<?php _e( 'in', 'archy' ); ?>
						<a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" title="Return to <?php echo esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ); ?>" rel="gallery">
							<?php echo get_the_title( $post->post_parent ) . "."; ?>
						</a>
						<?php edit_post_link( __( 'Edit', 'archy' ), '<span class="edit-link">', '</span>' ); ?>
					</h2>
				</header>
				<div class="entry-content">
					<div class="entry-attachment">
						<div class="attachment">
							<?php /*
							 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
							 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
							 */
							$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
							foreach ( $attachments as $k => $attachment ) :
								if ( $attachment->ID == $post->ID )
									break;
							endforeach;
							$k++;
							// If there is more than 1 attachment in a gallery
							if ( count( $attachments ) > 1 ) :
								if ( isset( $attachments[ $k ] ) ) :
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
								else :
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
								endif;
							else :
								// or, if there's only 1 image, get the URL of the image
								$next_attachment_url = wp_get_attachment_url();
							endif; ?>
							<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<?php /**
							 * Filter the image attachment size to use.
							 *
							 * @param array $size {
							 *     @type int The attachment height in pixels.
							 *     @type int The attachment width in pixels.
							 * }
							 */
							$attachment_size = apply_filters( 'archy_attachment_size', array( 540, 360 ) );
							echo wp_get_attachment_image( $post->ID, $attachment_size ); ?>
							</a>
							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="wp-caption-text">
								<?php the_excerpt(); ?>
							</div>
							<?php endif; ?>
						</div><!-- .attachment -->
					</div><!-- .entry-attachment -->
					<div class="entry-description">
						<?php the_content();
						wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'archy' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-description -->
				</div><!-- .entry-content -->
			</article><!-- #post -->
			<nav id="archy-image-navigation" class="archy-nav-single archy-clearfix" role="navigation">
				<span class="archy-previous-image archy-nav-previous"><?php previous_image_link( false, __( '&lsaquo;&lsaquo; Previous', 'archy' ) ); ?></span>
				<span class="archy-next-image archy-nav-next"><?php next_image_link( false, __( 'Next &rsaquo;&rsaquo;', 'archy' ) ); ?></span>
			</nav>
			<?php comments_template();
		endwhile; // end of the loop. ?>
	</div><!-- #archy-content -->
</div><!-- #archy-content-container -->
<?php get_footer(); ?>