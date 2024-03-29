<?php
/** 
* The Header for our theme. 
* Displays all of the <head> section and everything up till <div id="main"> 
* @package WordPress 
* @subpackage dgc-theme 
* @since dgc-theme 1.0 
**/
?><!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php dgc_get_favicon(); ?>
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script><![endif]-->
<?php wp_head(); ?> 
</head> 
<body <?php body_class();?>>
	<div id="page-header" class="hfeed site">
	<?php
		$theme_options  = dgc_get_theme_options();
		$logo_pos = $menu_pos = '';
		if (isset($theme_options['logo_position'])) 
			$logo_pos = esc_attr($theme_options['logo_position']);
		
		if (isset($theme_options['menu_position'])) 
			$menu_pos = esc_attr($theme_options['menu_position']);
		
		$logo_pos_class = dgc_get_class_pos($logo_pos);
		$menu_pos_class = dgc_get_class_pos($menu_pos);
		
		$responsive_menu_type = esc_attr($theme_options['menu_type_responsive']);
		$is_responsive  	  = (isset($theme_options['responsive']) && ($theme_options['responsive'] == 'on'));
		
		if (isset($theme_options['menu_icon_color'])) 
			$menu_icon_color = $theme_options['menu_icon_color'];

			if ( !$is_responsive || ( $is_responsive && ( $responsive_menu_type == 'inside_content' ) ) ) { ?>			
					<div class="head-container">
						<div class="container">
							<div class="sixteen columns">
								<header id="masthead" class="site-header" role="banner">
									<?php 	
										if (dgc_is_social_header()) { 
											dgc_get_socials_icon(); 
										}	 
									?>
									<div data-originalstyle="<?php echo $logo_pos_class; ?>" class="header-hgroup <?php echo $logo_pos_class; ?>">  
										<?php echo dgc_get_logo(); ?>
									</div>	
										
									<div data-originalstyle="<?php echo $menu_pos_class; ?>" class="menu-wrapper <?php echo $menu_pos_class; ?>">
										<?php dgc_get_wpml_languages_list(); ?>
										<?php dgc_get_qtranslate_languages_list(); ?>
										<?php dgc_get_my_account_html(); ?>
										<?php if (is_user_logged_in()) dgc_get_cart_button_html(); ?>
										<?php //echo $menu_pos_class; ?>
											
										<nav role="navigation" class="site-navigation main-navigation">
											<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
										</nav><!-- .site-navigation .main-navigation -->
									</div>
								</header><!-- #masthead .site-header -->
							</div>
						</div>
					</div>
					
			<?php } else { ?>
				
					<div class="head-container resp_full_width_menu">
						<div class="container ">
							<div class="sixteen columns">
								<header id="masthead" class="site-header" role="banner">
									<?php 	
										if (dgc_is_social_header()) { 
											dgc_get_socials_icon(); 
										}	 
									?>
									<div data-originalstyle="<?php echo $logo_pos_class; ?>" class="header-hgroup <?php echo $logo_pos_class; ?>">  
										<?php echo dgc_get_logo(); ?>
									</div>	
									<div data-originalstyle="<?php echo $menu_pos_class; ?>" class="menu-wrapper <?php echo $menu_pos_class; ?>">
										<?php dgc_get_wpml_languages_list(); ?>
										<?php dgc_get_qtranslate_languages_list(); ?>
										<?php dgc_get_my_account_html(); ?>
										<?php if (is_user_logged_in()) dgc_get_cart_button_html(); ?>
										<?php //echo $menu_pos_class; ?>
											
										<nav role="navigation" class="site-navigation main-navigation">
											<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
										</nav><!-- .site-navigation .main-navigation -->
									</div>
								</header><!-- #masthead .site-header -->
							</div>
						</div>
						<div class="site-header">
							<?php
							if (dgc_is_social_header()) {
								dgc_get_socials_icon();
							}
							?>
							<div class="logo_wrapper"><?php echo dgc_get_logo(); ?></div>
							<div class="menu_button collapsed">
								<button class="navbar-toggle collapsed" type="button">
									<span class="icon-bar" style="background-color: <?php echo $menu_icon_color?>"></span>
									<span class="icon-bar" style="background-color: <?php echo $menu_icon_color?>"></span>
									<span class="icon-bar" style="background-color: <?php echo $menu_icon_color?>"></span>
								</button>
							</div>
							<div class="language_switcher"><?php dgc_get_wpml_languages_list(); ?></div>
							<div class="language_switcher"><?php dgc_get_qtranslate_languages_list(); ?></div>
							<div class="my_account_wrapper"><?php dgc_get_my_account_html(); ?></div>
							<div class="cart_wrapper"><?php if (is_user_logged_in()) dgc_get_cart_button_html(); ?></div>
							<div class="menu_wrapper collapse"><?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?></div>
						</div>
					</div>
					
			<?php } ?>
	</div><!-- .header-container -->
	
	<?php dgc_get_slider(); ?>
	
	<div id="page" class="page-container">		
		<div class="container">		
			<?php do_action( 'before' ); ?>		
				<div class="sixteen columns">