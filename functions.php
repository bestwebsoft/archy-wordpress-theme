<?php
/**
 * Archy functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action
 * hook in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @subpackage Archy
 * @since      Archy 1.4
 */

/**
 * Sets up the content width value based on the theme's design.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 940;
}

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

function archy_setup() {
	/*
	 * Makes Archy available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'archy', get_template_directory() . '/languages' );
	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	add_theme_support( 'post-thumbnails' );
	// Adds background image support
	add_theme_support( 'custom-background', array( 'default-color' => '#ddd' ) );
	// Adds support of custom header
	add_theme_support( 'custom-header' );
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	// Styles the visual editor with editor-style.css
	add_editor_style();
	// Custom image size for featured images
	add_image_size( 'post-featured-image', 542, 9999 );
	// image size for slider
	add_image_size( 'slide', 940, 344, true );
	// image size for attachment
	add_image_size( 'attachment', 540, 360, true );
	// image size for custom-header
	add_image_size( 'custom-header', 940, 9999, true );
	// register menu of theme
	register_nav_menu( 'primary', __( 'Navigation Menu', 'archy' ) );
}

// Adds script of navigation menu
function archy_register_scripts() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// Adds functions realized on script.js
	wp_enqueue_script( 'archy-script', get_template_directory_uri() . '/js/script.js', array(
		'jquery',
		'jquery-ui-core',
		'jquery-effects-core',
		'jquery-effects-drop',
	) );
	//Detect plugin. For use on Front End only.
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	// Adds script oriented for http://wordpress.org/plugins/gallery-plugin/ and http://bestwebsoft.com/plugin/portfolio-plugin/
	// check for plugin using plugin name
	if ( is_plugin_active( 'gallery-plugin/gallery-plugin.php' ) || is_plugin_active( 'portfolio/portfolio.php' ) ) {
		wp_enqueue_script( 'archy-pluginsScript', get_template_directory_uri() . '/js/plugins-script.js' );
	}
	// Load the main stylesheet
	wp_enqueue_style( 'archy-style', get_stylesheet_uri() );
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'archy-style-ie', get_template_directory_uri() . '/styles/ie78.css', array( 'archy-style' ) );
	wp_style_add_data( 'archy-style-ie', 'conditional', 'lt IE 9' );
}

/* backwards compatibility title-tag */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	/* customize title if WP version < 4.1 */
	function archy_wp_title( $title, $sep = '|' ) {
		global $page, $paged;

		if ( is_feed() ) {
			return $title;
		}

		/* Add the blog name */
		$title .= get_bloginfo( 'name' );

		/* Add the blog description for the home/front page. */
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description ";
		}

		/* Add a page number if necessary: */
		if ( $paged >= 2 || $page >= 2 ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'archy' ), max( $paged, $page ) );
		}

		return $title;
	}
	/* add wp_title filter if WP version < 4.1 */
	add_filter( 'wp_title', 'archy_wp_title' );

	/* render title in wp_head if WP version < 4.1 */
	function archy_render_title() { ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php }

	add_action( 'wp_head', 'archy_render_title' );
}
/* end backwards compatibility */

function archy_initialize_widgets() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'archy' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears posts and pages', 'archy' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

//function to show the caption of thumbnail
function archy_the_post_caption( $size = '', $attr = '' ) {
	global $post;
	$thumb_id        = get_post_thumbnail_id( $post->ID );
	$args            = array(
		'post_type'   => 'attachment',
		'post_status' => null,
		'parent'      => $post->ID,
		'include'     => $thumb_id,
	);
	$thumbnail_image = get_posts( $args );
	if ( $thumb_id && $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		// Showing the thumbnail caption
		$caption = $thumbnail_image[0]->post_excerpt;
		if ( $caption ) {
			$output = '<p class="thumbnail-caption-text">';
			$output .= $caption;
			$output .= '</p>';
			echo $output;
		};
	}
}

/*
 * Adds a box to the main column on the Post and Page edit screens.
 */
function archy_slider_add_custom_box() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'showonslider',
			__( 'Slider', 'archy' ),
			'archy_slider_inner_custom_box',
			$screen
		);
	}
}

if ( ! function_exists( 'slider_inner_custom_box' ) ) :
	/**
	 * Prints the box content.
	 *
	 * @param WP_Post $post The object for the current post/page.
	 */
	function archy_slider_inner_custom_box( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'slider_inner_custom_box', 'slider_inner_custom_box_nonce' );
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$caption  = get_post_meta( $post->ID, '_caption_slider', true );
		$is_check = get_post_meta( $post->ID, '_add_to_slider', true ); ?>
		<div class="check-to-display">
			<input type="checkbox" id="slider-checkbox" name="slider-checkbox" <?php checked( $is_check ); ?> onchange="document.getElementById('slider-caption').disabled = this.checked != true;" /> <!-- script for disabling input if checkbox unchecked -->
			<label for="slider-checkbox">
				<?php _e( 'Display the featured image in the slider? (Check if you want write caption)', 'archy' ); ?>
			</label>
		</div>
		<label class="slider-caption" for="slider-caption">
			<?php _e( 'Caption on slider area:', 'archy' ); ?>
		</label>
		<input type="text" id="slider-caption" name="slider-caption" value="<?php esc_attr( $caption ) ?>" maxlength="129" size="107" />
	<?php }
