<?php get_header(); ?>

<div class="container-fluid">
	<?php if(function_exists('yoast_breadcrumb')){ ?>
		<div class="row">
			<div class="col-md-8 mx-auto">
				<?php yoast_breadcrumb('<p id="breadcrumbs" class="breadcumbs"', '</p>'); ?>
			</div>
		</div>
	<?php } ?>
	<div class="row woocommerce">
		<div class="col-md-2 mx-auto d-flex justify-content-center order-md-1 order-3">
			<ul class="left-shop-sidebar--list">
				<?php dynamic_sidebar( 'left-shop-sidebar' ); ?>
			</ul>
		</div>
		<div class="col-md-8 mx-auto order-md-2 order-1">
			<?php woocommerce_content(); ?>
		</div>
		<div class="col-md-2 mx-auto d-flex justify-content-center order-md-3 order-2">
			<ul class="right-shop-sidebar--list">
				<?php dynamic_sidebar( 'right-shop-sidebar' ); ?>
			</ul>
		</div>
	</div>
</div>


<?php get_footer();