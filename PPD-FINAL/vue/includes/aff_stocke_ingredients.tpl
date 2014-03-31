<section class="aff_stock_ingredients">

<table class="tableau_stock_ingredients">
   <p>Liste de vos ingr&eacute;dients :</p>

   <thead> <!-- En-tête du tableau -->
       <tr>
       		<th class="tableau_fonce">Numero de l'ingredient</th>
			<th class="tableau_fonce">Libelle de l'ingredient</th>
			<th class="tableau_fonce">Prix Ingredient</th>
           
        
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
      <?php if(is_array($tab)){
              foreach ($tab as $value) {
        ?>
       <tr>
       		<td class="tableau_clair"><?php echo($value['id_ingredient']) ?></td>
			<td class="tableau_clair"><?php echo($value['libelle_ingr']) ?></td>
			<td class="tableau_clair"><?php echo($value['prix_ingr']." ") ?> &euro;</td>
       </tr>
       <?php }
        }else { ?>
          <p>Pas d'ingr&eacute;dients</p>
        <?php } ?>
        
   </tbody>
</table>

</section>