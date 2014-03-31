<section class="aff_produits_part">

<table class="tableau_produits_part">
   <p>Liste de vos produits</p>

   <thead> <!-- En-tête du tableau -->
       <tr>
			<th class="tableau_fonce">Numero du produit</th>
			<th class="tableau_fonce">Libelle du produit</th>
			<th class="tableau_fonce">Type du produit</th>
           
        
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
      <?php if(is_array($tab)){
              foreach ($tab as $value) {
        ?>
       <tr>
       		<td class="tableau_clair"><?php echo($value['id_produit']) ?></td>
			<td class="tableau_clair"><?php echo($value['libelle_prod']) ?></td>
			<td class="tableau_clair"><?php echo($value['nom_type']) ?></td>
       </tr>
       <?php }
        } ?>
        
   </tbody>
</table>

</section>