<section class="form">
	<p>Inscrivez-vous d&egrave;s maintenant !</p>
	<form id="form_cli" action="index.php?controle=inscription&action=inscrire"  method="post">
		<fieldset>
			<div class='firstForm'>
				<label for="pseudo_cli">Pseudo :</label>
				<input name="pseudo_cli" id="pseudo_cli" type="text" value="<?php echo $pseudo ?>" 
				title="Veuillez entrer votre pseudo !" placeholder="Entrez votre pseudo" maxlength="20" size="20" tabindex="1" required="required"/><br>
				<span name='pseudoMauvaisFormat'>Le pseudo doit faire au moins 3 caracteres alphanumeriques</span>
				<span name="pseudoUtilise">Le pseudo est déjà utilisé !</span>
			</div>
			<div>
				<label for="mdp_cli">Mot de passe :</label>
				<input name="mdp_cli" id="mdp_cli" type="password" value="<?php echo $password ?>" 
				title="Veuillez entrer votre mot de passe !" placeholder="Entrez mot de passe" maxlength="20" size="20" tabindex="2" required="required"/><br>
				<span name="mdpMauvaisFormat">Le mot de passe doit faire au moins 4 caracteres alphanumériques</span>
			</div>
			<div>
				<label for="nom_cli">Nom :</label>
				<input name="nom_cli" id="nom_cli" type="text" value="<?php echo $nom ?>" 
				title="Veuillez entrer votre nom !" placeholder="Entrez votre nom" maxlength="20" size="20" tabindex="3" required="required"/><br>
				<span name="nomMauvaisFormat">Le nom doit faire au moins 3 caracteres alphabetiques</span>
			</div>
			<div>
				<label for="prenom_cli">Prenom :</label>
				<input name="prenom_cli" id="prenom_cli" type="text" value="<?php echo $prenom ?>" 
				title="Veuillez entrer votre prenom !" placeholder="Entrez votre prenom" maxlength="20" size="20" tabindex="4" required="required"/><br>
				<span name="prenomMauvaisFormat">Le prénom doit faire au moins 3 caractères alphabétiques</span>
			</div>
			<div>
				<label for="email_cli">E-mail :</label>
				<input name ="email_cli" id="email_cli" type ="email" value="<?php echo $email ?>" 
				title="Veuillez entrer votre e-mail !" placeholder="Entrez votre e-mail" maxlength="30" size="30" tabindex="5" required='required'/><br>
				<span name="emailMauvaisFormat">L'e-mail doit faire au moins 6 caractères alphanumeriques et être valide</span>
			</div>
			<div>
				<label for="telephone_cli">Telephone :</label>
				<input name ="telephone_cli" id="telephone_cli" type ="text" value="<?php echo $telephone ?>" 
				title="Veuillez entrer votre numero de telephone !" placeholder="Entrez votre numero" maxlength="10" size="10" tabindex="6" required="required"/><br>
				<span name="telephoneMauvaisFormat">Le numero de telephone doit faire 10 caracteres numeriques</span>
			</div>
			<input type="submit" value="S'inscrire"  title="Cliquez pour vous inscrire !"  tabindex="6"/>
		</fieldset>
	</form>
	<p id="messageErreur"> <?php echo $msg; ?> </p>
</section>