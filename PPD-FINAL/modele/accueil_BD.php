<?php

function connexion_BD($pseudo,$mdp){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$pseudoEchappe= mysqli_real_escape_string ($link,$pseudo);
	$mdpEchappe = mysqli_real_escape_string($link,$mdp);
	$mdp_echappeCrypte = md5($mdpEchappe);
	$req = "SELECT * FROM Client WHERE pseudo_cli = '$pseudoEchappe' AND mdp_cli = '$mdp_echappeCrypte' ;";
	$res = mysqli_query($link, $req);
	$nb = mysqli_num_rows($res);
	mysqli_close($link);
	if($nb == 0){
		return false;
	}
	return true;

   
}
function get_id($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT id_client FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		return $tab['id_client'];
		
		mysqli_free_result($res);
		mysqli_close($link);
	}
	

function setLastVisite($pseudo){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$pseudoEchappe= mysqli_real_escape_string ($link,$pseudo);
	$date_last_visite = time();
	$req = "UPDATE Client SET date_last_visite = $date_last_visite WHERE pseudo_cli = '$pseudoEchappe';";
	$res = mysqli_query($link, $req);
}

function get_all_partenaire(){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "SELECT * FROM Partenaire";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));
	$tab = null;
	while($adr = mysqli_fetch_assoc($res))
		$tab[] = $adr;
	mysqli_close($link);
	if($tab != null)
		return $tab;
	else
		return false;
}

?>









