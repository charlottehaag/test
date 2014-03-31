<?php



// Retourne les commandes d'un partenaire
function get_commandeEnC($id_part){
//importe les variables de connexion
require("modele/config_BD.php");
//connecte à la base de données
$link=mysqli_connect($hote,$login,$pass,$bd);
if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
//requête
$req="SELECT c.id_commande, c.date_commande FROM Commande c 
WHERE c.id_partenaire='$id_part' AND c.est_retire = 0 AND c.est_prete = 0 
 ORDER BY c.id_commande DESC ;";
//execution
$res=mysqli_query($link,$req);
//mise dans un tableau exploitable php
$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
return $tab;	
}


function get_commandeRetrait($id_part){
//importe les variables de connexion
require("modele/config_BD.php");
//connecte à la base de données
$link=mysqli_connect($hote,$login,$pass,$bd);
if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
//requête
$req="SELECT c.id_commande, c.date_commande FROM Commande c 
WHERE c.id_partenaire='$id_part' AND c.est_retire = 0 AND c.est_prete = 1 
ORDER BY c.id_commande DESC
;";
//execution
$res=mysqli_query($link,$req);
//mise dans un tableau exploitable php
$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
return $tab;	
}




function get_commandeHist($id_part){
//importe les variables de connexion
require("modele/config_BD.php");
//connecte à la base de données
$link=mysqli_connect($hote,$login,$pass,$bd);
if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
//requête
$req="SELECT c.id_commande, c.date_commande 
FROM Commande c 
WHERE c.id_partenaire='$id_part' AND c.est_retire = 1 AND c.est_prete = 1 
ORDER BY c.id_commande DESC
;";
//execution
$res=mysqli_query($link,$req);
//mise dans un tableau exploitable php
$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
return $tab;	
}

function set_est_retire_BD($id_commande){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass, $bd);
		$req = "UPDATE commande SET est_retire = 1 WHERE  id_commande = '$id_commande'";
		$res = mysqli_query($link, $req)
			or die (mysqli_error($link));	
		return $res;
	
	}
	
function set_est_prete_BD($id_commande){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass, $bd);
		$req = "UPDATE commande SET est_prete = 1 WHERE  id_commande = '$id_commande'";
		$res = mysqli_query($link, $req)
			or die (mysqli_error($link));
		return $res;
			
	}
function consulter_Stocke_Ingredients_BD($id_part){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "Select i.id_ingredient, i.libelle_ingr, i.prix_ingr FROM Partenaire p, Ingredient i, Stocke s 
	     WHERE p.id_partenaire = '$id_part' AND p.id_partenaire = s.id_partenaire AND s.id_ingredient = i.id_ingredient
		ORDER BY i.id_ingredient
	     ";
	$res = mysqli_query($link, $req)
			or die (mysqli_error($link));
	while($ingr=mysqli_fetch_assoc($res)){
		$tab[]=$ingr;
	}
	return $tab;
}

function etatDispo(){
	//connexion
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$id_part=$_SESSION['id_part'];
	//requête
	$req="SELECT est_dispo FROM Partenaire WHERE id_partenaire=$id_part";
	//execution
	$res=mysqli_query($link,$req);
	$tab=mysqli_fetch_row($res);
	return $tab[0];
}

function consulter_Produits_BD($id_part){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	//$req = "Select p.id_produit, p.libelle_prod, t.nom_type  FROM Partenaire pa, Propose pr,Produit p,Type t WHERE pa.id_partenaire = '$id_part' AND pa.id_partenaire = pr.id_partenaire AND pr.id_produit = p.id_produit AND p.id_type=t.id_type";
	$req="SELECT p.id_produit, p.libelle_prod, t.nom_type FROM Type t, Produit p WHERE p.est_predefini=1 AND t.id_type=p.id_type ORDER BY p.id_produit";
	$res = mysqli_query($link, $req)
			or die (mysqli_error($link));
	while($prod=mysqli_fetch_assoc($res)){
		$tab[]=$prod;
	}
	return $tab;
}


function est_Dispo($id_part){
	require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass, $bd);
		$req = "UPDATE Partenaire SET est_dispo = 1 WHERE id_partenaire = '$id_part'";
		$res = mysqli_query($link, $req)
			or die (mysqli_error($link));
		return $res;
}

function non_Dispo($id_part){
	require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass, $bd);
		$req = "UPDATE Partenaire SET est_dispo = 0 WHERE id_partenaire = '$id_part'";
		$res = mysqli_query($link, $req)
			or die (mysqli_error($link));
		return $res;
}









// consult info commande
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