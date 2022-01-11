<footer class="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 mx-auto justify-content-center">
				<ul class="footer-sidebar--left">
					<?php dynamic_sidebar( 'left-footer-sidebar' ); ?>
				</ul>
			</div>
			<div class="col-md-4 mx-auto justify-content-center">
				<ul class="footer-sidebar--middle">
					<?php dynamic_sidebar( 'middle-footer-sidebar' ); ?>
				</ul>
			</div>
			<div class="col-md-4 mx-auto justify-content-center">
				<ul class="footer-sidebar--right">
					<?php dynamic_sidebar( 'right-footer-sidebar' ); ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-12 mx-auto">
				<p class="footer-credit">Site developed by <a href="https://www.cbmwebdevelopment.com/" target="blank"> CBM Web Development</a> &copy;<?php echo date('Y'); ?></p>
			</div>
		</div>
	</div>
</footer>
	
<?php wp_footer(); ?>

</body>
</html>