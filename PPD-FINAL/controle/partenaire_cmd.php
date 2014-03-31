<?php

require("modele/partenaire_cmd_BD.php");


function aff_acc(){
	//regarde si dispo ou pas
	$dispo=etatDispo();
	$page = "acc_part";
	require("vue/pagePrincipale.php");
}

function affCmdEnC(){
	$idp=$_SESSION['id_part'];
	$tab=get_commandeEnC($idp);
	$page="aff_cmdEnC";
	require("vue/pagePrincipale.php");
}

function affCmdHist(){
	$idp=$_SESSION['id_part'];
	$tab=get_commandeHist($idp);
	$page="aff_cmdHist";
	require("vue/pagePrincipale.php");
}


function affCmdAttRetrait(){
	$idp=$_SESSION['id_part'];
	$tab = get_commandeRetrait($idp);
	$page ="aff_cmdAttRetrait";
	require("vue/pagePrincipale.php");

}


function validerCommande(){
	$id_commande = $_GET['id_commande'];
	set_est_prete_BD($id_commande);
	header("Location: index.php?controle=partenaire_cmd&action=affCmdEnC");

}

function retirerCommande(){
	$id_commande = $_GET['id_commande'];
	set_est_retire_BD($id_commande);
	header("Location: index.php?controle=partenaire_cmd&action=affCmdAttRetrait");
}

function consulterStockeIngredients(){
	$id_part = $_SESSION['id_part'];
	$tab=consulter_Stocke_Ingredients_BD($id_part);
	$page = "aff_stocke_ingredients";
	require("vue/pagePrincipale.php");
}

function consulterProduits(){
	$id_part = $_SESSION['id_part'];
	$tab = consulter_Produits_BD($id_part);
	$page ="aff_produits_part";
	require("vue/pagePrincipale.php");
	
}

function DispoPart(){
	$id_part = $_SESSION['id_part'];
	est_Dispo($id_part);
	header("Location: index.php?controle=partenaire_cmd&action=aff_acc");
}

function nonDispoPart(){
	$id_part = $_SESSION['id_part'];
	non_Dispo($id_part);
	header("Location: index.php?controle=partenaire_cmd&action=aff_acc");
}


?>