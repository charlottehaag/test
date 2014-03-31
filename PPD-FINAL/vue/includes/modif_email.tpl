
<section class="form">
	
	<form id="form_modif_email" action="index.php?controle=utilisateur&action=enregistrer_modif_email"method="POST">
		<fieldset>
			<div>
				<label for="email_cli">E-mail :</label>
				<input name ="email_cli" id="email_cli" type ="email" value="<?php echo $email ?>" 
				title="Veuillez entrer votre e-mail !" placeholder="Entrez e-mail" maxlength="30" size="30" tabindex="5" required='required'/>
				<span name="emailMauvaisFormat">L'e-mail doit faire au moins 6 caractères alphanumériques et être valide</span>
			</div>
			
		</fieldset>
		<input type="submit" value="Valider" />
		
	</form>
	
	<p id="messageErreur"> <?php if($msg != null) echo $msg; ?> </p>

</section>