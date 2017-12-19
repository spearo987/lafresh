<?php if(isset($register_message)) { ?>
<div><?= $register_message ?></div>
<?php } ?>


<div class="fond" id="fond_login">

	<div class="container">
		<img src="./img/logo.png"></img>

		<form class="signup-form" action="?action=login" method="post" name="login">
			<!-- Username input -->
			<label for="username">Identifiant&nbsp;</label>
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
			<label for="password">Mot de Passe&nbsp;</label>
			<?php if(isset($password)) { ?>
				<!-- Password input after registration -->
				<input type="password" id="password" name="password" value="<?= $password ?>" required>
			<?php }
			else {
			?>
				<!-- Normal password input -->
				<input type="password" id="password" name="password" value="" required>
			<?php } ?>

			<?php if(isset($err_message)) { ?>
			<p><?= $err_message ?></p>
			<?php } ?>

			<div class="center">
				<input type="submit" value="Se connecter">
				<a href="?action=register_form" class="register">Inscription</a>
				<div id="checkbox">
			</div>
		</form>
	</div>
</div>
