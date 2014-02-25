<?php
/**
 * Implement an optional custom header for Archy
 *
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @subpackage Archy
 * @since Archy 1.3
 *
 * Set up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses archy_header_style() to style front-end.
 * @uses archy_admin_header_style() to style wp-admin form.
 * @uses archy_admin_header_image() to add custom markup to wp-admin form.
 *
 */
function archy_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'	 => '444',
		'default-image'			 => '',
		// Uploads and support header-text
		'uploads'				 => true,
		'header-text'			 => true,
		// Set height and width, with a maximum value for the width.
		'height'				 => 111,
		'width'					 => 940,
		'max-width'				 => 940,
		// Support flexible height and width.
		'flex-height'			 => true,
		'flex-width'			 => false,
		// Random image rotation off by default.
		'random-default'		 => false,
		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'		 => 'archy_header_style',
		'admin-head-callback'	 => 'archy_admin_header_style',
		'admin-preview-callback' => 'archy_admin_header_image',
	);
	add_theme_support( 'custom-header', $args );
}
/**
 * Style the header text displayed on the blog.
 *
 * get_header_textcolor() options: 666666 is default, hide text (returns 'blank'), or any hex value.
 *
 */
function archy_header_style() {
	$text_color = get_header_textcolor();
	// If no custom options for text are set, let's bail
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;
	// If we get this far, we have custom styles. ?>
	<style type="text/css" id="archy-header-css">
	<?php // Has the text been hidden?
		if ( ! display_header_text() ) : ?>
		.archy-site-title,
		.archy-site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php // If the user has set a custom color for the text, use that.
		else : ?>
		.archy-site-header h1 a,
		.archy-site-header h2 {
			color: #<?php echo $text_color; ?>;
		}

		.archy-site-header h2 {
			opacity: 0.7;
		}
	<?php endif; ?>
	</style>
	<?php }
/**
 * Style the header image displayed on the Appearance > Header admin panel.
 */
function archy_admin_header_style() { ?>
	<style type="text/css" id="archy-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg {
		padding: 25px 10px 0 30px;
		position: relative;
	}
	#headimg h1,
	#headimg h2 {
		margin: 0;
		padding: 0;
	}
	#headimg h1 a {
		color: #666;
		display: block;
		font: 900 18pt Arial;
		letter-spacing: 2px;
		max-width: 878px;
		text-decoration: none;
		word-wrap: break-word;
	}
	#headimg h1 a:hover {
		color: #3d8fd5 !important; /* Has to override custom inline style. */
	}
	#headimg h2 {
		color: #aaa;
		font-family: "Arimo", sans-serif;
		font-size: 10pt;
		opacity: 0.7;
		filter: alpfa(Opacity=70%);
		margin-bottom: 21px;
	}
	#headimg img {
		max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
	}
	#headimg .header-image {
		position: absolute;
		left: 0;
		top: 0;
		z-index: -1;
	}
	</style>
<?php }
/**
 * Output markup to be displayed on the Appearance > Header admin panel.
 *
 * This callback overrides the default markup displayed there.
 */
function archy_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( ! display_header_text() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		<?php endif; ?>
		<h1 class="displaying-header-text">
			<a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<h2 id="desc" class="displaying-header-text"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
	</div>
<?php }
/*
 * add action to Wordpress hooks
 */
add_action( 'after_setup_theme', 'archy_custom_header_setup' ); ?>