<?php
//renvoi le nom du pseudo	
function get_nom($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT nom_cli FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		return $tab['nom_cli'];
		
		mysqli_free_result($res);
		mysqli_close($link);
	}
	
//renvoi le prenom du pseudo
function get_prenom($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT prenom_cli FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		return $tab['prenom_cli'];
		
		mysqli_free_result($res);
		mysqli_close($link);
	}

//renvoi le telephone du pseudo
function get_telephone($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT num_tel_cli FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		return $tab['num_tel_cli'];
		
		mysqli_free_result($res);
		mysqli_close($link);
	}

//renvoi l'email du pseudo
function get_email($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT email_cli FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		return $tab['email_cli'];
		
		mysqli_free_result($res);
		mysqli_close($link);
	}
	
//renvoi la date d'inscription du pseudo
function get_date($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT date_inscription FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		$date = date('d/m/y', $tab['date_inscription']);
		return $date;
		
		mysqli_free_result($res);
		mysqli_close($link);
	}

//renvoi la dernière date de connexion du pseudo
function get_last_date($pseudo){
		require("modele/config_BD.php");
		$link = mysqli_connect($hote, $login, $pass,$bd);
		if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
		
		$req="SELECT date_last_visite FROM Client c WHERE c.pseudo_cli='".$pseudo."';";
		$res=mysqli_query($link,$req);
		$tab=mysqli_fetch_assoc($res);
		$last_date =  date('d/m/y',$tab['date_last_visite']);
		return $last_date;
		
		mysqli_free_result($res);
		mysqli_close($link);
	}

//renvoi le nombre de commandes passées du pseudo
function get_nb_commande($pseudo){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	
	$req="SELECT * FROM Client c,Commande co WHERE c.pseudo_cli='".$pseudo."' AND co.id_client= c.id_client";
	$res=mysqli_query($link,$req);
	
	return mysqli_num_rows($res);;
	
	mysqli_free_result($res);
	mysqli_close($link);
	
}

//enregistre la modification du pseudo dans la BD
function enregistrer_modif_pseudo_BD($pseudo,$id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$pseudo_echappe= mysqli_real_escape_string ($link,$pseudo);
	$req="UPDATE Client SET pseudo_cli='".$pseudo_echappe."',id_client='".$id."' WHERE id_client='".$id."' ;";
	$res=mysqli_query($link,$req);
	
	return $res;
	
	mysqli_free_result($res);
	mysqli_close($link);
}

//enregistre la modification du numero de telephone dans la BD
function enregistrer_modif_tel_BD($telephone,$id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$telephone_echappe = mysqli_real_escape_string($link,$telephone);
	$req="UPDATE Client SET num_tel_cli='".$telephone_echappe."' WHERE id_client='".$id."' ;";
	$res=mysqli_query($link,$req);
	
	return $res;
	mysqli_free_result($res);
	mysqli_close($link);
}

//enregistre la modification de l'email dans la BD
function enregistrer_modif_email_BD($email,$id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$email_echappe= mysqli_real_escape_string ($link,$email);
	$req="UPDATE Client SET email_cli='".$email_echappe."' WHERE id_client='".$id."' ;";
	$res=mysqli_query($link,$req);
	
	return $res;
	mysqli_free_result($res);
	mysqli_close($link);
}

//enregistre la modification du mot de passe dans la BD
function enregistrer_modif_mdp_BD($mdp,$id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	$mdp_echappe= mysqli_real_escape_string ($link,$mdp);
	$mdp_echappeCrypte = md5($mdp_echappe);
	$req="UPDATE Client SET mdp_cli='".$mdp_echappeCrypte."' WHERE id_client='".$id."' ;";
	$res=mysqli_query($link,$req);
	
	return $res;
	mysqli_free_result($res);
	mysqli_close($link);
}

//supprime le compte de la BD
function supp_compte_BD($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	
	$req="DELETE FROM Client WHERE id_client='".$id."';";
	$res=mysqli_query($link,$req);
	
	return $res;
	mysqli_free_result($res);
	mysqli_close($link);
	}


function verif_pseudo_unique_BD($pseudo){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass,$bd);
	if(!$link) die ("erreur de connexion :" . mysqli_connect_errno());
	
	$pseudoEchappe= mysqli_real_escape_string ($link,$pseudo);
	$sql = "SELECT id_client FROM Client WHERE pseudo_cli = '$pseudoEchappe' ";
	$req = sprintf ($sql, $pseudoEchappe);
	$res = mysqli_query($link,$req);
	$nb  = mysqli_num_rows($res);
	mysqli_free_result($res);
	mysqli_close($link);
	if($nb == 0)
		return true;
	return false;
}
?>