<?php
global $wp;

$redirect_to = home_url(add_query_arg(array(), $wp->request));

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-sm-12 mx-auto">
			<h2>Log In</h2>
			<div class="alert alert-danger d-none login-alert" role="alert">
				The username & password combination are not in our system. Please try again. 
			</div>
			<form action="" method="post" class="member-login--form">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="user_login" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">
					<label for="floatingInput">Username</label>
				</div>
				<div class="form-floating">
					<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="user_password">
					<label for="floatingPassword">Password</label>
				</div>
				<p><input id="rememberme" type="checkbox" value="forever" name="rememberme"> Remember Me</p>

				<button type="submit" class="btn btn-outline-secondary">Sign In</button>
			</form>
		</div>
	</div>
</div>
