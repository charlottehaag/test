<section class="mes_commandes">

<h3>R&eacute;capitulatif de votre panier et de vos commandes en cours de pr&eacute;paration</h3>
<br>

<?php
if(isset($liste_produits)||isset($liste_ingredients)||isset($liste_menus)){

	if($verrou){
	?>
		<p>Votre panier est verrouill&eacute;</p>
	<?php
	}	
	?>
	<h1>Mes produits seuls</h1>
	<?php
			if(isset($liste_produits)){
	?>
	<table class="tableau_panier">
		<thead>
		<tr> 
			<td class="tableau_fonce">Produit</td>	
			<td class="tableau_fonce">Ingr&eacute;dients</td>	
			<td class="tableau_fonce">Quantité</td> 
			<td class="tableau_fonce">Modification</td>
			<td class="tableau_fonce">Prix unitaire</td>
		</tr>
		</thead>
		<tbody>

		<?php
				$i=0;
				//produits
				foreach($liste_produits as $produit){
					echo("
					<tr>
						<td class='tableau_clair'>".$produit['libelle_prod']."</td>
						<td class='tableau_clair'>".$produit['ingredients']."</td>
						<td class='tableau_clair'>".$_SESSION['choix_produits'][$i][1]."</td>
						<td class='tableau_clair'>");

					if(!$verrou){
						echo("	
							<a href='index.php?controle=commande&action=inc_qte_produit&ind=".$i."'>+1</a>
							<a href='index.php?controle=commande&action=dec_qte_produit&ind=".$i."'>-1</a>
						");
					}

					echo("
						</td>
						<td class='tableau_clair'>".$_SESSION['choix_produits'][$i]['prix']."</td>
					</tr>
					");

					$i++;
				}
			}else if(!isset($liste_produits) && !isset($liste_ingredients)){?>
			<p>pas de produit seul</p>
			<?php } ?>
			<?php  

			if(isset($liste_ingredients)){
				echo(" <table class='tableau_panier'>
		<thead>
		<tr> 
			<td class='tableau_fonce'>Produit</td>	
			<td class='tableau_fonce'>Ingr&eacute;dients</td>	
			<td class='tableau_fonce'>Quantité</td> 
			<td class='tableau_fonce'>Modification</td>
			<td class='tableau_fonce'>Prix unitaire</td>
		</tr>
		</thead>
				<tbody>");
				//compteur groupe d'ingrés
				$i=0;
				//pour chaque groupe d'ingrédients qui composent un produit
				foreach($liste_ingredients as $groupe){
					echo("
					<tr>
						<td class='tableau_clair'>Choix personnalis&eacute;</td>
						<td class='tableau_clair'>
					");

					//pour savoir si dernier ou pas
					$cpt=1;

					//décompose chaque ingrédient du groupe
					foreach($groupe as $ingr){
						echo($ingr);
						if($cpt<count($groupe))
							echo(", ");
						$cpt++;
					}	
					
					echo ("
						</td>
						<td class='tableau_clair'>".$_SESSION['choix_ingredients'][$i][1]."</td>
						<td class='tableau_clair'>");
					if(!$verrou){
						echo("		
							<a href='index.php?controle=commande&action=inc_qte_ingredient&ind=".$i."'>+1</a>
							<a href='index.php?controle=commande&action=dec_qte_ingredient&ind=".$i."'>-1</a>
						");
					}
						echo("
						</td>
						<td class='tableau_clair'>".$_SESSION['choix_ingredients'][$i]['prix']."</td>
						</tr>");
					$i++;
				}
			}

		?>
	</tbody>
	</table>

	<h1>Mes menus</h1>
	<?php
		if(isset($liste_menus)){
	?>
	<table class="tableau_panier">
	<thead>
		<tr>
			<td class="tableau_fonce">Boisson</td>
			<td class="tableau_fonce">Dessert</td>
			<td class="tableau_fonce">Produit</td>
			<td class="tableau_fonce">Ingr&eacute;dients</td>
			<td class="tableau_fonce">Quantité</td>
			<td class="tableau_fonce">Modification</td>
			<td class="tableau_fonce">Prix unitaire</td>
		</tr>
	</thead>
	<tbody>
		<?php
				//compteur menus
				$i=0;
				foreach($liste_menus as $menu){				
					echo("
							<tr>
								<td class='tableau_clair'>".$menu[0]."</td>
								<td class='tableau_clair'>".$menu[1]."</td>
						");

					//si menu contenant un produits
					if(count($menu[2])==1){
							echo("
								<td class='tableau_clair'>".$menu[2]."</td>
								<td class='tableau_clair'>".$menu['ingredients']."</td>
							");
					}
					//si menu composé avec ingrédients personnalisés
					else{
						
						echo("
							<td class='tableau_clair'>Choix personnalis&eacute;</td>
							<td class='tableau_clair'>
							");

						//savoir si dernier ou pas
						$cpt=1;
						
						//pour chaque ingrédient qui compose le produit du menu
						foreach($menu[2] as $ingr){

							echo($ingr);
							if($cpt<count($menu[2]))
								echo(", ");
							$cpt++;
						}
						echo "</td>";
					}

					echo("<td class='tableau_clair'>".$menu[3]."</td>
						
						<td class='tableau_clair'>");
					if(!$verrou){
						echo "
							<a href='index.php?controle=commande&action=inc_qte_menu&ind=".$i."'>+1</a>
							<a href='index.php?controle=commande&action=dec_qte_menu&ind=".$i."'>-1</a>
							";
					
					}
						echo ("</td>
						<td class='tableau_clair'>".$_SESSION['choix_menus'][$i]['prix']."</td>
						</tr>
						");
					$i++;
				}
			}else{?>
			<p>pas de menu</p>
			<?php } ?>
			</tbody>
			</table>
			
			<table class="tableau_prix_total">
			<?php  

			echo"<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class='tableau_fonce'>Prix total</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class='tableau_clair'>".$prix_total."</td>
				</tr>";
			?>
			</table>

	<p>Mon lieu de livraison : <?php echo $_SESSION['choix_lieu']; ?></p>
	<section class="mes_commandes_button">
		<div>
			<form action="index.php?controle=commande&action=vider_panier" method="POST">
				<input type="submit" value="Vider le panier" />
			</form>
		</div>
	
	<?php
	if(!$verrou){?>
		<div>
			<form action="index.php?controle=commande&action=valider_commande" method="POST">
				<input type="submit" value="Valider ma commande" />
			</form>
		</div>
<?php
	}?>
	</section>
	<?php
}
else
	echo("<p>Vous n'avez aucun produit dans votre panier</p>");
?>

	<section class="acc_cmd_non_retire_cli">
	<?php
	if($tab_comm_client!=NULL){ ?>
		<br><br>
		<h1><?php echo $_SESSION['pseudo']; ?> voici la liste de vos commandes en cours</h1>
		<table class="tableau_panier">
		<thead>
		<tr> 
			<td class="tableau_fonce">Numéro commande</td>	
			<td class="tableau_fonce">Date commande</td>	
			<td class="tableau_fonce">Nom partenaire</td> 
			<td class="tableau_fonce">Adresse partenaire</td>
			<td class="tableau_fonce">Etat</td>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0; $i<count($tab_comm_client); $i++){ ?>
			<tr>
				<td class='tableau_clair'>
					<a href="index.php?controle=consult_cmd&action=affInfoCmd&idc=<?php echo($tab_comm_client[$i]['id_commande']) ?>">Commande n°<?php echo($tab_comm_client[$i]['id_commande']) ?></a>
				</td>
				<td class='tableau_clair'>
					<?php echo date('d/m/y', $tab_comm_client[$i]['date_commande']); ?>
				</td>
				<td class='tableau_clair'>
					<?php echo $tab_comm_client[$i]['nom_part']; ?>
				</td>
				<td class='tableau_clair'>
					<?php echo $tab_comm_client[$i]['adresse_part']." ".$tab_comm_client[$i]['code_part']; ?>
				</td>
				<td class='tableau_clair'>
					<?php if($tab_comm_client[$i]['est_prete'] == 1) { ?>
						Votre commande est prête.
					<?php } else { ?>
						Votre commande est en cours de préparation.
					<?php } ?>
				</td>
			</tr>
		<?php
		}?>
		</tbody>
		</table>
	<?php }else{ ?>
	<p>Pas de commandes non retirées</p>
	<?php  } ?>
</section>


</section>
