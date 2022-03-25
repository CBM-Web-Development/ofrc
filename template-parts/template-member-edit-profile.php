<?php 

$user_id = get_current_user_id(); 


$prefix = get_field('prefix', 'user_' . $user_id);
$first_name = get_field('first_name', 'user_' . $user_id);
$last_name = get_field('last_name', 'user_' . $user_id);
$suffix = get_field('suffix', 'user_' . $user_id);
$birthday = get_field('birthday', 'user_' . $user_id);
$gender = get_field('gender', 'user_' . $user_id);
$mobile_phone = get_field('mobile_phone', 'user_' . $user_id);
$home_phone = get_field('home_phone', 'user_' . $user_id);
$work_phone = get_field('work_phone', 'user_' . $user_id);
$email_address = get_field('email_address', 'user_' . $user_id);
$biography = get_field('biography', 'user_' . $user_id);
$profile_image = get_field('profile_picture', 'user_' . $user_id);

?>

<div class="member-internal d-flex flex-md-row flex-column">
	<?php get_template_part('template-parts/template', 'member-navigation');?>
	
	<div class="container-fluid gy-2 gx-0">
			
		<div class="row gx-0">
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
				<div class="col-md-10 mx-auto order-sm-1 order-md-2 order-1">
					<div class="row">
						<div class="col order-lg-2 order-sm-1 gy-3">
							<form class="member-profile" name="member-profile-form" action="" onsubmit="return update_member_profile();">
								<div class="row">
									<div class="col-md-3">
										<div class="form-floating mb-3">
											<select name="prefix" id="prefixSelect" placeholder="Prefix" class="form-control">								
												<option ></option>
												<option value="Mr." <?php echo $prefix == 'Mr.' ? 'selected' : '' ?>>Mr.</option>
												<option value="Mrs." <?php echo $prefix == 'Mrs.' ? 'selected' : '' ?>>Mrs.</option>
												<option value="Ms." <?php echo $prefix == 'Ms.' ? 'selected' : '' ?>>Ms.</option>
												<option value="Dr." <?php echo $prefix == 'Dr.' ? 'selected' : '' ?>>Dr.</option>
											</select>
											<label for="prefixSelect">Prefix</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-floating mb-3">
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
									<div class="col col-md-3 gy-3 gy-sm-0">
										<div class="form-floating mb-3">
											<select name="suffix" id="suffixSelect" placeholder="Prefix" class="form-control">
												<option></option>
												<option value="Jr."<?php echo $suffix  == 'Jr.' ? ' selected' : '' ?>>Jr.</option>
												<option value="M.D."<?php echo $suffix  == 'M.D.' ? ' selected' : '' ?>>M.D.</option>
												<option value="PhD."<?php echo $suffix  == 'PhD.' ? ' selected' : '' ?>>PhD.</option>
												<option value="II"<?php echo $suffix  == 'II.' ? ' selected' : '' ?>>II</option>
												<option value="III"<?php echo $suffix  == 'III.' ? ' selected' : '' ?>>III</option>
												<option value="IV" <?php echo $suffix == 'IV.' ? ' selected' : '' ?>>IV</option>
											</select>
											<label for="suffixSelect">Suffix</label>
										</div>
									</div>
								</div>
								<div class="row">
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
												<option value="Male"<?php echo $gender == 'Male' ? ' selected': '';?>>Male</option>
												<option value="Female"<?php echo $gender == 'Female' ? ' selected' : '';?>>Female.</option>
											</select>
											<label for="genderInput">Gender</label>
										</div>
									</div>
								</div>
								<div class="row">
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
								<div class="row">
									<div class="col gy-3">
										<div class="form-floating">
											<input type="email" class="form-control" id="emailInput" placeholder="me@example.com" name="email" value="<?php echo $email_address; ?>">
											<label for="emailInput">Email Address</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col gy-3">								
										<label for="biographyTextarea">Biography</label>
										<textarea class="form-control" id="biographyTextarea" name="biography" rows="5"><?php echo $biography;?></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-12 d-grid gy-3">
										<button type="submit" class="btn btn-outline-primary">Save</button>
									</div>
								</div>
							</form>
							<div class="row gy-1">
								<div class="col-12 d-grid gy-3">
									<button type="button" class="btn btn-outline-danger signoutButton">Sign Out</button>
								</div>
							</div>
						</div>
						<div class="col order-lg-1 order-sm-2 gy-3">
							<div class="profile-picture-section d-flex justify-content-center flex-column align-items-center">
								<div class="profile-picture-form-display d-flex align-items-center justify-content-center">
									<?php if($profile_image){ ?>
										<img class="profile-picture-form-display--img" src="<?php echo $profile_image['url'];?>" alt="Profile Picture"/>
									<?php }else{ ?>
										<i class="fas fa-file-upload"></i>	
									<?php } ?>
									
								</div>
								<form name="profile-picture-form">
									<input type="file" accept="image/*" name="profile_picture" class="form-control profile-picture-input">
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
</div>	
