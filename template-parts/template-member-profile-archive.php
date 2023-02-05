<?php 
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
?>
<div class="member-internal d-flex flex-md-row flex-column">
	<?php get_template_part('template-parts/template', 'member-navigation', array('member_id'=> $member_id));?>
	<div class="container-fluid gy-2 gx-0 member-profile-archives-page">
		<div class="container-fluid">
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
			<div class="member-profile-list-section">
				<div class="row has-gutters">
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
	</div>
</div>