<section class="commentaires_produit">
<p>Commentaires :</p>
<?php
if(isset($liste_commentaires)&&count($liste_commentaires)>0){?>
<table class="tableau_commentaires_produit">
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
			<td class="tableau_clair"><?php echo $com['date']; ?></td>
			<td class="tableau_clair"><?php echo $com['contenu']; ?></td>
		</tr>

	<?php
	}?>
</tbody>
</table>
<?php
}else{
?>

	<p>Aucun commentaire pour ce produit.</p>
<?php
}
?>
</section>