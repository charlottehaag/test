<section class="gerer_compte">

	<h1>Consulter/Modification compte de <?php echo $pseudo ?> </h1>


	<section class="infos_compte">
	<p>Infos du compte</p>
		<table class="tableau_gerer_compte">
    	
			<tr>
				<td class="tableau_grey">Pseudo :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($pseudo));?></td>
			</tr>
        
			<tr>
				<td class="tableau_grey">Nom :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($nom));?></td>
			</tr>
         
			<tr>
				<td class="tableau_grey">Pr&eacute;nom :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($prenom));?></td>
			</tr>
          
			<tr>
				<td class="tableau_grey">T&eacute;l&eacute;phone :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($telephone));?></td>
			</tr>
			<tr>
				<td class="tableau_grey">Email :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($email));?></td>
			</tr>
			<tr>
				<td class="tableau_grey">Date inscription :</td>
				<td class="tableau_clair"><?php echo $date;?></td>
			</tr>
			<tr>
				<td class="tableau_grey">Date dernière visite :</td>
				<td class="tableau_clair"><?php echo $last_date;?></td>
			</tr>
			<tr>
				<td class="tableau_grey">Nombre de commandes :</td>
				<td class="tableau_clair"><?php echo stripslashes(htmlspecialchars($nb_commande));?></td>
			</tr>  
		</table>	
	</section>

	<section class="choix_compte_button">
		<div class="button_historique">
			<form action="index.php?controle=client_cmd&action=aff_cmd_retire_cli" method="POST">
				<input type="submit" value="Afficher votre historique" />
			</form>
		</div>
		<div class="button_modif">
			<form action="index.php?controle=utilisateur&action=modif_compte" method="POST">
				<input type="submit" value="Modification du compte" />
			</form>
		</div>

		<div class="button_supp">
			<form action="index.php?controle=utilisateur&action=supp_compte" method="POST">
				<input type="submit" value="Suppression du compte" />
			</form>
		</div>
	</section>
	
</section>