

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
				<div class="row">
					<div class="col-md-10 mx-auto">
						<?php 
							
						?>
						
						
						
					</div>
				</div>
			<?php }
		}
	?>
	
	
</div>