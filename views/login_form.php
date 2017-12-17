<div class="fond" id="fond_login">
<div class="container">
			<img src="./img/logo.png"></img>
<form class="signin-form" action="?action=login" method="post" name="login">
	<label for="username">Identifiant&nbsp;</label>
	<input type="text" id="login" name="username" value="" required="required"/>

	<label for="password">Mot de Passe&nbsp;</label>
	<input type="password" id="password" name="password" value="" required="required"/>
<div class="center">
	<a href="?action=register_form" value="Register" class="register">Créer un compte</a>
	<input type="submit" value="Se connecter" />

<div id="checkbox">
	<input type="checkbox" id="remember" >
	<label for="remember">Se souvenir de moi</label>
</div>

	<a href="signup.php" id="s">Mot de passe oublié ?</a>
</div>
</form>
</div>
</div>
