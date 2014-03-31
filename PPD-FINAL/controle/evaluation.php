<?php

require("modele/evaluation_BD.php");

function aff_commentaires_partenaire(){
	//récupère l'id du partenaire concerné
	$id=$_GET['id_partenaire'];

	//récupère liste des commentaires
	$liste_commentaires=get_commentaires_partenaire($id);
	//affiche la page de liste_commentaires
	$page="commentaires_partenaire";
	require("vue/pagePrincipale.php");
}

function commenter_partenaire(){
	
	if(isset($_SESSION['id'])){
		//récupère l'id du paetenaire pour lequel on veut voter
		$id=$_GET['id_partenaire'];
		//si n'a pas encore voté
		if(!isset($_POST['contenu'])){
			//affiche la page du forumlaire
			$page="commenter_partenaire";
			require("vue/pagePrincipale.php");
		}

		//sinon prend commentaire en compte et redirrige sur la page d'où est parti le processus de commentaire
		else{
			commenter_partenaire_BD($id,$_POST['contenu']);
			//changer avec version charlotte (accueil)
			header("Location:index.php?controle=accueil&action=aff_accueil");
		}
	}
	else{
		$page="besoin_connexion";
		require("vue/pagePrincipale.php");
	}
}

function voter_partenaire(){
	//récupère l'id partenaire pour qui on veut voter
	$id=$_GET['id_partenaire'];

	//booléen de déjà voté ou pas
	$deja_vote=false;

	//cherche si a déjà voté ou pas
	foreach($_SESSION['votes_partenaires'] as $id_vote){
		if($id_vote==$id)
			$deja_vote=true;
	}

	//si n'a pas encore voté
	if(!$deja_vote){
		//prend en compte le vote en BD
		voter_partenaire_BD($id);
		//met l'id du partenaire voté dans la session
		$_SESSION['votes_partenaires'][]=$id;
	}
	//redirrige à la page d'origine du processus de vote MODIFIER POUR VERSION CHARLOTTZ
	header("Location:index.php?controle=accueil&action=aff_accueil");
}

//*******************************************************************     PRODUIT     **************************************************************

function aff_commentaires_produit(){
	//récupère l'id du produit concerné
	$id=$_GET['id_produit'];

	//récupère liste des commentaires du produit
	$liste_commentaires=get_commentaires_produit($id);

	//affiche la page de liste_commentaires du produit
	$page="commentaires_produit";
	require("vue/pagePrincipale.php");
}

function commenter_produit(){
	//récupère l'id du produit  pour lequel on veut voter
	$id=$_GET['id_produit'];
	//si n'a pas encore voté
	if(!isset($_POST['contenu'])){
		//affiche la page du formulaire
		$page="commenter_produit";
		require("vue/pagePrincipale.php");
	}

	//sinon prend commentaire en compte et redirrige sur la page d'où est parti le processus de commentaire
	else{
		commenter_produit_BD($id,$_POST['contenu']);
		//changer avec version charlotte (accueil)
		header("Location:index.php?controle=commande&action=choisir_produit");
	}
}

function voter_produit(){
	//récupère l'id produit pour qui on veut voter
	$id=$_GET['id_produit'];

	//booléen de déjà voté ou pas
	$deja_vote=false;

	//cherche si a déjà voté ou pas
	foreach($_SESSION['votes_produit'] as $id_vote){
		if($id_vote==$id)
			$deja_vote=true;
	}

	//si n'a pas encore voté
	if(!$deja_vote){
		//prend en compte le vote en BD
		voter_produit_BD($id);
		//met l'id du partenaire voté dans la session
		$_SESSION['votes_produit'][]=$id;
	}
	//redirrige à la page d'origine du processus de vote MODIFIER POUR VERSION CHARLOTTZ
	header("Location:".$_SERVER['HTTP_REFERER']);
}


?>