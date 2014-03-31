<?php

//gère le compte
function gerer_compte(){
	require("modele/utilisateur_BD.php");
	$pseudo = $_SESSION['pseudo'];
	$id = $_SESSION['id'];
	
	
	$nom = get_nom($pseudo);
	$prenom = get_prenom($pseudo);
	$telephone = get_telephone($pseudo);
	$email = get_email($pseudo);
	$date = get_date($pseudo);
	$last_date = get_last_date($pseudo);
	$nb_commande = get_nb_commande($pseudo);
	$page="gerer_compte";
	require("vue/pagePrincipale.php");
}


//modifier compte
function modif_compte(){
	$pseudo = $_SESSION['pseudo'];
	$page= "modif_compte";
	require("vue/pagePrincipale.php");
}

//supprimer compte
function supp_compte(){	
	$page="conf_supp_compte";
	require("vue/pagePrincipale.php");
	
}
function supp_compte_definitif(){
	require("modele/utilisateur_BD.php");
		
	$id=$_SESSION['id'];
	
	supp_compte_BD($id);
	session_unset();
	session_destroy();
	
	header("Location: index.php?controle=accueil&action=aff_accueil");
}

//verifie formulaire du pseudo
function verif_frm_pseudo($pseudo){
	global $msg;
	if(verif_format_pseudo($pseudo)){
		if(verif_pseudo_unique_BD($pseudo))
			return true;
		$msg = "Pseudo déjà existant";
	}
	return false;
}

//verifie formulaire de telephone
function verif_frm_tel($telephone){
	global $msg;
	if(verif_format_tel($telephone)){
		return true;
	}
	return false;
}

//verifie formulaire de email
function verif_frm_email($email){
	global $msg;
	if(verif_format_email($email)){
			return true;
	}
	return false;
}
//verifie formulaire du mot de passe
function verif_frm_mdp($mdp){
	global $msg;
	if(verif_format_mdp($mdp)){
			return true;
		
		$msg = "Format mot de passe incorrect";
	}
	return false;
}

//verifie format du pseudo
function verif_format_pseudo($pseudo){
	global $msg;
	if(!preg_match("`^[[:alnum:]]{3,20}$`", $pseudo)){
		$msg = "Erreur de format de votre pseudo : chaîne entre 4 et 20 caractères alphanumériques, sans accents";
		return false;
	}
	return true;
}
//verifie format numero de telephone
function verif_format_tel($telephone){
	global $msg;
	if(!preg_match("`^[[:digit:]]{10}$`", $telephone)){
		$msg = "Erreur de format de votre téléphone : chaîne de 10 caractères numériques";
		return false;			
	}
	return true;
}

// verifie format email
function verif_format_email($email){
	global $msg;
	if(!preg_match("`^(.+)@(.+)\.(.+)$`", $email)){
		$msg = "Erreur de format de votre e-mail";
		return false;			
	}
	return true;
}

//verifie format du mot de passe
function verif_format_mdp($mdp){
	global $msg;
	if(!preg_match("`^[[:alnum:]éèëïêö]{4,20}$`", $mdp)){
		$msg = "Erreur de format de votre mot de passe : chaîne entre 4 et 20 caractères alphanumériques";
		return false;
	}
	return true;
}


//enregistre la modification du pseudo
function enregistrer_modif_pseudo(){
	global $msg ;
	$msg = null;
	$pseudo=isset($_POST['pseudo_cli'])?$_POST['pseudo_cli']:'';

	$id = $_SESSION['id'];
	
	if(count($_POST) == 0){
		$page="modif_pseudo";
	}
	else{
		require("modele/utilisateur_BD.php");
		if(verif_frm_pseudo($pseudo)){
			enregistrer_modif_pseudo_BD($pseudo,$id);
			$_SESSION['pseudo']=$pseudo;
			$page="conf_modif_pseudo";
			
		}
		else
			
			$page="modif_pseudo";
	}
	require("vue/pagePrincipale.php");
}

//enregistre la modification du numero de telephone
function enregistrer_modif_tel(){
	global $msg ;
	$telephone=isset($_POST['telephone_cli'])?$_POST['telephone_cli']:'';
	$id = $_SESSION['id'];
	
	if(count($_POST) == 0){
		$page="modif_tel";
	}
	else{
		require("modele/utilisateur_BD.php");
		if(verif_frm_tel($telephone)){
			enregistrer_modif_tel_BD($telephone,$id);
			$page="conf_modif_tel";
		}
		else
			$page="modif_tel";
	}
	require("vue/pagePrincipale.php");
}

//enregistre la modification de l'email
function enregistrer_modif_email(){
	global $msg ;
	$email=isset($_POST['email_cli'])?$_POST['email_cli']:'';
	$id = $_SESSION['id'];
	
	if(count($_POST) == 0){
		$page="modif_email";
	}
	else{
		require("modele/utilisateur_BD.php");
		if(verif_frm_email($email)){
			enregistrer_modif_email_BD($email,$id);
			$page="conf_modif_email";
		}
		else
			$page="modif_email";
	}
	require("vue/pagePrincipale.php");
}

//enregistre la modification du mot de passe
function enregistrer_modif_mdp(){
	global $msg ;
	$mdp=isset($_POST['mdp_cli'])?$_POST['mdp_cli']:'';
	$id = $_SESSION['id'];
	
	if(count($_POST) == 0){
		$page="modif_mdp";
	}
	else{
		require("modele/utilisateur_BD.php");
		if(verif_frm_mdp($mdp)){
			enregistrer_modif_mdp_BD($mdp,$id);
			$page="conf_modif_mdp";
		}
		else
			$page="modif_mdp";
	}
	require("vue/pagePrincipale.php");
}

//verifie si le pseudo existe déja
function verifPseudoUnique(){
	require("modele/utilisateur_BD.php");
	$pseudo = $_POST['pseudo_cli'];
	if(verif_pseudo_unique_BD($pseudo))
		echo 'true';
	else
		echo 'false';
}
?>