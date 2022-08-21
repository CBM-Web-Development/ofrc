<!DOCTYPE html>
<html lang="en">
	<head>
		<?php get_template_part('partials/head', 'meta'); ?>
		
		<?php get_template_part('partials/head', 'tags'); ?>
		
		
		<title><?php wp_title('|', true, 'right'); echo get_bloginfo('title');  ?></title>
		
		<?php wp_head(); ?>
	</head>
	<body>
		<nav class="navbar navbar-dark bg-dark secondary-navbar">
			<div class="container-fluid justify-content-lg-end justify-content-center">
				<div class="navbar-nav">
					<ul class="secondary-navigation-list--right">
						<?php dynamic_sidebar( 'secondary-navigation--right' );?>
					</ul>
				</div>
			</div>

		</nav>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark primary-navbar">

			<div class="container-fluid">
				<!--Brand-->
				<a class="navbar-brand" href="<?php echo get_bloginfo('url'); ?>">
					<?php if(has_custom_logo()){
						
						$custom_logo_id = get_theme_mod('custom_logo');
						$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
						
						echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
						
					}else{ ?>
						<h1><?php echo get_bloginfo('name'); ?></h1>
					<?php } ?>
					
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
				</button>
			
				<!--Left navigation -->			
				<?php 
				
			    $primary_navigation_args = array(
					'menu_class'		=> 'navbar-nav', 
					'menu_id'			=> '', 
					'container'			=> 'div', 
					'container_class'	=> 'collapse navbar-collapse',
					'container_id'		=> 'navbarSupportedContent',
					'theme_location'	=> 'primary-navigation',
					'walker'			=> new bootstrap_5_wp_nav_menu_walker(), 
				);
				wp_nav_menu($primary_navigation_args);
				
				?>
				
			</div>		
			
		</nav>
		
		<?php if(get_field( 'notification_banner_activate', 'options' )){?>
			
			<div class="notification-banner notification-banner--<?php echo get_field('notification_banner_status', 'options'); ?>">
				<?php echo get_field('notification_banner_message', 'options'); ?>
			</div>
			
		<?php } ?>
		