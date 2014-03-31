<?php 

function get_commande_retire_client($idcli){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
	//requête
	$req="SELECT DISTINCT(c.id_commande), c.date_commande, p.nom_part, p.adresse_part, p.code_part, c.est_retire
		  FROM Commande c, Partenaire p 
		  WHERE c.id_client = $idcli AND c.est_retire = 1 AND c.est_prete = 1 AND p.id_partenaire = c.id_partenaire
		  ORDER BY c.id_commande DESC
		  ";
	//execution
	$res=mysqli_query($link,$req);
	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
	return $tab;	
}



?>