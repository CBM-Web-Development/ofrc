
<?php $member_id = $args['member_id']; ?>

<div class="d-flex flex-column flex-sm-row flex-shrink-0 bg-light">
	<div class="members-menu">
		<div class="members-menu--header d-none d-md-block">
			<?php if(get_field('member_menu_logo', 'option')){
			
				$logo = get_field('member_menu_logo', 'option');
								
				echo '<img src="' . esc_url($logo['url']) . '" alt="Member Menu Logo" class="members-menu--logo">';
				
			}else{ ?>
				<h3 class="members-menu--title"><?php the_field('member_menu_title', 'option');?></h3>   
			<?php } ?>   
		</div>          
		<?php 
		$walker = new bootstrap_5_wp_nav_menu_sidebar_walker();
		$left_navigation_args = array(
			'menu_class'		=> 'nav nav-pills nav-flush flex-md-column flex-row justify-content-center align-items-center align-items-md-stretch mb-auto text-left members-nav', 
			'menu_id'			=> '', 
			'container'			=> '', 
			'container_class'	=> '',
			'container_id'		=> '',
			'theme_location'	=> 'member-menu',
			'walker'			=> $walker,
		);
		
		wp_nav_menu($left_navigation_args);

		?>
		
		<?php if(get_field('is_board_member', $member_id) || current_user_can('administrator')) { ?>
			
			<hr/>
			<?php 
			$board_member_navigation_args = array(
				'menu_class'		=> 'nav nav-pills nav-flush flex-md-column flex-row justify-content-center align-items-center align-items-md-stretch mb-auto text-left members-nav', 
				'menu_id'			=> '', 
				'container'			=> '', 
				'container_class'	=> '',
				'container_id'		=> '',
				'theme_location'	=> 'board-member-navigation',
				'walker'			=> $walker,
			);
			if(has_nav_menu( 'board-member-navigation' )){
				wp_nav_menu($board_member_navigation_args);
			}

			?>
		<?php }?>
		
	</div>
</div>