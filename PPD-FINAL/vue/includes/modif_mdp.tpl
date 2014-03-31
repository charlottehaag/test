
<section class="form">
	
	<form id="form_modif_mdp"action="index.php?controle=utilisateur&action=enregistrer_modif_mdp" method="POST">
		<fieldset>
			<div>
				<label for="mdp_cli">Mot de passe :</label>
				<input name="mdp_cli" id="mdp_cli" type="password"  
				title="Veuillez entrer votre mot de passe !" placeholder="Entrez mot de passe" maxlength="20" size="20" tabindex="2" required="required"/>
				<span name="mdpMauvaisFormat">Le mot de passe doit faire au moins 4 caractères alphanumériques</span>
			</div>
			
		</fieldset>
		<input type="submit" value="Valider" />
		
	</form>
	
	<p id="messageErreur"> <?php if($msg != null) echo $msg; ?> </p>

</section>