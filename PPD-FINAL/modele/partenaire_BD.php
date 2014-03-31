<?php

function inscrirePart_BD($nom,$adresse,$code,$numero,$email,$mdp, $numero){
	require("modele/config_BD.php");
	//récupération des coordonnées
	//requête
	$link = mysqli_connect($hote, $login, $pass, $bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	//sécurisation
	$nom=mysqli_real_escape_string($link,$nom);
	$mdp=md5($mdp);
	$adresse=mysqli_real_escape_string($link,$adresse);
	$code=mysqli_real_escape_string($link,$code);
	$numero=mysqli_real_escape_string($link,$numero);
	$email=mysqli_real_escape_string($link,$email);

	$req="INSERT INTO Partenaire(nom_part,adresse_part,code_part,num_tel_part,email_part,mdp_part) VALUES('$nom','$adresse','$code','$numero','$email','$mdp')";
	mysqli_query($link,$req);
}

function connexionPart_BD($nompart, $mdp){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$nomPartEchappe= mysqli_real_escape_string ($link,$nompart);
	$mdpEchappe = mysqli_real_escape_string($link,$mdp);
	$mdp_echappeCrypte = md5($mdpEchappe);
	$req = "SELECT * FROM Partenaire WHERE nom_part = '$nomPartEchappe' AND mdp_part = '$mdp_echappeCrypte' ;";
	$res = mysqli_query($link, $req);
	$nb = mysqli_num_rows($res);
	mysqli_close($link);
	if($nb == 0){
		return false;
	}
	return true;
}

function getID($nom){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$nomEchappe= mysqli_real_escape_string ($link,$nom);
	$req = "SELECT id_partenaire FROM Partenaire WHERE nom_part = '$nomEchappe';";
	$res = mysqli_query($link, $req);
	$row=mysqli_fetch_row($res);
	mysqli_free_result($res);
	mysqli_close($link);
	return($row[0]);
}



function verif_nom_BD($nom){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$req="SELECT * FROM Partenaire WHERE nom_part='".$nom."';";
	$res=mysqli_query($link,$req);
	if(mysqli_num_rows($res)==0)
		return true;
	else
		return false;
}


?>