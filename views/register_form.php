<div class="fond" id="fond_register">
<div class="container">
<img src="./img/logo.png"></img>
<form class="signup-form" action="?action=register" method="post" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />

				<label for="nom">Login</label>
				<input type="text" id="login" name="login" required="required" />

				<label for="nom">E-mail</label>
				<input type="email" id="email" name="email" required="required" />

				<label for="p1">Saisir un mot de passe</label>
				<input type="password" id="p1" name="pass1" required="required" />

				<label for="p2">Confirmation du mot de passe</label>
				<input type="password" id="p2" name="pass2" required="required"/>
				<div class="center">
				<input type="submit" value="S'enregistrer" />
			</div>
		</form>
</div>
</div>
