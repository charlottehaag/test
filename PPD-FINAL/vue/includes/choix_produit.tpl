<section class='choix_produit'>
	<p>Veuillez s&eacute;lectionner le produit d&eacute;sir&eacute; :</p>
	<form action="index.php?controle=commande&action=choisir_produit" method="post">
	<div class="bloc_choix_produit">
		<table cellspacing="20">
			<tr>
			<?php $indice = 0;
			foreach($liste_produits as $produit) { ?>
				<td>
					<img src="<?php echo('commun/image/produit/'. $produit['libelle_prod']) . '.png'; ?>"/>
					<p><?php echo $produit['libelle_prod']; ?>
					<?php	echo("<input type='radio' name='choix_produit' value=\"".$produit['id_produit']."\">");?></p>
					<li><a href="index.php?controle=evaluation&action=aff_commentaires_produit&id_produit=<?php echo $produit['id_produit']?>">Voir commentaires</a></li>
					<li><a href="index.php?controle=evaluation&action=commenter_produit&id_produit=<?php echo $produit['id_produit']?>">Commenter</a></li>
					<li><a href="index.php?controle=evaluation&action=voter_produit&id_produit=<?php echo $produit['id_produit']?>">Voter</a></li>
         
					<p> Note: <?php echo $produit['note_produit']?> </p>
				</td>
			
		<?php 
		$indice++; 
		if($indice % 3 == 0)
			echo('</tr>');
		} ?>
		</table>	
	</div>
		<?php 
		//si on n'a pas déjà choisi la quantité dans la page de menu
		if(!isset($_SESSION['quantite_menu'])){ ?>

			<label for="quantite">Quantit&eacute; :</label>
			<select name="quantite">

			<?php
			for($i=1;$i<10;++$i){
				echo("<option value=\"".$i."\">".$i."</option>");
			}?>

		</select>
		<?php } ?>
		<input type="submit" value="Choisir">

	</form>
</section>