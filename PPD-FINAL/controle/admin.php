<?php

require("modele/admin_BD.php");

function connexionAdmin(){
	$msg= null;
	$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : "";
	$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
	
	if(COUNT($_POST) == 0){
		$page="connexion_admin";
	}
	else{
			$ok=connexionAdmin_BD($pseudo,$mdp);
			if($ok){
				$_SESSION['pseudo']=$pseudo;
				header("Location: index.php?controle=partenaire&action=inscription");
				
			}
			else{
				$msg="Les donn&eacute;es entr&eacute;es n'ont pas permis de vous identifier";
				$page="connexion_admin";
			}
		
	}
	require("vue/pagePrincipale.php");
}


?>