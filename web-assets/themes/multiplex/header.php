<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package multiplex
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'multiplex' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'multiplex' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->

		<div class="mobile_menu">
		<div id="sidebar_menu"><div class="menu_enable" onclick="openNav()"><div class="rev_men_t"><?php _e('Menu ', 'fi-theme')?></div>

	<div class="triangle-menu"><div><span class="icon mx_icon-triangle"></span></div><div><span class="icon mx_icon-triangle"></span></div><div><span class="icon mx_icon-triangle"></span></div></div>

		</div></div>

		<nav id="site-navigation-mobile" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>
		<div class="menuitems">
		<?php
				wp_nav_menu( array(
					'theme_location' => 'mobile-menu',
					'menu_id'        => 'mobile-menu',
				) );
			?></div>
			<div class="widgets_area"><?php dynamic_sidebar('mobile-menu-widgets'); ?></div>
		</nav>

		</div>
		</div>
	</header><!-- #masthead -->
<div id="barba-wrapper">
	<div id="content" class="site-content barba-container">
