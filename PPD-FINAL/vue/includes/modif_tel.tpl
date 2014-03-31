
<section class="form">
	
	<form  action="index.php?controle=utilisateur&action=enregistrer_modif_tel" method="POST">
		<fieldset>
			<div>
				<label for="telephone_cli">Téléphone :</label>
				<input name ="telephone_cli" id="telephone_cli" type ="text" value="<?php echo $telephone ?>" 
				title="Veuillez entrer votre numéro de téléphone !" placeholder="Entrez numéro" maxlength="10" size="10" tabindex="6" required="required"/>
				<span name="telephoneMauvaisFormat">Le numéro de téléphone doit faire 10 caractères numériques</span>
			</div>
			
		</fieldset>
		<input type="submit" value="Valider" />
		
	</form>
	
	<!--<p id="messageErreur"> <?php echo $msg; ?> </p>-->

</section>