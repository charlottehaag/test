<section class="conf_supp_compte">

	<p>&Ecirc;tes-vous s&ucirc;r de vouloir supprimer le compte ?</p>

	<section class="choix_conf_supp_compte_button">
		<div class="button_confirmer">
			<form action="index.php?controle=utilisateur&action=supp_compte_definitif" method="POST">
				<input type="submit" value="Confirmer" />
			</form>
		</div>

		<div class="button_annuler">
			<form action="index.php?controle=utilisateur&action=gerer_compte" method="POST">
				<input type="submit" value="Annuler" />
			</form>
		</div>
	</section>
</section>