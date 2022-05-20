<div class="container-fluid g-0">
	
	<?php 
		if(have_posts()){
			while(have_posts()){ the_post(); ?>
				<div class="page-hero--no-image">
					<?php if(function_exists('yoast_breadcrumb')){ ?>
						<div class="row has-gutters">
							<div class="col-md-10 mx-auto">
								<?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
							</div>
						</div>
					<?php } ?>
					<div class="row has-gutters">
						<div class="col-md-10 col-12 mx-auto">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 mx-auto">
						<?php 
							$members = array();
							
							$member_group = get_field('member_group_authorized_users');
							
							if($member_group){
								foreach($member_group as $member){
									if($member['show_in_directory']){
										$members[] = array(
											'name'	=> implode(' ', array(
												$member['prefix'], 
												$member['first_name'], 
												$member['last_name'],
												$member['suffix']
											) ),
											'profile_picture'	=> $member['profile_picture'] ? $member['profile_picture']['url'] : OFRC_URI . '/assets/static/img/profile_placeholder.png',
										);
									}
								}
							}
							
						?>
						
						
						
					</div>
				</div>
			<?php }
		}
	?>
	
	
</div>