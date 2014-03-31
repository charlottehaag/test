<section class="aff_ingredients_produit">

<table class="tableau_ingredient">
   <u><p>Ingr&eacute;dients du produit :</p></u>

   <thead> <!-- En-tête du tableau -->
       <tr>
           <th class="tableau_fonce">Libelle de l'ingr&eacute;dient</th>
           <th class="tableau_fonce">Prix Ingredient</th>
           
        
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
      <?php if(is_array($tb)){
              foreach ($tb as $value) {
        ?>
       <tr>
           <td class="tableau_clair"><?php echo($value['libelle_ingr']) ?></td>
           <td class="tableau_clair"><?php echo($value['prix_ingr']." ") ?>&euro;</td>
       </tr>
       <?php }
        } ?>
        <tr> 
        	<th class="tableau_total"> Prix total du produit </th>
            <td class="tableau_total"> <?php echo($total." ")?>&euro; </td>
        </tr>
   </tbody>
</table>

</section>