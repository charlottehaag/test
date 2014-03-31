<?php

require("modele/inscriptionBD.php");


function inscrire(){
	global $msg;
	$msg =  "Veuillez remplir tous les champs !";
	$nom = isset($_POST['nom_cli'])?$_POST['nom_cli']:'';
	$prenom = isset($_POST['prenom_cli'])?$_POST['prenom_cli']:'';
	$pseudo=isset($_POST['pseudo_cli'])?$_POST['pseudo_cli']:'';
	$password=isset($_POST['mdp_cli'])?$_POST['mdp_cli']:'';
	$email=isset($_POST['email_cli'])?$_POST['email_cli']:'';
	$telephone=isset($_POST['telephone_cli'])?$_POST['telephone_cli']:'';
	if(count($_POST) == 0){
		$page="inscription";
	}
	else{
		if(verif_inscription($nom,$prenom,$pseudo,$password,$email, $telephone)){
			inscrireBD($nom, $prenom, $pseudo, $password, $email, $telephone);
			$page="conf_insc_cli";
		}
		else
			$page="inscription";
	}
	require("vue/pagePrincipale.php");

}

function verif_inscription($nom, $prenom, $pseudo, $password, $email, $telephone){
	global $msg;
	if(verif_format($nom, $prenom, $pseudo, $password, $email, $telephone)){
		if(pseudo_unique($pseudo))
			return true;
		$msg = "Pseudo déjà existant";
	}
	return false;
}

function verif_format($nom, $prenom, $pseudo, $password, $email, $telephone){
	global $msg;
	if(!preg_match("`^[[:alnum:]]{3,20}$`", $pseudo)){
		$msg = "Erreur de format de votre pseudo : chaîne entre 4 et 20 caractères alphanumériques, sans accents";
		return false;
	}
	if(!preg_match("`^[[:alnum:]éèëïêö]{4,20}$`", $password)){
		$msg = "Erreur de format de votre mot de passe : chaîne entre 4 et 20 caractères alphanumériques";
		return false;
	}
	if(!preg_match("`^[[:alpha:]éèëïêö]{3,20}$`", $nom)){
		$msg = "Erreur de format de votre nom : chaîne entre 3 et 20 caractères alphabétiques";
		return false;
	}
	if(!preg_match("`^[[:alpha:]éèëïêö]{3,20}$`", $prenom)){
		$msg = "Erreur de format de votre prénom : chaîne entre 3 et 20 caractères alphabétiques";
		return false;
	}
	if(!preg_match("`^(.+)@(.+)\.(.+)$`", $email)){
		$msg = "Erreur de format de votre e-mail";
		return false;			
	}
	if(!preg_match("`^[[:digit:]]{10}$`", $telephone)){
		$msg = "Erreur de format de votre téléphone : chaîne de 10 caractères numériques";
		return false;			
	}
	return true;
}

function verifPseudoClientUnique(){
	$pseudo = $_POST['pseudo'];
	if(pseudo_unique($pseudo))
		echo 'true';
	else
		echo 'false';
}

?>