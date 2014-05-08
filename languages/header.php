<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="wrapper">
 *
 * @subpackage Archy
 * @since Archy 1.4
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php  // Loads selectivizr JavaScript file to add support for newest css pseudoclasses. ?>
	<!--[if (gte IE 6)&(lte IE 8)]>
	  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js"></script>
	  <noscript><link rel="stylesheet" href="[fallback css]" /></noscript>
	<![endif]-->
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="archy-main-site">
		<div class="archy-main-site-container">
			<header class="archy-site-header archy-clearfix" <?php if( get_header_image() ) : ?> style="height: <?php echo get_custom_header()->height; ?>px;" <?php endif; ?>>

				<?php if( get_header_image() ) : ?>
					<div class="archy-custom-header archy-clearfix">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</div>
				<?php endif; ?>

				<div class="archy-site-header-container archy-clearfix">
					<div class="archy-site-header-container-group">
						<hgroup class="archy-site-title-desctiption">
							<h1 class="archy-site-title"><a href="<?php echo esc_url( home_url() ); ?>"><?php echo bloginfo( 'name' ); ?></a></h1>
							<h2 class="archy-site-description"><?php bloginfo( 'description' ); ?></h2>
						</hgroup>
						<nav id="navigation" class="archy-main-navigation">
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>	
						</nav>
					</div>
				</div>
				<!--<script type="text/javascript">
					(function( $ ) {
							$( '.archy-custom-header' ).css( 'height', $( '.archy-site-header' ).outerHeight() );						
					} )( jQuery );
				</script>-->
			</header>
			<?php if ( is_home() ) : 
				do_action( 'archy_slider' );
			endif ?>
			<div id="wrapper" class="wrapper archy-clearfix">