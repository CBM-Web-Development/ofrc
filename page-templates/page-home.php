<?php 
/* Template Name: Homepage Template */
get_header();
?>
<div class="container-fluid g-0">
	<div class="row g-0">
		<?php if(have_posts()){
			while(have_posts()){
				the_post(); ?>
				
				<div class="col-12">
					<?php the_content(); ?>
				</div>
				
			<?php	
			} // end while
		} // end if
		?>
	</div>
</div>

<?php get_footer(); ?>