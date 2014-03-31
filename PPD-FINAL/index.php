
<?php
	session_start();

	//initialise les données nécessaires à toute session
	if(!isset($_SESSION["votes_produits"]))
		$_SESSION["votes_produits"]=array();
	if(!isset($_SESSION["votes_partenaires"]))
		$_SESSION["votes_partenaires"]=array();

	if(isset($_GET['controle'])&&isset($_GET['action'])){
		$controle = $_GET['controle'];
		$action = $_GET['action'];
		
		require ("controle/" . $controle . ".php");
		$action();
	}
	else{
		require("controle/accueil.php");
		aff_accueil();
	}
?>