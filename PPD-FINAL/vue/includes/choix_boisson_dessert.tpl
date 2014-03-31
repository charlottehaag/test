<section class='choix_dessert_boisson'>

<h1>Choix de la boisson et du dessert du menu</h1>
<div class="bloc_choix_dessert_boisson">
	<form action="index.php?controle=commande&action=choisir_boisson_dessert" method="post">
		<p>Choix d'une boisson :</p>
		<table cellspacing="20">
			<tr>
				<?php $indice = 0;
				foreach($liste_boissons as $boisson) { ?>
					<td>
						<img src="<?php echo('commun/image/produit/'. $boisson['libelle_prod']) . '.png'; ?>"/>
						<p><?php echo $boisson['libelle_prod']; ?>
						<?php echo("<input type='radio' name='boisson' value=\"".$boisson['id_produit']."\">");?></p>
					</td>		
			<?php 
			$indice++; 
			if($indice % 3 == 0)
				echo('</tr>');
			} ?>
		</table>		
		
		<p>Choix d'un dessert : </p>
		<table cellspacing="20">
			<tr>
			<?php $indice = 0;
				foreach($liste_desserts as $dessert) { ?>
					<td>
						<img src="<?php echo('commun/image/produit/'. $dessert['libelle_prod']) . '.png'; ?>"/>
						<p><?php echo $dessert['libelle_prod']; ?>
						<?php echo("<input type='radio' name='dessert' value=\"".$dessert['id_produit']."\">");?></p>
					</td>
			<?php 
			$indice++; 
			if($indice % 3 == 0)
				echo('</tr>');
			} ?>
		</table>	

		<label for="quantite">Quantit&eacute; de menus identiques :</label>
		<select name="quantite">
			<?php
			for($i=1;$i<10;++$i){
				echo("<option value=\"".$i."\">".$i."</option>");
			}?>

		</select>

	<input type="submit" value="Valider">
	</form>
	<?php if($msg != null) echo('<p>'.$msg.'</p>'); ?>
</div>
</section>