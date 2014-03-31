<section class="aff_cmd_retire_client">
	
	<?php
	if($tab_comm_client!=NULL){ ?>
		<h1><?php echo $_SESSION['pseudo']; ?> voici la liste de vos commandes retir&eacute;es :</h1>
		<table>
		<?php for($i=0; $i<count($tab_comm_client); $i++){ ?>
		<table class="tableau_aff_cmd_retire_client">
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

			<tr>
				<td class="tableau_clair">
					<a href="index.php?controle=consult_cmd&action=affInfoCmd&idc=<?php echo($tab_comm_client[$i]['id_commande']) ?>">Commande n°<?php echo($tab_comm_client[$i]['id_commande']) ?></a>
				</td>
				<td class="tableau_clair">
					<?php echo date('d/m/y', $tab_comm_client[$i]['date_commande']); ?>
				</td>
				<td class="tableau_clair">
					<?php echo $tab_comm_client[$i]['nom_part']; ?>
				</td>
				<td class="tableau_clair">
					<?php echo $tab_comm_client[$i]['adresse_part']." ".$tab_comm_client[$i]['code_part']; ?>
				</td>
				<td class="tableau_clair">
					<?php if($tab_comm_client[$i]['est_retire'] == 1) { ?>
						Vous avez retir&eacute; cette commande.
					<?php } ?>
				</td>
			</tr>
		<?php
		}?>
		</tbody>
		</table>
	<?php }else{ ?>
	<h1>Pas de commandes retir&eacute;es</h1>
	<?php  } ?>
</section>
