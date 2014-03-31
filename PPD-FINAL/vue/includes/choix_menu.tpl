<section class="choix_menu">
	<p>Que souhaitez-vous commander ?</p>
	<form action="index.php?controle=commande&action=choisir_boisson_dessert" method="POST">
		<input type="submit" value="Un menu (sandwich+boisson+dessert)" />
	</form>

	<form action="index.php?controle=commande&action=aff_possibilites_commande" method="POST">
		<input type="submit" value="Un sandwich seul"/>
	</form>

</section>