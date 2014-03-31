
<section class="form">
	
	<form action="index.php?controle=partenaire&action=connexionPart" method="POST">
		<fieldset>
			<div>
				<label for="nompart">Votre nom :</label>
				<input name="nompart" id="nompart" type="text" value="<?php echo $nompart ?>"
				title="Votre nom de partenaire" placeholder="Votre nom" maxlength="20" size="20" tabindex="1" required/>
				<span name='pseudoMauvaisFormat'>Le nom de partenaire doit faire au moins 3 caractères alphanumériques</span>
				
			</div>
			<div>
				<label for="mdp">Mot de passe :</label>
				<input name="mdp" id="mdp" type="password" value="<?php echo $mdp ?>" 
				title="Votre mot de passe" placeholder="Votre mot de passe" maxlength="20" size="20" tabindex="2" required/>
				<span name="mdpMauvais">Le mot de passe est incorrect</span>
				<span name="mdpMauvaisFormat">Le mot de passe doit faire au moins 4 caractères alphanumériques</span>

			</div>
			
		</fieldset>
		<input type="submit" value="Envoyer" tabindex="6"/>
	</form>

	<p id="messageErreur"> <?php echo $msg; ?> </p>

</section>