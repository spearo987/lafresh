<div class="fond" id="fond_register">
	<div class="container">
		<img src="./img/logo.png"></img>

		<h2>Sign up</h2>

		<form class="signup-form" action="?action=register" method="post" name="register">
			<label for="username">Identifiant*&nbsp;</label>
			<input type="text" id="login" name="username" value="" required><br>
		  	<label for="mail">E-mail*&nbsp;</label>
			<input type="email" id="login" name="mail" value="" required><br>
			<label for="password">Mot de Passe*&nbsp;</label>
			<input type="password" id="password" name="password" value="" required><br>
		 	<label for="verify-password">Vérification Mot de Passe*&nbsp;</label>
			<input type="password" id="verify-password" name="verify_password" value="" required><br>

			<?php if(isset($err_message)) { ?>
			<p><?= $err_message ?></p>
			<?php } ?>

			<div class="center">
				<a href="?action=login_form" class="register">Se connecter</a>
				<input type="submit" value="Inscription">
			</div>
		</form>

	</div>
</div>
