<section class="aff_cmdEnC">
<p>Liste des commandes &agrave; pr&eacute;parer :</p>
<?php
	if($tab!=NULL){ ?>
		<table class="tableau_aff_cmdEnC">
			<thead> <!-- En-tête du tableau -->
       			<tr>
		           <th class="tableau_fonce">N° Commande</th>
		           <th class="tableau_fonce">Date de commande</th>
		           <th class="tableau_fonce">Pr&ecirc;te ?</th>
       			</tr>
   			</thead>
   			<tbody> <!-- Corps du tableau -->
			<?php for($i=0; $i<count($tab); $i++){ ?>
				<tr>
					<td class="tableau_clair"><a href="index.php?controle=consult_cmd&action=affInfoCmd&idc=<?php echo($tab[$i]['id_commande']) ?>">Commande n°<?php echo($tab[$i]['id_commande']) ?></a></td>
					<td class="tableau_clair"><?php echo(date('d/m/Y', $tab[$i]['date_commande'])) ?></td>
					<td class="tableau_clair">
						<form action="index.php?controle=partenaire_cmd&action=validerCommande&id_commande=<?php echo($tab[$i]['id_commande']) ?>" method="POST">
							<input type="submit" value="Signaler pr&ecirc;te" />
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






