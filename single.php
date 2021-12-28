<?php get_header() ?>

<div class="container-fluid">
	<?php if(have_posts()){
		while(have_posts()){
			the_post(); ?>
			<div class="row content-section">
				<div clsas="col-lg-10 col-md-10 col-sm-12">
					<?php the_content(); ?>
				</div>
			</div>
		<?php }
	} ?>
</div>

<?php get_footer(); ?>