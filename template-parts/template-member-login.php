<?php get_header(); ?>


<?php

global $wp;
$redirect_to = home_url(add_query_arg(array(), $wp->request));

?>


<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-sm-12 mx-auto">
			<h2>Log In</h2>
			<form action="<?php echo site_url('/wp-login.php');?>" method="post">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="log">
					<label for="floatingInput">Username</label>
				</div>
				<div class="form-floating">
					<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd">
					<label for="floatingPassword">Password</label>
				</div>
				<p><input id="rememberme" type="checkbox" value="forever" name="rememberme"> Remember Me</p>

				<button type="submit" class="btn btn-outline-secondary">Sign In</button>
				<input type="hidden" value="<?php echo esc_attr( $redirect_to ); ?>" name="redirect_to">
				<input type="hidden" value="1" name="testcookie">
			</form>
		</div>
	</div>
</div>

<?php get_footer(); 