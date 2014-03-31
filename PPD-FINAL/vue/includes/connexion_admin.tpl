
<section class="form">
	<p>Veuillez vous connecter en tant qu'administrateur :</p>
	<form action="index.php?controle=admin&action=connexionAdmin" method="POST">
		<fieldset>
			<div>
				<label for="pseudo">Votre pseudo:</label>
				<input name="pseudo" id="pseudo" type="text" value="<?php echo $pseudo ?>"
				title="Veuillez entrer votre pseudo !" placeholder="Votre pseudo" maxlength="20" size="20" tabindex="1" required/>
				<span name='pseudoMauvaisFormat'>Le pseudo doit faire au moins 3 caractères alphanumériques</span>
				
			</div>
			<div>
				<label for="mdp">Mot de passe :</label>
				<input name="mdp" id="mdp" type="password" value="<?php echo $mdp ?>" 
				title="Veuillez entrer votre mot de passe !" placeholder="Votre mot de passe" maxlength="20" size="20" tabindex="2" required/>
				<span name="mdpMauvais">Le mot de passe est incorrect</span>
				<span name="mdpMauvaisFormat">Le mot de passe doit faire au moins 4 caractères alphanumériques</span>

			</div>
			
		</fieldset>
		<input type="submit" value="Valider" tabindex="6"/>
	</form>

	<p id="messageErreur"> <?php echo $msg; ?> </p>
</section>