<?php 
/* Template Name: Full Width Template */
get_header();
?>
<div class="container-fluid g-0">
		<?php if(have_posts()){
			while(have_posts()){
				the_post(); ?>
				<div class="row g-0">
					<div class="col-12">
					<?php if(has_post_thumbnail()){ ?>
						<div class="page-hero" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
						
							<div class="page-hero--title-section">
								<h1 class="page-hero--title"><?php the_title(); ?></h1>
							</div>
						
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="row g-0">
					<div class="col-12">
						<?php the_content(); ?>
					</div>
				</div>
				
			<?php	
			} // end while
		} // end if
		?>
</div>

<?php get_footer(); ?>