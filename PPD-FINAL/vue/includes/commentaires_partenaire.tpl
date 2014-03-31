<section class="commentaires_partenaire">
<p>Commentaires :</p>
<?php
if(isset($liste_commentaires)&&count($liste_commentaires)>0){?>
	<table class="tableau_commentaires_partenaire">
	<thead>
		<tr>
			<td class="tableau_fonce">Pseudo</td>
			<td class="tableau_fonce">Date de publication</td>
			<td class="tableau_fonce">Commentaire</td>
		</tr>
	</thead>
	<?php
	foreach($liste_commentaires as $com){
	?>

		<tbody>
		<tr>
			<td class="tableau_clair"><?php echo $com['pseudo_auteur']; ?></td>
			<td class="tableau_clair"><?php echo date('d/m/Y',$com['date']); ?></td>
			<td class="tableau_clair"><?php echo $com['contenu']; ?></td>
		</tr>

	<?php
	}?>
</tbody>
</table>
<?php
}else{
?>
	<p>Aucun commentaire pour ce partenaire.</p>
<?php
}
?>
</section>