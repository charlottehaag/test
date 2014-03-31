<?php

function get_commentaires_partenaire($id){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//récupère les commentaires associés au partenaire
	$req="SELECT * FROM Commentaire_Part WHERE id_part=$id;";
	$res=mysqli_query($link, $req);
	if($res){
		$tab=mysqli_fetch_all($res, MYSQLI_ASSOC);
		//résultat final
		$liste=array();

		//mise en forme du tableau pour l'affichage 
		foreach($tab as $com_bd){

			//recherche du pseudo de l'auteur
			$id_auteur=$com_bd['id_client'];
			$id_tmp=$com_bd['id_com_part'];
			$req_pseudo="
			SELECT c.pseudo_cli FROM Client c, Commentaire_Part com WHERE com.id_client=c.id_client AND com.id_com_part=$id_tmp;
			";
			$res_pseudo=mysqli_query($link,$req_pseudo);
			$pseudo=mysqli_fetch_all($res_pseudo,MYSQLI_ASSOC);
			$pseudo=$pseudo[0]['pseudo_cli'];

			//on met les infos pertinentes dans le tableau qu'on renvoie
			$liste[]=array(
				'date'=>$com_bd['date_com_part'],
				'contenu'=>$com_bd['contenu_part'],
				'pseudo_auteur'=>$pseudo
				);
		}
		return $liste;
		
	}	
	else return null;
}

function commenter_partenaire_BD($id,$contenu){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
	$date=time();
	$id_cli=$_SESSION['id'];
	$req="INSERT INTO Commentaire_Part (id_client,id_part,contenu_part,date_com_part) VALUES ($id_cli,$id,'$contenu',$date)";
	echo $req;
	mysqli_query($link,$req);
	echo "|OK";
}

function voter_partenaire_BD($id){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	$req="UPDATE Partenaire SET note_partenaire=note_partenaire+1 WHERE id_partenaire=$id";
	mysqli_query($link,$req);
}

//**********************************************************     PRODUIT     *********************************************************

function get_commentaires_produit($id){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//récupère les commentaires associés au produit
	$req="SELECT * FROM commentaire_prod WHERE id_prod=$id;";
	$res=mysqli_query($link, $req);
	if($res){
		$tab=mysqli_fetch_all($res, MYSQLI_ASSOC);
		//résultat final
		$liste=array();

		//mise en forme du tableau pour l'affichage 
		foreach($tab as $com_bd){

			//recherche du pseudo de l'auteur
			$id_auteur=$com_bd['id_client'];
			$id_tmp=$com_bd['id_com_prod'];
			$req_pseudo="
			SELECT c.pseudo_cli FROM Client c, Commentaire_prod com WHERE com.id_client=c.id_client AND com.id_com_prod=$id_tmp;
			";
			$res_pseudo=mysqli_query($link,$req_pseudo);
			$pseudo=mysqli_fetch_all($res_pseudo,MYSQLI_ASSOC);
			$pseudo=$pseudo[0]['pseudo_cli'];

			//on met les infos pertinentes dans le tableau qu'on renvoie
			$liste[]=array(
				'date'=>date('d/m/y',$com_bd['date_com_prod']),
				'contenu'=>$com_bd['contenu_prod'],
				'pseudo_auteur'=>$pseudo
				);
		}
		return $liste;
	}	
	else return null;
}

function commenter_produit_BD($id,$contenu){
	//echo $id."|||".$contenu;
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	$id_cli=$_SESSION['id'];
	$date_com = time();

	$req="INSERT INTO Commentaire_prod (id_client,id_prod,contenu_prod,date_com_prod) VALUES ($id_cli,$id,'$contenu','$date_com')";
	echo $req;
	mysqli_query($link,$req);
	echo "|OK";
}

function voter_produit_BD($id){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	$req="UPDATE Produit SET note_produit=note_produit+1 WHERE id_produit=$id";
	mysqli_query($link,$req);
}

?>