<section class="aff_cmdHist">
	<p>Historique des commandes termin&eacute;es :</p>
	<?php
	
	if($tab!=NULL){ ?>
		<table class="tableau_aff_cmdHist">
			<thead> <!-- En-tête du tableau -->
       			<tr>
		           <th class="tableau_fonce">N° Commande</th>
		           <th class="tableau_fonce">Date de commande</th>
       			</tr>
   			</thead>
   			<tbody> <!-- Corps du tableau -->
			<?php for($i=0; $i<count($tab); $i++){ ?>
				<tr>
					<td class="tableau_clair"><a href="index.php?controle=consult_cmd&action=affInfoCmd&idc=<?php echo($tab[$i]['id_commande']) ?>">Commande n°<?php echo($tab[$i]['id_commande']) ?></a> </td>
					<td class="tableau_clair"><?php echo(date('d/m/Y', $tab[$i]['date_commande'])) ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php }else{ ?>
			<p>Pas de commande actuellement</p>
		<?php }	?>
</section>