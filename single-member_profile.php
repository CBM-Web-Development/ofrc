<?php get_header();?>

<div class="container-fluid">
	<div class="row gy-4">
		<div class="col-md-10 mx-auto justify-content-center">
			<?php if(have_posts()){
				while(have_posts()){
					the_post(); 
					
					$post_id = get_the_ID();
					
					$name = "";
					
					if(get_field('prefix', $post_id)){
						$name .= get_field('prefix', $post_id) . ' ';
					}
					
					$name .= get_field('first_name', $post_id) . ' ' . get_field('last_name', $post_id);
					
					if(get_field('suffix', $post_id)){
						$name .= ', ' . get_field('suffix', $post_id);
					}
					
					?>
					<div class="row">
						<?php if(has_post_thumbnail()){ ?>
						<div class="col-lg-6  col-12 mx-auto">
							<img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php echo $name; ?>" class="profile-image">
						</div>
						<?php } ?>
						
						<div class="col-lg-6 col-12 flex-column mx-auto">
							<h2><?php echo $name; ?></h2>
							<?php 
							if(get_field('mobile_phone', $post_id)){
								$phone_number = get_field('mobile_phone', $post_id);
								echo "<p>Mobile Phone: <a href='tel:" . $phone_number . "'>" . $phone_number . "</a></p>";
							}elseif(get_field('home_phone', $post_id)){
								$phone_number = get_field('home_phone', $post_id);
								echo "<p>Home Phone: <a href='tel:" . $phone_number . "'>" . $phone_number . "</a></p>";
							}elseif(get_field('work_phone', $post_id)){
								$phone_number = get_field('work_phone', $post_id);
								echo "<p>Work Phone: <a href='tel:" . $phone_number . "'>" . $phone_number . "</a></p>";
							}
							?>
							
							<?php if(get_field('email_address', $post_id)){
								echo '<p>Email Address: <a href="mailto:' . get_field('email_address', $post_id) . '">' . get_field('email_address', $post_id) . '</a>';
							}?>
							
							<?php if(get_field('biography', $post_id)){
								echo '<p>' . get_field('biography', $post_id) . '</p>';
							} ?>
							
						</div>
					</div>
				<?php }
			} ?>
		</div>
	</div>
</div>
<?php get_footer(); 