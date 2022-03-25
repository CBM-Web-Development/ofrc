<div class="d-flex flex-column flex-shrink-0 bg-light">
	<div class="members-menu">
		<?php if(has_custom_logo()){
	
			$custom_logo_id = get_theme_mod('custom_logo');
			$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
			
			echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="members-menu--logo">';
			
		}else{ ?>
			<h3 class="members-menu--title">Members Menu</h3>   
		<?php } ?>             
		<?php 
		$left_navigation_args = array(
			'menu_class'		=> 'nav nav-pills nav-flush flex-column mb-auto text-center members-nav', 
			'menu_id'			=> '', 
			'container'			=> '', 
			'container_class'	=> '',
			'container_id'		=> '',
			'theme_location'	=> 'member-menu',
			'walker'			=> new bootstrap_5_wp_nav_menu_walker(),
		);
		wp_nav_menu($left_navigation_args);
		?>
	</div>
</div>