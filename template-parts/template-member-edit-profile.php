<?php
$member_profiles = new OFRC_Member_Profiles();
$user_id = get_current_user_id();
$membership_id = get_user_meta( $user_id, 'membership_id', true );
$post_id = $member_profiles->get_member($membership_id)->ID;

$prefix = get_field("member_profile_prefix", $post_id);
$first_name = get_field("member_profile_first_name", $post_id);
$last_name = get_field("member_profile_last_name", $post_id);
$suffix = get_field("member_profile_suffix", $post_id);
$birthday = get_field("member_profile_birthday", $post_id);
$gender = get_field("member_profile_gender", $post_id);
$mobile_phone = get_field("member_profile_mobile_phone", $post_id);
$home_phone = get_field("member_profile_home_phone", $post_id);
$work_phone = get_field("member_profile_work_phone", $post_id);
$email_address = get_field("member_profile_email_address", $post_id);
$biography = get_field("member_profile_biography", $post_id);
$profile_image = get_field("profile_picture", 'user_' . $user_id);
?>

<div class="member-internal d-flex flex-md-row flex-column">
	<?php get_template_part("template-parts/template", "member-navigation"); ?>
	
	<div class="container-fluid gy-2 gx-0">
		

		<div class="row has-gutters">
			<div class="col-12 mx-auto order-sm-1 order-md-2 order-1">
				<div class="row">
					<div class="col order-lg-2 order-sm-1 gy-3">
						<form class="member-profile" name="member-profile-form" action="" onsubmit="return update_member_profile();" enctype="multipart/form-data">
							<div class="row">
								<div class="col">
									<h4 class="text-center">Authorized Users</h4>
								</div>
							</div>
							<div class="row">
								<div class="col" id="member-group-section"></div>
							</div>
							<div class="row mb-3">
								<div class="col-md-6 mx-auto d-grid gy-3">
									<button type="submit" class="btn btn-outline-primary">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto toast-header--text">Profile Updated</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">
					Profile saved
				</div>
			</div>
		</div>
	</div>
</div>	
