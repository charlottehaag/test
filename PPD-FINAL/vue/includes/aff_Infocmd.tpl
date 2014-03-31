<section class="aff_Infocmd">
<h1>Composition de la commande</h1>
<?php if($menu!=NULL){?>
<u><p>Les menus :</p></u>
<?php 

for($i=0; $i<count($menu); $i++){ ?>
<p>Menu n°<?php echo($i+1) ?> Prix : <?php echo($menu[$i][0]['prix_menu'])?>euro(s) X <?php echo($menu[$i][0]['quantite_menu'])?></p>

<table class="tableau_menu">
   
   <thead> <!-- En-tête du tableau -->
       <tr>
           <th class="tableau_fonce">Type</th>
           <th class="tableau_fonce">Produit</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
      <?php
        ?>
      <?php for($ipm=0; $ipm<count($menu[$i][1]); $ipm++){  ?>
       <tr>
           <td class="tableau_clair"><?php echo($menu[$i][1][$ipm]['nom_type']) ?></td>
           <td class="tableau_clair"><?php if($menu[$i][1][$ipm]['nom_type']=='Sandwich'){?><a href="index.php?controle=consult_cmd&action=affIngredient&idp=<?php echo stripslashes(htmlspecialchars($menu[$i][1][$ipm]['id_produit'])) ?>"><?php echo($menu[$i][1][$ipm]['libelle_prod']) ?>
            <?php }else{ ?>
              <a><?php echo($menu[$i][1][$ipm]['libelle_prod']) ?></a>
           <?php } ?>

           </td>
       
       </tr>
        <?php } ?>
       
   </tbody>
</table>
<?php
}
}else{?>
<p>Pas de menu pour cette commande...</p>
<?php
}
?>
<br><br><br>
<u><p>Les produits hors menu :</p></u>
<?php if($prod!=NULL){?>
<table class="tableau_horsmenu">
   
   <thead> <!-- En-tête du tableau -->
       <tr>
           <th class="tableau_fonce">Type</th>
           <th class="tableau_fonce">Produit</th>
           <th class="tableau_fonce">Quantite</th>
           <th class="tableau_fonce">Prix unitaire</th>
       </tr>
   </thead>

   <tbody> <!-- Corps du tableau -->
      
      <?php for($j=0; $j<count($prod); $j++){  ?>
       <tr>
			<td class="tableau_clair"><?php echo($prod[$j]['nom_type']) ?></td>
			<td class="tableau_clair" ><a href="index.php?controle=consult_cmd&action=affIngredient&idp=<?php echo stripslashes(htmlspecialchars($prod[$j]['id_produit'])) ?>"><?php echo($prod[$j]['libelle_prod']) ?></td>
			<td class="tableau_clair"><?php echo($prod[$j]['quantite_produit']) ?> </td>
       		<td class="tableau_clair"><?php echo($prod[$j][0]." ") ?> &euro; </td>
       </tr>
        <?php } ?>
       
   </tbody>
</table>

<?php 
}else{ ?>
  <p>Pas de produit hors menu pour cette commande...</p>
<?php }


 ?>
</section>