endif;

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int $post_id
 */
function archy_slider_save_postdata( $post_id ) {
	/*
	 * We need to verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times.
	 */
	// Check if our nonce is set.
	if ( ! isset( $_POST['slider_inner_custom_box_nonce'] ) ) {
		return $post_id;
	}
	$nonce = $_POST['slider_inner_custom_box_nonce'];
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'slider_inner_custom_box' ) ) {
		return $post_id;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	/* OK, its safe for us to save the data now. */
	// Sanitize user input.
	$mydatacaption = sanitize_text_field( $_POST['slider-caption'] );
	$mydatacheck   = sanitize_text_field( $_POST['slider-checkbox'] );
	// Update the meta field in the database.
	update_post_meta( $post_id, '_caption_slider', $mydatacaption );
	update_post_meta( $post_id, '_add_to_slider', $mydatacheck );
}

if ( ! function_exists( 'archy_slider' ) ) :
	/**
	 * Slider checked post and pages
	 */
	function archy_slider() {
		$the_query = new WP_Query( array(
			'post_type'      => array( 'post', 'page' ),
			'meta_key'       => '_add_to_slider',
			'meta_value'     => 'on',
			'posts_per_page' => '999',
		) );
		// The Loop
		if ( $the_query->have_posts() && archy_is_posts_have_thumbnails( $the_query ) >= 1 ) : ?>
			<div class="archy-slider-container">
				<?php if ( archy_is_posts_have_thumbnails( $the_query ) == 2 ) : ?>
					<div class="archy-left-slider-handler"></div>
					<div class="archy-right-slider-handler"></div>
				<?php endif; ?>
				<div class="archy-slider">
					<?php while ( $the_query->have_posts() ) :
						$the_query->the_post();
						if ( get_the_post_thumbnail( get_the_ID(), 'slide' ) ) : ?>
							<div>
								<?php echo get_the_post_thumbnail( get_the_ID(), 'slide' ); ?>
								<div class="archy-slider-description">
									<h1 class="archy-slider-title">
										<a href="<?php echo get_permalink(); ?>">
											<?php echo get_the_title(); ?>
										</a>
									</h1>
									<p class="archy-slider-text">
										<?php echo get_post_meta( get_the_ID(), '_caption_slider', true ); ?>
									</p>
								</div>
								<div class="archy-slider-background-description">&nbsp;</div>
							</div>
						<?php endif;
					endwhile; ?>
				</div>
			</div>
		<?php endif;
		/* Restore original Post Data */
		wp_reset_postdata();
	}
endif;

if ( ! function_exists( 'archy_is_posts_have_thumbnails' ) ) :
	/**
	 * @param $user_query
	 *
	 * @return int
	 * 0 - haven't thumbnails
	 * 1 - have one thumbnail
	 * 2 - have two or more thumbnails
	 */
	function archy_is_posts_have_thumbnails( $user_query ) {
		$count = 0;
		while ( $user_query->have_posts() ) {
			$user_query->the_post();
			if ( get_the_post_thumbnail( get_the_ID(), 'slide' ) ) {
				$count ++;
				if ( 2 == $count ) {
					$user_query->rewind_posts();

					return 2;
				}
			}
		}
		$user_query->rewind_posts();

		return $count;
	}
endif;

if ( ! function_exists( 'archy_content_nav' ) ) :
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @return void
	 */
	function archy_content_nav() {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) : ?>
			<article class="post category paging-nav">
				<div class="entry-header">
					<nav class="navigation paging-navigation" role="navigation">
						<div class="nav-links">
							<div class="archy-nav-previous"><?php next_posts_link( '<span class="meta-nav older-posts">&lsaquo;&lsaquo;</span> ' . __( 'Older posts', 'archy' ) ); ?></div>
							<div class="archy-nav-next"><?php previous_posts_link( __( 'Newer posts', 'archy' ) . ' <span class="meta-nav newer-posts">&rsaquo;&rsaquo;</span>' ); ?></div>
						</div><!-- .nav-links -->
					</nav><!-- .navigation -->
				</div>
			</article>
		<?php endif;
	}
endif;

if ( ! function_exists( 'archy_slider_custom_styles' ) ) :
	/**
	 * Adds styles to admin for theme's slider
	 */
	function archy_slider_custom_styles() {
		echo '<style type="text/css">
			.inside .check-to-display { margin-bottom: 5px; }
			.inside .check-to-display #slider-checkbox { margin-right: 4px; }
			.inside .check-to-display + .slider-caption { margin-right: 3px; }
		</style>';
	}
endif;

/**
 * Add actions
 */
add_action( 'after_setup_theme', 'archy_setup' );
add_action( 'admin_head', 'archy_slider_custom_styles' );
add_action( 'wp_enqueue_scripts', 'archy_register_scripts' );
add_action( 'widgets_init', 'archy_initialize_widgets' );
add_action( 'archy_post_caption', 'archy_the_post_caption' );
add_action( 'add_meta_boxes', 'archy_slider_add_custom_box' );
add_action( 'save_post', 'archy_slider_save_postdata' );
add_action( 'archy_slider', 'archy_slider' );
add_action( 'archy_content_nav', 'archy_content_nav' );
