<?php get_header();
$category = get_the_category()[0];
$cat_id = $category->cat_ID;
$cat_name = $category->name;

 ?>


<div class="container-fluid gy-2 gx-0 archives-page">
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
				<h1 class="page-title"><?php echo $cat_name; ?></h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center cards-section" data-archive = "<?php echo get_the_category()[0]->cat_ID; ?>" data-page="1"></div>
		</div>
	</div>
	<div class="row gy-4 ">
		<div class="col-md-10 mx-auto">
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
				</ul>
			</nav>
		</div>
	</div>
</div>

<?php get_footer(); ?>