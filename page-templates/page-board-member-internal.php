<?php 
/* Template Name: Internal Board Member Page */
	
get_header();

$member_id_args = array(
	'post_type' 	=> 'member', 
	'status'	=> 'publish', 
	'meta_key'		=> 'user_id', 
	'meta_value'	=> get_current_user_id()
);

$member = get_posts($member_id_args);
$member_id = null;
if($member){
	
	$member_id = $member[0]->ID;
	
}

if(is_user_logged_in() && (get_field('is_board_member', $member_id) || current_user_can('administrator')) ){ ?>
	<div class="member-internal d-flex flex-md-row flex-column">
		<?php get_template_part('template-parts/template', 'member-navigation', array('member_id' => $member_id));?>
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
										<div class="col-12 mx-auto">
											<?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
										</div>
									</div>
								<?php } ?>
								<div class="row has-gutters">
									<div class="col-12 mx-auto">
										<h1 class="page-title"><?php the_title(); ?></h1>
									</div>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
					<div class="row gy-5 has-gutters">
						<div class="col-12 mx-auto">
							<?php the_content(); ?>
						</div>
					</div>
					
				<?php	
				} // end while
			} // end if
			?>
		</div>
	</div>
<?php }else{ ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center red-text">Naughty naughty!</h2>
				<p class=" text-center fs-3">It looks like you tried to access something you shouldn't!</p>
			</div>
		</div>
	</div>
<?php } 


get_footer(); 
?>