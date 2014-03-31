<section class="acc_cmd_non_retire_cli">
	<?php
	if($tab_comm_client!=NULL){ ?>
		<h1><?php echo $_SESSION['pseudo']; ?> voici la liste de vos commandes en cours</h1>
		<table>
		<?php for($i=0; $i<count($tab_comm_client); $i++){ ?>
			<tr>
				<td>
					<h1><a href="index.php?controle=consult_cmd&action=affInfoCmdEnC&idc=<?php echo($tab_comm_client[$i]['id_commande']) ?>">Commande n°<?php echo($tab_comm_client[$i]['id_commande']) ?></a> </h1>
				<td/>
				<td>
					<?php echo date('d/m/y', $tab_comm_client[$i]['date_commande']); ?>
				</td>
				<td>
					<?php echo $tab_comm_client[$i]['nom_part']; ?>
				</td>
				<td>
					<?php echo $tab_comm_client[$i]['adresse_part']." ".$tab_comm_client[$i]['code_part']; ?>
				</td>
				<td>
					<?php if($$tab_comm_client[$i]['est_prete'] == 1) { ?>
						Votre commande est prête.
					<?php } else { ?>
						Votre commande est en cours de préparation.
					<?php } ?>
				</td>
			</tr>
		<?php
		}?>
		</table>
	<?php }else{ ?>
	<p>Pas de commandes non retirées</p>
	<?php  } ?>
</section>
