<section class='choix_ingredients'>

<h1>Choisissez les 3 ingr&eacute;dients de votre sandwich :</h1>

	<p>Test liste boissons et desserts : </p>
	
	<div class="bloc_choix_ingredients">
	
		<form id='form_choix_ingr' action="index.php?controle=commande&action=choisir_ingredients" method="post">

		<table cellspacing="20">
			<tr>
		<?php $indice = 0;
		foreach($liste_ingredients as $ingredient) { ?>
			<td>
				<img src="<?php echo('commun/image/ingredient/'. $ingredient['libelle_ingr']) . '.png'; ?>"/>
				<p><?php echo $ingredient['libelle_ingr']; ?>
				<?php echo("<input class='ingredient' type='checkbox' name='ingredient[]' value=\"".$ingredient['id_ingredient']."\">");?></p>
			</td>
			
		<?php 
		$indice++; 
		if($indice % 3 == 0)
			echo('</tr>');
		} ?>
		</table>
		<?php 
		//si on n'a pas déjà choisi la quantité dans la page de menu
		if(!isset($_SESSION['quantite_menu'])){ ?>
			<label>Quantit&eacute; :</label>
			<select name="quantite">
				<?php
					for($i=1;$i<10;++$i){
						echo("<option value=\"".$i."\">".$i."</option>");
				}?>
			</select>
		<?php } ?>
		
	<input type="submit" value="Valider">

	</form>
	<p> Vous devez choisir 3 ingrédients ! </p>
</div>
</section>