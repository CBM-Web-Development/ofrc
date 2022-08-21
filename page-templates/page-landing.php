<?php 
/* Template Name: Landing Page Template */
get_header('landing');
?>
<div class="container-fluid g-0">
		<?php if(have_posts()){
			while(have_posts()){
				the_post(); ?>
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