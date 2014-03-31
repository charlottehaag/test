<?php

function inscription(){
	global $msg;
	$msg =  "Veuillez remplir tous les champs !";
	
		$nom_part = isset($_POST['nom_part'])?$_POST['nom_part']:"";
		$email_part  = isset($_POST['email_part'])?$_POST['email_part']:""; 
		$adresse_part  = isset($_POST['adresse_part'])?$_POST['adresse_part']:""; 
		$code_part  = isset($_POST['code_part'])?$_POST['code_part']:"";
		$numero_part  = isset($_POST['numero_part'])?$_POST['numero_part']:"";
		$password_part  = isset($_POST['password_part'])?$_POST['password_part']:"";
		if(count($_POST) == 0){
			$page="devenir_partenaire";
		}
		else
		{
			require("modele/partenaire_BD.php");
			if(verif_inscription($nom_part,$password_part,$email_part,$code_part,$adresse_part,$numero_part)){
				inscrirePart_BD($nom_part ,$adresse_part ,$code_part ,$numero_part ,$email_part ,$password_part , $numero_part );
				$page="conf_insc_part";
			}else{
				$page="devenir_partenaire";
						print_r($password_part);
				}
		}
		require("vue/pagePrincipale.php");

}



function connexionPart(){
	require("modele/partenaire_BD.php");
	$msg = null;
	$nompart = isset($_POST['nompart']) ? $_POST['nompart'] : "";
	$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : "";
	if(COUNT($_POST) == 0){
		$page="connexionPart";
	}
	else{
		$ok=connexionPart_BD($nompart, $mdp);
		if($ok){
			$page="acc_part";
			$_SESSION['nompart']=$nompart;
			$_SESSION['id_part']=getID($nompart);
			header("Location: index.php?controle=partenaire_cmd&action=aff_acc");
		}
		else{
			$msg="Les donn&eacute;es entr&eacute;es n'ont pas permis de vous identifier";
			$page="connexionPart";
		}
	}
	require("vue/pagePrincipale.php");

}

function verif_inscription($nom, $password, $email, $code, $adresse, $numero){
	global $msg;
	if(verif_format($nom,$password, $email,$code,$adresse,$numero)){
		if(verif_nom_BD($nom))
			return true;
		$msg = "Nom déjà existant";
	}
	return false;
}

function verif_format($nom,$password, $email,$code,$adresse,$numero){
	global $msg;
	if(!preg_match("`^[[:alnum:]éèëïêö]{4,20}$`", $password)){
		$msg = "Erreur de format de votre mot de passe : cha&icirc;ne entre 4 et 20 caract&egrave;res alphanum&eacute;riques";
		return false;
	}
	if(!preg_match("`^[[:alpha:]éèëïêö]{3,20}$`", $nom)){
		$msg = "Erreur de format de votre nom : cha&icirc;ne entre 3 et 20 caract&egrave;res alphab&eacute;tiques";
		return false;
	}
	
	if(!preg_match("`^(.+)@(.+)\.(.+)$`", $email)){
		$msg = "Erreur de format de votre e-mail";
		return false;			
	}
	
	//code 5 chiffres
	if(strlen($code)!=5 ||!preg_match('#[0-9]{5}#',$code)){
		$msg.="- code postal ";
		return false;
	}
	//adresse 4-30
	if(strlen($adresse)<4||strlen($adresse)>30){
		$msg.="- adresse ";		
		return false;

	}
	//numero 10 chiffres
	if(strlen($numero)!=10||!preg_match('#[0-9]{10}#',$numero)){
		$msg.="- numero de t&eacute;l&eacute;phone ";
		return false;
	}
	return true;
}

function verifNomUnique(){
	$nom_part = $_POST['nom_part'];
	if(nom_unique($nom_part))
		echo 'true';
	else
		echo 'false';
}

?>