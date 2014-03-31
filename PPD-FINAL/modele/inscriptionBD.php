<?php

function pseudo_unique($pseudo){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errorno());
	
	$pseudoEchappe= mysqli_real_escape_string ($link,$pseudo);
	$sql = "SELECT id_client FROM Client WHERE pseudo_cli = '%s' ";
	$req = sprintf ($sql, $pseudoEchappe);
	$res = mysqli_query($link,$req);
	$nb  = mysqli_num_rows($res);
	mysqli_free_result($res);
	mysqli_close($link);
	if($nb == 0)
		return true;
	return false;
}

function inscrireBD($nom, $prenom, $pseudo, $password, $email, $telephone){
	require("config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());

	$nom_accent= utf8_decode($nom);
	$nom_echappe = mysqli_real_escape_string($link,$nom_accent);
	$prenom_accent= utf8_decode($prenom);
	$prenom_echappe = mysqli_real_escape_string($link,$prenom_accent);
	$pseudo_echappe= mysqli_real_escape_string ($link,$pseudo);
	$password_echappe= mysqli_real_escape_string ($link,$password);
	$password_echappeCrypte = md5($password_echappe);
	$email_echappe= mysqli_real_escape_string ($link,$email);
	$telephone_echappe = mysqli_real_escape_string($link,$telephone);
	$date_inscription = time();
	// PAS DE DATE_LAST_VISITE CAR CELA SE FAIT A LA CONNEXION

	$sql ="	INSERT INTO Client (
			pseudo_cli,
			mdp_cli,
			nom_cli,
			prenom_cli,
			num_tel_cli,
			email_cli,
			date_inscription
			)
			VALUES ('$pseudo_echappe', '$password_echappeCrypte', '$nom_echappe', '$prenom_echappe', '$telephone_echappe', '$email_echappe', '$date_inscription')
		  ";
	mysqli_query($link,$sql);
	mysqli_close($link);		
}
?>