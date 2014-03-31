<?php


function getMenu($id){
  require("modele/config_BD.php");
  $link = mysqli_connect($hote, $login, $pass,$bd);
  if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
  $req = "SELECT m.id_menu, m.prix_menu, comp.quantite_menu FROM Composer comp, Menu m WHERE comp.id_commande='$id' AND comp.id_menu=m.id_menu;";
  $res = mysqli_query($link, $req);
  
  $tab=array();
  
  //cpt cmd traitee
  $cpt=0;

  while($cmd=mysqli_fetch_assoc($res)){
    $tab[]=array($cmd);

    $prodid=getProduitMenu($cmd['id_menu']);
    $tab[$cpt][]=$prodid;
    $cpt ++;
  }
  mysqli_free_result($res);
  mysqli_close($link);
  return($tab); 
}


function getProduitMenu($id){
  require("modele/config_BD.php");
  $link = mysqli_connect($hote, $login, $pass,$bd);
  if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
  $req = "SELECT p.id_produit, p.libelle_prod, t.nom_type FROM Comporter comp, Produit p, Type t WHERE comp.id_menu='$id' AND comp.id_produit=p.id_produit AND p.id_type=t.id_type;";
  $res = mysqli_query($link, $req);
  $paul = null;
  while($prod=mysqli_fetch_assoc($res)){
    $paul[]=$prod;
  }
  
  mysqli_free_result($res);
  mysqli_close($link);
  return($paul);
}




function getProduit($id){
  require("modele/config_BD.php");
  $link = mysqli_connect($hote, $login, $pass,$bd);
  if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
  $req = "SELECT p.id_produit, p.libelle_prod, t.nom_type, c.quantite_produit FROM Produit p, Type t, Contenir c WHERE c.id_commande='$id' AND c.id_produit=p.id_produit AND p.id_type=t.id_type;";
  $res = mysqli_query($link, $req);
  $paul = null;
  $cpt=0;
  while($prod=mysqli_fetch_assoc($res)){
    $paul[]=$prod;
  }
  for($cpt=0; $cpt<count($paul); $cpt++){
    $paul[$cpt][]=getTotal($paul[$cpt]['id_produit']);
  }
  
  mysqli_free_result($res);
  mysqli_close($link);
  return($paul);
}




function affIngredientProduit_BD($id){

  require("modele/config_BD.php");
  $link = mysqli_connect($hote, $login, $pass,$bd);
  if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
  
  $req = "SELECT i.libelle_ingr, i.prix_ingr FROM Produit p, Composition co, Ingredient i WHERE p.id_produit='$id' AND p.id_produit = co.id_produit AND co.id_ingredient =i.id_ingredient;";
  $res = mysqli_query($link, $req);
  
  while($prod=mysqli_fetch_assoc($res)){
    $tb[] = $prod;
  }
  
  mysqli_free_result($res);
  mysqli_close($link);
  return($tb);  
}

function getTotal($id){
  require("modele/config_BD.php");
  $link = mysqli_connect($hote, $login, $pass,$bd);
  if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());

  $req = "SELECT SUM(i.prix_ingr) FROM Ingredient i, Produit p, Composition co WHERE p.id_produit = co.id_produit AND co.id_ingredient= i.id_ingredient AND p.id_produit=$id ";
  $res = mysqli_query($link, $req);
  $row=mysqli_fetch_row($res);
  mysqli_free_result($res);
  mysqli_close($link);
  return($row[0]);  
}

?>