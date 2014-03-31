
<section class="acc_part">
<p>Bienvenue <?php echo $_SESSION['nompart']; ?> !</p>
<br>

<section class="acc_part_choix">
	<li><a href="index.php?controle=partenaire_cmd&action=affCmdEnC#menu">Consulter commande &agrave; pr&eacute;parer</a></li>
	<br>
	<li><a href="index.php?controle=partenaire_cmd&action=affCmdAttRetrait#menu">Consulter commande en attente de retrait</a></li>
	<br>
	<li><a href="index.php?controle=partenaire_cmd&action=affCmdHist#menu">Consulter l'historique des commandes termin&eacute;es</a></li>
	<br>
	<li><a href="index.php?controle=partenaire_cmd&action=consulterProduits#menu">Liste de vos produits</a></li>
	<br>
	<li><a href="index.php?controle=partenaire_cmd&action=consulterStockeIngredients#menu">Liste de vos ingr&eacute;dients</a></li>
</section>
<br><br>

<section class="acc_part_button">
	<p>Choisir votre disponibilit&eacute; :</p>
	
	<?php
	if(!$dispo){
	?>
	<div>
		<img src="commun/images/valider.png">
		<form action="index.php?controle=partenaire_cmd&action=DispoPart" method="POST">
			<input type="submit" value="Disponible" />
		</form>
	<?php
	}
	else{
	?>
		<img src="commun/images/annuler.png">
		<form action="index.php?controle=partenaire_cmd&action=nonDispoPart" method="POST">
			<input type="submit" value="Pas disponible" />
		</form>
	</div>
	<?php
	}
	?>
</section>

</section>
