<section class="form">

	
	<form  id='form_part' action="index.php?controle=partenaire&action=inscription" method="POST">
		<fieldset>
		<div class='firstForm'>
			<label for="nom_part">Nom etablissement :</label>
			<input type="text" name='nom_part' id='nom_part' value="<?php echo $nom_part ?>" placeholder="Nom ..." maxlength="20" required="required"/>
			<span name='nomMauvaisFormat'>Le nom doit faire au moins 3 caractères alphabétiques</span>
			<span name='nomUtilise'>Nom déjà utilisé</span>
		</div>

		<div>
			<label for="password_part">Mot de passe :</label>	
			<input type="password" name="password_part" id='password_part' value="<?php echo $password_part ?>" placeholder="Mot de passe ..." maxlength="20" required="required">
			<span name='mdpMauvaisFormat'>Le mot de passe doit faire au moins 4 caractères alphanumériques</span>
		</div>
		<div>
			<label for="adresse_part">Adresse :</label>
			<input type="text" name="adresse_part" id='adresse_part' value="<?php echo $adresse_part ?>" placeholder="Adresse ..." maxlength="30" required="required">
			<span name='adresseMauvaisFormat'>L'adresse doit faire au moins 5 caractères alphanumériques</span>
		</div>

		<div>
			<label for="code_part">Code postal :</label>
			<input type="text" name="code_part"  id='code_part' value="<?php echo $code_part ?>" placeholder="CP ..." maxlength="5" pattern="[0-9]{5}" required="required">
			<span name='codeMauvaisFormat'>Le code postal doit faire 5 caractères numériques</span>
		</div>

		<div>
			<label for="numero_part">Telephone :</label>
			<input type="text" name="numero_part" id='numero_part' value="<?php echo $numero_part ?>" placeholder="Numéro ..." maxlength="10" pattern="[0-9]{10}" required="required">
			<span name='telephoneMauvaisFormat'>Le numéro de téléphone doit faire 10 caractères numériques</span>
		</div>

		<div>
			<label for="email_part">Email :</label>
			<input type="email" name="email_part" id='email_part' value="<?php echo $email_part ?>" placeholder="Email ..." maxlength="40" pattern="^[\w.-.\.]+@[\w.-]+\.[a-zA-Z]{2,12}$" required="required">
			<span name='emailMauvaisFormat'>L'e-mail doit faire au moins 6 caractères alphanumériques et être valide</span>
		</div>
		<input type="submit" value="Envoyer">
		</fieldset>
	</form>
	<p id="messageErreur"> <?php if($msg != null) echo $msg; ?></p>

</section>