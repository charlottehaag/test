<section class="aff_cmdAttRetrait">
	<h1>Liste des commandes &agrave; retirer :</h1>
	<?php
	if($tab!=NULL){ ?>
		<table class="tableau_aff_cmdAttRetrait">
			<thead> <!-- En-tête du tableau -->
       			<tr>
		           <th class="tableau_fonce">N° Commande</th>
		           <th class="tableau_fonce">Date de commande</th>
		           <th class="tableau_fonce">Retirer ?</th>
       			</tr>
   			</thead>
   			<tbody> <!-- Corps du tableau -->
			<?php for($i=0; $i<count($tab); $i++){ ?>
				<tr>
					<td class="tableau_clair"><a href="index.php?controle=consult_cmd&action=affInfoCmd&idc=<?php echo($tab[$i]['id_commande']) ?>">Commande n°<?php echo($tab[$i]['id_commande']) ?></a> </td>
					<td class="tableau_clair"><?php echo(date('d/m/Y', $tab[$i]['date_commande'])) ?></td>
					<td class="tableau_clair">
						<form action="index.php?controle=partenaire_cmd&action=retirerCommande&id_commande=<?php echo($tab[$i]['id_commande']) ?>" method="POST">
							<input type="submit" value="Retirer" />
						</form>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
	<?php }else{ ?>
			<p>Pas de commande actuellement</p>
		<?php }	?>
</section>



