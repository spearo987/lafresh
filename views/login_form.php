<?php if(isset($register_message)) { ?>
<div><?= $register_message ?></div>
<?php } ?>


<div class="fond" id="fond_login">
	<?php if(isset($err_message)) { ?>
	<p><?= $err_message ?></p>
	<?php } ?>
	<div class="container">
		<img src="./img/logo.png"></img>

		<form class="signup-form" action="?action=login" method="post" name="login">
			<!-- Username input -->
			<label for="username">Login&nbsp;</label>
			<?php if(isset($username)) { ?>
				<!-- Username input after registration -->
				<input type="text" id="login" name="username" value="<?= $username ?>" required>
			<?php }
			else {
			?>
				<!-- Normal username input -->
				<input type="text" id="login" name="username" value="" required>
			<?php } ?>

			<!-- Password input -->
			<label for="password">Password&nbsp;</label>
			<?php if(isset($password)) { ?>
				<!-- Password input after registration -->
				<input type="password" id="password" name="password" value="<?= $password ?>" required>
			<?php }
			else {
			?>
				<!-- Normal password input -->
				<input type="password" id="password" name="password" value="" required>
			<?php } ?>
			<div class="center">
				<a href="?action=register_form" class="register">Sign Up</a>
				<input type="submit" value="Login">
				<div id="checkbox">
					<input type="checkbox" id="remember">
					<label for="remember">Remember me</label>
				</div>
				<a href="?action=register_form" id="s">Lost Password</a>
			</div>
		</form>
	</div>
</div>
