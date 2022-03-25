<div class="container-fluid gy-2 gx-0 member-profile-archives-page">
	
	<?php get_template_part('template-parts/template', 'member-navigation');?>
	
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
	<div class="member-profile-list-section">
		<div class="row has-gutters">
			<div class="col-md-2 mx-auto order-sm-2 order-md-1 order-2 d-flex flex-column align-items-center justify-content-start">
				<div class="members-menu">
					<h3 class="members-menu--title">Members Menu</h3>                
					<?php 
					$left_navigation_args = array(
						'menu_class'		=> 'members-menu--menu', 
						'menu_id'			=> '', 
						'container'			=> '', 
						'container_class'	=> '',
						'container_id'		=> '',
						'theme_location'	=> 'member-menu',
					);
					wp_nav_menu($left_navigation_args);
					?>
				</div>
			</div>
			<div class="col-md-10 col-lg-6 col-12 mx-auto d-flex justify-content-center order-md-2 order-1">
				<div id="member-profile-list">
					<div class="form-floating mb-3">
						<input class="search form-control"  id="directorySearch" type="text" placeholder="Search"/>
						<label for="directorySearch">Search</label>
					</div>
					<i class="fas fa-spinner fa-pulse fa-5x"></i>
					<ul class="list"></ul>
					<ul class="pagination justify-content-center"></ul>
				</div>
			</div>
		</div>
	</div>
</div>