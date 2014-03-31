
<section class="form">
	
	<form id="form_modif_pseudo"action="index.php?controle=utilisateur&action=enregistrer_modif_pseudo" method="POST">
		<fieldset>
			<div>
				<label for="pseudo">Pseudo :</label>
				<input name="pseudo_cli" id="pseudo_cli" type="text" value="<?php echo $pseudo ?>"
				title="Veuillez entrer votre pseudo !" placeholder="Entrez pseudo" maxlength="20" size="20" tabindex="1" required/>
				<span name='pseudoMauvaisFormat'>Le pseudo doit faire au moins 3 caractères alphanumériques</span>
				<span name='pseudoUtilise'>Pseudo déjà utilisé</span>
			</div>
			
		</fieldset>
		<input type="submit" value="Valider" />
		
	</form>
	
	<p id="messageErreur"> <?php if($msg != null) echo $msg; ?> </p>

</section>