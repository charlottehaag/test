<?php

require("modele/identification_BD.php");
//pour carte
require('controle/commande.php');


function connexion(){
	$tab_partenaire=get_all_partenaire();
	$msg= null;
	$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : "";
	$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
	if(COUNT($_POST) == 0){
		$page="connexion";
	}
	else{
		$ok=connexion_BD($pseudo,$mdp);
		if($ok){
			$page="conf_connexion";
			$_SESSION['pseudo']=$pseudo;
			$_SESSION['id'] = get_id($pseudo);
			setLastVisite($pseudo);
			$page="accueil";
		}
		else{
			$msg="Les données entrées n'ont pas permis de vous identifier";
			$page="accueil";
		}
	}
	require("vue/pagePrincipale.php");
}


function deconnexion(){
	$tab_partenaire=get_all_partenaire();
	session_unset();
	session_destroy();

	$page="accueil";
	require("vue/pagePrincipale.php");
}


?>