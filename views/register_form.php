<div class="fond" id="fond_register">
	<div class="container">
		<img src="./img/logo.png"></img>

		<h2>Sign up</h2>

		<form class="signup-form" action="?action=register" method="post" name="register">
			<label for="username">Username&nbsp;</label>
			<input type="text" id="login" name="username" value="" required><br>
		  	<label for="mail">Mail adress&nbsp;</label>
			<input type="text" id="login" name="mail" value="" required><br>
			<label for="password">Password&nbsp;</label>
			<input type="password" id="password" name="password" value="" required><br>
		 	<label for="verify-password">Verify password&nbsp;</label>
			<input type="password" id="password" name="verify_password" value="" required><br>
			<div class="center">
				<p><a href="?action=login_form">Login</a></p>
				<input type="submit" value="Sign Up">
			</div>
		</form>
