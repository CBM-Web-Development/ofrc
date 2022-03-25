<?php 
/* Template Name: Internal Members Page */
	
get_header();
	
if(!is_user_logged_in()){
	get_template_part( 'template-parts/template', 'member-login' );
}else{ ?>
	<div class="container-fluid g-0">
		<?php if(have_posts()){
			while(have_posts()){
				the_post(); ?>
				<div class="row g-0">
					<div class="col-12">
					<?php if(has_post_thumbnail()){ ?>
						<div class="page-hero" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
						
							<div class="page-hero--title-section">
								<h1 class="page-hero--title"><?php the_title(); ?></h1>
							</div>
						
						</div>
					<?php }else{ ?>
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
					<?php } ?>
					</div>
				</div>
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
								<div class="col-md-10 mx-auto order-sm-1 order-md-2 order-1">
									<?php the_content(); ?>
								</div>
							</div>
					</div>
				</div>
				
			<?php	
			} // end while
		} // end if
		?>
	</div>

<?php }

get_footer(); 
?>