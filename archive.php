<?php get_header() ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-10">
		<?php if(have_posts()){ ?>
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
				<?php while(have_posts()){
					the_post(); ?>
					<div class="col d-flex align-items-stretch">
						<div class="card">
							
							<?php if(has_post_thumbnail()){ ?>
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php echo get_the_title(); ?>">
							
							<?php } ?>
							
							<div class="card-body">
								
							  <h5 class="card-title"><?php the_title(); ?></h5>					  <p class="card-text"><small class="text-muted"><?php the_date(); ?></small></p>
							  <p class="card-text"><?php  the_excerpt(); ?></p>

							</div>
							<div class="card-footer">												  
								  <a class="btn btn-outline-dark" href="<?php the_permalink();?>">Read More</a>
							</div>
						</div>	
					</div>	
				<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>