<section class="possibilites_commande">
	<p>S&eacute;lectionner la m&eacute;thode de commande :</p>
	
	<form action="index.php?controle=commande&action=choisir_ingredients" method="POST">
		<input type="submit" value="Sandwich personnalisé (1,50 euros)" />
	</form>
	<br>
	
	<p>Les lieux de pr&eacute;paration possibles vous seront propos&eacute;s en fonction du produit :<p>
	<form action="index.php?controle=commande&action=choisir_lieu" method="POST">
		<input type="submit" value="lieux de pr&eacute;paration (utile si produit personnalisé)" />
	</form>
	<br>

	<p>Les produit possibles vous seront propos&eacute;s en fonction du lieux de pr&eacute;paration :<p>
	<form action="index.php?controle=commande&action=choisir_produit" method="POST">
		<input type="submit" value="Sandwich pr&eacute;d&eacute;fini (disponnible chez tous nos partenaires)" />
	</form>
	<br>

</section>