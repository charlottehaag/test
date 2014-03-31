<?php

function connexionAdmin_BD($pseudo,$mdp){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$pseudoEchappe= mysqli_real_escape_string ($link,$pseudo);
	$mdpEchappe = mysqli_real_escape_string($link,$mdp);
	$mdp_echappeCrypte = md5($mdpEchappe);
	$req = "SELECT * FROM Admin WHERE pseudo_admin= '$pseudoEchappe' AND mdp_admin = '$mdp_echappeCrypte' ;";
	$res = mysqli_query($link, $req);
	$nb = mysqli_num_rows($res);
	mysqli_close($link);
	if($nb == 0){
		return false;
	}
	return true;

   
}
?>







