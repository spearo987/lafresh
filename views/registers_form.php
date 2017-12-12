<h1>Lafresh</h1>

<h2>Inscription</h2>

<form class="signup-form" action="?action=register" method="post" enctype="multipart/form-data">
				<legend>Formulaire d'inscription</legend>
				<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
				<label for="nom">Login : </label>
				<input type="text" id="login" name="login" required="required" placeholder="votre login" /><br />
				<label for="p1">Saisir un mot de passe : </label>
				<input type="password" id="p1" name="pass1" required="required" placeholder="mot de passe" /><br />
				<label for="p2">Confirmation du mot de passe : </label>
				<input type="password" id="p2" name="pass2" required="required" placeholder="confirmation" /><br />
				<input type="submit" value="Et hop !" />
		</form>
