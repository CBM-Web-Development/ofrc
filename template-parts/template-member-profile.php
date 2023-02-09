

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
				<div class="row has-gutters">
					<div class="col-md-10 mx-auto">
						<?php $member_id = get_the_ID(); ?>
						
						<div class="member-profile d-flex flex-lg-row flex-column justify-content-center align-items-center">
							<div class="member-profile--image d-flex align-items-center" style="background-image:url(<?php echo get_field('profile_picture', $member_id)['url'];?>)">
							</div>
							<div class="member-profile--info d-flex justify-content-start align-items-center flex-column">
								<h2><?php the_field('first_name', $member_id); ?> <?php the_field('last_name', $member_id); ?></h2>
								<p><label>Cell Phone: </label> <a href="tel:<?php echo get_field('cell_phone', $member_id);?>"><?php the_field('cell_phone', $member_id); ?></a></p>
								<p><label>Home Phone: </label> <a href="tel:<?php echo get_field('home_phone', $member_id);?>"><?php the_field('home_phone', $member_id); ?></a></p>
								<p><label>Work Phone: </label> <a href="tel:<?php echo get_field('work_phone', $member_id);?>"><?php the_field('work_phone', $member_id); ?></a></p>
								<p><label>Email Address: </label> <a href="mailto:<?php echo get_field('email_address', $member_id);?>"><?php the_field('email_address', $member_id); ?></a></p>
								<p><label>Birthday: </label><?php the_field('birthday', $member_id); ?></p>
								
							</div>
						</div>
												
						
						
					</div>
				</div>
			<?php }
		}
	?>
	
	
</div>