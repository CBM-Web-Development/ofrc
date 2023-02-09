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
	<?php get_template_part("template-parts/template", "member-navigation", array('member_id' => $member_id)); ?>
	
	<div class="container-fluid gy-2 gx-0">
		

		<div class="row has-gutters">
			<div class="col-12 mx-auto order-sm-1 order-md-2 order-1">
				<div class="row">
					<div class="col order-lg-2 order-sm-1 gy-3">
						<div class="row">
							<div class="col-md-10 mx-auto member-profile-section" id="member-profile-section"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
