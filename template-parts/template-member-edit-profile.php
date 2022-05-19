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
							<div class="row">									<!-- Profile Picture Section -->
								<div class="col-md-6">	
									<div class="profile-picture-section d-flex justify-content-center flex-column align-items-center">
										<div class="profile-picture-form-display d-flex align-items-center justify-content-center">
											<?php if ($profile_image) { ?>
												<img class="profile-picture-form-display--img" src="<?php echo $profile_image["url"]; ?>" alt="Profile Picture"/>
											<?php } else { ?>
												<i class="fas fa-file-upload"></i>	
											<?php } ?>	
											
											<div class="profile-picture-mask">
												<h2>Click to upload</h2>
											</div>
										</div>
										<form name="profile-picture-form">
											<input type="file" accept="image/*" name="profile_picture" class="form-control profile-picture-input">
										</form>
									</div>
								</div>
								<div class="col-md-6 ">
									<div class="row mb-3">
										<div class="col">
											<h3>Primary Member</h3>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-md-3">
											<div class="form-floating">
												<select name="prefix" id="prefixSelect" placeholder="Prefix" class="form-control">				
													<option ></option>
													<option value="Mr." <?php echo $prefix == "Mr." ? "selected": ""; ?>>Mr.</option>
													<option value="Mrs." <?php echo $prefix == "Mrs." ? "selected" : ""; ?>>Mrs.</option>
													<option value="Ms." <?php echo $prefix == "Ms." ? "selected" : ""; ?>>Ms.</option>
													<option value="Dr." <?php echo $prefix == "Dr." ? "selected" : ""; ?>>Dr.</option>
												</select>
												<label for="prefixSelect">Prefix</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-floating">
												<input type="text" class="form-control" id="firstNameInput" placeholder="First Name" name="first_name" value="<?php echo $first_name; ?>">
												<label for="firstNameInput">First Name</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-floating">
												<input type="text" class="form-control" id="lastNameInput" placeholder="Last name" value="<?php echo $last_name; ?>" name="last_name">
												<label for="lastNameInput">Last Name</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-floating">
												<select name="suffix" id="suffixSelect" placeholder="Prefix" class="form-control">
													<option></option>
													<option value="Jr."<?php echo $suffix == "Jr." ? " selected" : ""; ?>>Jr.</option>
													<option value="M.D."<?php echo $suffix == "M.D." ? " selected" : ""; ?>>M.D.</option>
													<option value="PhD."<?php echo $suffix == "PhD." ? " selected" : ""; ?>>PhD.</option>
													<option value="II"<?php echo $suffix == "II." ? " selected" : ""; ?>>II</option>
													<option value="III"<?php echo $suffix == "III." ? " selected" : ""; ?>>III</option>
													<option value="IV" <?php echo $suffix == "IV." ? " selected" : ""; ?>>IV</option>
												</select>
												<label for="suffixSelect">Suffix</label>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<div class="form-floating mb-3">
												<input type="date" class="form-control" id="birthdayInput" placeholder="01/01/1976" name="birthday" value="<?php echo $birthday; ?>">
												<label for="birthdayInput">Birthday</label>
											</div>
										</div>
										<div class="col">
											<div class="form-floating">
												<select name="gender" id="suffixSelect" placeholder="Gender" class="form-control">
													<option></option>
													<option value="Male"<?php echo $gender == "Male"
             	? " selected"
             	: ""; ?>>Male</option>
													<option value="Female"<?php echo $gender == "Female"
             	? " selected"
             	: ""; ?>>Female.</option>
												</select>
												<label for="genderInput">Gender</label>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<div class="form-floating">
												<input type="tel" class="form-control" id="mobilePhoneInput" placeholder="Mobile Phone" name="mobile_phone" value="<?php echo $mobile_phone; ?>">
												<label for="Mobile Phone">Mobile Phone</label>
											</div>
										</div>
										<div class="col">
											<div class="form-floating">
												<input type="tel" class="form-control" id="homePhoneInput" placeholder="Home Phone" name="home_phone" value="<?php echo $home_phone; ?>">
												<label for="Home Phone">Home Phone</label>
											</div>
										</div>
										<div class="col">
											<div class="form-floating">
												<input type="tel" class="form-control" id="workPhoneInput" placeholder="Work Phone" name="work_phone" value="<?php echo $work_phone; ?>">
												<label for="workPhoneInput">Work Phone</label>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<div class="form-floating">
												<input type="email" class="form-control" id="emailInput" placeholder="me@example.com" name="email" value="<?php echo $email_address; ?>">
												<label for="emailInput">Email Address</label>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<div class="form-floating">
												<textarea class="form-control" id="biographyTextArea" name="biography" style="height:300px"><?php echo $biography; ?></textarea>
												<label for="biographyTextArea">Biography</label>
											</div>
										</div>
									</div>								
								</div>
								<div class="row">
									<div class="col">
										<h4 class="text-center">Authorized Users</h4>
									</div>
								</div>
								<div class="row">
									<div class="col" id="member-group-section"></div>
								</div>
								<div class="row">
									<div class="col-md-6 mx-auto d-grid gy-3">
										<button type="submit" class="btn btn-outline-primary">Save</button>
									</div>
								</div>
							</form>
						</div>
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
