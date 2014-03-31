<?php 


function affInfoCmd(){
	$idc=$_GET['idc'];
	require("modele/consult_cmd_BD.php");
	$menu=getMenu($idc);
	$prod=getProduit($idc);
	$page="aff_Infocmd";
	require("vue/pagePrincipale.php");
}

function affIngredient(){
	$id =$_GET['idp'];
	require("modele/consult_cmd_BD.php");
	$tb= affIngredientProduit_BD($id);
	$total = getTotal($id);
	$page = "aff_ingredients_produit";
	require("vue/pagePrincipale.php");
}



?>