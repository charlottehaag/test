<?php

require("modele/commande_BD.php");


global $PRIX_MENU;
$PRIX_MENU=1.50;

/****************************************************************      FONCTIONS AFFICHAGE       ****************************************************************/

function aff_pdv(){
	$tab_partenaire = get_all_partenaire();
	$page='pdv';
	require("vue/pagePrincipale.php");
}

function aff_choix_menu(){
	if(isset($_SESSION["pseudo"])){
		//choix de menu ou non
		$page="choix_menu";
		require("vue/pagePrincipale.php");
	}
	else{
		$page="besoin_connexion";
		require("vue/pagePrincipale.php");
	}
}

function aff_possibilites_commande(){
	$page="possibilites_commande";
	require("vue/pagePrincipale.php");
}

//effectue les ajustement nécessaires des variables si incohérences (survenues par l'interruption de scénarios)
function check_panier(){

	//Si interruption du scénario de commande en cours de route, remet à 0 les commandes :
	if(!isset($_SESSION['choix_lieu'])){
		if(isset($_SESSION['pseudo'])&&isset($_SESSION['id'])){
			$pseudo_client = $_SESSION['pseudo'];
			$id_client = $_SESSION['id'];
		}
		session_unset();
		if(isset( $id_client)&&isset($pseudo_client)){
			$_SESSION['id'] =$id_client;
			$_SESSION['pseudo'] = $pseudo_client;
		}
	}

	//si listes panier vide on les désalloue
	if(isset($_SESSION['choix_ingredients'])){
		if(count($_SESSION['choix_ingredients'])==0)
			$_SESSION['choix_ingredients']=null;
	}
	if(isset($_SESSION['choix_produits'])){
		if(count($_SESSION['choix_produits'])==0)
			$_SESSION['choix_produits']=null;
	}
	if(isset($_SESSION['choix_menus'])){
		if(count($_SESSION['choix_menus'])==0)
			$_SESSION['choix_produits']=null;
	}

	//si panier vide on vérifie que choix_lieu est désallouée
	if(panierVide()&&isset($_SESSION['choix_lieu']))
		$_SESSION['choix_lieu']=null;
}

function panierVide(){
	if(isset($_SESSION['choix_produits'])&&count($_SESSION['choix_produits'])>0)
		return false;
	if(isset($_SESSION['choix_ingredients'])&&count($_SESSION['choix_ingredients'])>0)
		return false;
	if(isset($_SESSION['choix_menus'])&&count($_SESSION['choix_menus'])>0)
		return false;
	else return true;
}

function aff_commandes(){

	check_panier();
	
	//raf : charger les commandes pas encore retirées
	
	global $PRIX_MENU;
	
	$verrou=estVerrouille();

	//si produits commandés
	if(isset($_SESSION['choix_produits'])&&count($_SESSION['choix_produits'])>0){
		//charge les infos des produits dans le panier
		$liste_produits=get_liste_produits_by_ids($_SESSION['choix_produits']);
		//compteur de produit
		$cpt=0;
		//ajout des prix
		foreach($liste_produits as $produit){
			//récupère les ingrédients
			$tab_ingr=get_ingredients_produit($_SESSION['choix_produits'][$cpt][0]);
			//récupère la somme du prix
			$_SESSION['choix_produits'][$cpt]['prix']=getPrixProduit($tab_ingr);
			$liste_produits[$cpt]['ingredients']=get_lib_ingredients_produit($produit['id_produit']);
			$cpt++;
		}
				
	}

	//si commandés par ingrédients
	if(isset($_SESSION['choix_ingredients'])&&count($_SESSION['choix_ingredients'])>0){
		//charge les infos des ingredients dans le panier
		$liste_ingredients=get_liste_ingredients_by_ids($_SESSION['choix_ingredients']);

		$cpt=0;
		foreach($_SESSION['choix_ingredients'] as $groupe){
			//récupère la somme du prix
			$_SESSION['choix_ingredients'][$cpt]['prix']=getPrixProduit($groupe[0]);
			$cpt++;
		}
	}

	//si menus commandés
	if(isset($_SESSION['choix_menus'])&&count($_SESSION['choix_menus'])>0){
		$liste_menus=array();
		//compteur
		$tmp=0;

		//pour chaque menu commandé
		foreach($_SESSION['choix_menus'] as $menu){
			//conversion boisson et dessert :
			$liste_menus[$tmp][0]=get_boisson_by_id($menu[0]);
			$liste_menus[$tmp][1]=get_dessert_by_id($menu[1]);

			//si menu avec tableau d'ingrédients
			if(isset($menu[2]) && count($menu[2])>1){
				//remplace chaque id ingr par son libelle
				foreach($menu[2] as $id_ingr)
					$liste_menus[$tmp][2][]=get_ingredient_by_id($id_ingr);
				//ajout du prix
				$_SESSION['choix_menus'][$tmp]['prix']=getPrixProduit($_SESSION['choix_menus'][$tmp][2]);
				$_SESSION['choix_menus'][$tmp]['prix']+=$PRIX_MENU;
			}

			//si menus avec produit
			else{
				$liste_menus[$tmp][2]=get_produit_by_id($menu[2]);
				//ajout du prix
				$_SESSION['choix_menus'][$tmp]['prix']=getPrixProduit(get_ingredients_produit($_SESSION['choix_menus'][$tmp][2]));
				$_SESSION['choix_menus'][$tmp]['prix']+=$PRIX_MENU;
				$liste_menus[$tmp]['ingredients']=get_lib_ingredients_produit($menu[2]);
			}

			//quantite
			$liste_menus[$tmp][3]=$menu[3];

			$tmp++;
		}
	}

	//si quelque chose dans le panier
	if(!panierVide())
		$prix_total=calculerPrixTotal();

	//chargement de la page mes commandes (panier+commandes en cours)
		/*header("Location:index.php?controle=commande&action=aff_cmd_non_retire_cli");*/
	
	$idcli = $_SESSION['id'];
	$tab_comm_client = get_commande_non_retire_client($idcli);
	$page="mes_commandes";
	require("vue/pagePrincipale.php");
}


/*************************************************************************     FONCTIONS CHOIX         *********************************************************/


//si menu
function choisir_boisson_dessert(){
	if(!estVerrouille()){
		$msg = null;
		if(!isset($_POST['boisson'])&&!isset($_POST['dessert'])){//n'a pas encore choisi
			//chargement des listes à afficher
			$liste_boissons=get_liste_produits("boisson");
			$liste_desserts=get_liste_produits("dessert");

			$page="choix_boisson_dessert";
			require("vue/pagePrincipale.php");
		}
		else if(isset($_POST['boisson'])&& isset($_POST['dessert'])){//a choisi
			//enregistrement de ses choix dans la variable session (on ne passera les infos dans le panier en tant que menu entièrement constitué plus tard)
			$_SESSION['choix_boisson']=$_POST['boisson'];
			$_SESSION['choix_dessert']=$_POST['dessert'];
			$_SESSION['quantite_menu']=$_POST['quantite'];

			//affichage étape suivante : types de commande possibles(par lieu de préparation, produit ou prédéfini)
			aff_possibilites_commande();
		}
		else{
			$msg = 'Vous devez choisir une boisson et un dessert';
			//chargement des listes à afficher
			$liste_boissons=get_liste_produits("boisson");
			$liste_desserts=get_liste_produits("dessert");
			$page="choix_boisson_dessert";
			require("vue/pagePrincipale.php");
		}
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}


function choisir_produit(){
	if(!estVerrouille()){
		if(!isset($_SESSION['choix_produits']))//initialise le tableau qui recevra les produits dans la session si pas déjà fait
			$_SESSION['choix_produits']=array();
		if(isset($_SESSION['quantite_menu']) && !isset($_SESSION['choix_menus']))//initialise le tableau qui recevra les menus dans la session s'il y a lieu si pas déjà fait
			$_SESSION['choix_menus']=array();	

		if(!isset($_POST['choix_produit'])){//si pas encore choisi on affiche la page de choix
			$liste_produits=get_liste_produits("Sandwich");
			$page="choix_produit";
			require("vue/pagePrincipale.php");
		}//si choisis on stocke dans la variable session et on redirrige vers la map
		else{
			//stockage sous forme de tableau 2d
			$produit_comm=$_POST['choix_produit'];
			//si pas de menu on stocke dans chaque case du tableau de la session concerné le couple (produit,quantité)
			if(!isset($_SESSION['choix_boisson'])&&!isset($_SESSION['choix_dessert'])){
				
				//position du produit dans panier (si innexistant, -1)
				$pos=produit_dans_panier($produit_comm);
				echo($pos);
				
				//si existe déjà on incrémente la quantité du produit déjà commandé
				if($pos!=-1)
					$_SESSION['choix_produits'][$pos][1]++;
				//sinon on le stocke dans le panier de la session
				else
					$_SESSION['choix_produits'][]=array($produit_comm,$_POST['quantite']);
			}
			//si menu on stocke dans le tableau des menus commandés
			else{
				//on met la boisson le dessert et les ingrédients et la quantité de menus dans un tableau dans la son
				$_SESSION['choix_menus'][]=array($_SESSION['choix_boisson'],$_SESSION['choix_dessert'],$produit_comm,$_SESSION['quantite_menu']);
				//on désalloue choix_boisson et choix_dessert
				$_SESSION['choix_boisson']=null;
				$_SESSION['choix_dessert']=null;
				$_SESSION['quantite_menu']=null;
			}
			
			header("Location:index.php?controle=commande&action=choisir_lieu");
		}
	}

	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function choisir_ingredients(){
	//on vérifie que le client est connecté
	if(isset($_SESSION['id'])){
		if(!estVerrouille()){

			if(!isset($_SESSION['choix_ingredients']))//initialise le tableau qui recevra les ingrédients dans la session si pas déjà fait
				$_SESSION['choix_ingredients']=array();
			if(isset($_SESSION['quantite_menu']) && !isset($_SESSION['choix_menus']))//initialise le tableau qui recevra les menus dans la session si pas déjà fait
				$_SESSION['choix_menus']=array();

			//sert à pouvoir effectuer le test même au premier affichage (sinon not initialized) 
			if(!isset($_POST['ingredient']) || count($_POST['ingredient']) != 3 ){
				$_POST['ingredient1']="";
				$_POST['ingredient2']="";
				$_POST['ingredient3']="";
			}
			else{
				$_POST['ingredient1']= $_POST['ingredient'][0] ;
				$_POST['ingredient2']= $_POST['ingredient'][1] ;
				$_POST['ingredient3']= $_POST['ingredient'][2] ;
			}

			//si aucun choisi on affiche la page de choix
			if(($_POST['ingredient1']==""&& $_POST['ingredient2']==""&&$_POST['ingredient3']=="")){
				
				//charge la liste des ingrédients

				//si aucun lieu choisi : tous les ingrédients
				if(!isset($_SESSION['choix_lieu']))
					$liste_ingredients=get_liste_ingredients();
				//sinon : les ingrédients proposés par le lieu
				else
					$liste_ingredients=get_liste_ingredients_by_lieu($_SESSION['choix_lieu']);

				$page="choix_ingredients";
				require('vue/pagePrincipale.php');
			}
			else{//sinon on stocke dans la session et on amène à la page de choix du lieu
				
				$produit_comm = array();
				foreach ($_POST['ingredient'] as $ingr) {
					$produit_comm[] = $ingr;
				}

				//si pas de menu
				if(!isset($_SESSION['choix_boisson'])&&!isset($_SESSION['choix_dessert']))
					$_SESSION['choix_ingredients'][]=array($produit_comm,$_POST['quantite']);

				//si menu on stocke dans le tableau des menus commandés
				else{
					//on met la boisson le dessert et les ingrédients et la quantité de menus dans un tableau dans la session
					$_SESSION['choix_menus'][]=array($_SESSION['choix_boisson'],$_SESSION['choix_dessert'],$produit_comm,$_SESSION['quantite_menu']);
					//on désalloue choix_boisson et choix_dessert
					$_SESSION['choix_boisson']=null;
					$_SESSION['choix_dessert']=null;
					$_SESSION['quantite_menu']=null;
				}

				//si on n'a pas encore de lieu choisi, on va sur la carte
				if(!isset($_SESSION['choix_lieu']))
					header("Location:index.php?controle=commande&action=choisir_lieu");
				//sinon on va sur le panier pour récapituler la commande
				else
					header("Location:index.php?controle=commande&action=aff_commandes");
			}
		}

		else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
		}
	}
	else{
		$page="besoin_connexion";
		require("vue/pagePrincipale.php");
	}
}

function choisir_lieu(){
	if(!estVerrouille()){
		//si pas encore choisi on affiche la page de choix
		if(!isset($_GET['choix_lieu'])&&!isset($_SESSION['choix_lieu'])){
			

			/****************détermine si contrainte d'ingrédient************************/
			//booléens si ingrédients personnalisés déjà choisis ou pas
			$ingredients_choisis=false;
			$ingredients_menu_choisis=false;
			//pour produit seul
			if(isset($_SESSION['choix_ingredients']))
				$ingredients_choisis=true;
			//pour menu
			if(isset($_SESSION['choix_menus'])){
				foreach($_SESSION['choix_menus'] as $menu){
					if(count($menu[2])>1)
						$ingredients_menu_choisis=true;
				}
			}
			/****************agit selon contrainte d'ingrédient************************/

			//si acucune contrainte d'ingrédients
			if(!$ingredients_choisis&&!$ingredients_menu_choisis){
				$tab_code_postal = get_code_part();
			}
			//si choix par ingrédient (forcément premier choix)
			else{
				//si ingrédients pour menu seul
				if($ingredients_choisis&&!$ingredients_menu_choisis)
					$tab_code_postal = get_liste_partenaire_by_ingredients($_SESSION['choix_ingredients'][0][0]);
				//sinon c'est dans un menu
				else{
					$tab_code_postal = get_liste_partenaire_by_ingredients($_SESSION['choix_menus'][0][2]);
				}
			}

			$page="map_code_postal";
			require("vue/pagePrincipale.php");
		}
		//si choix défini
		else {
			//si il vient de choisir on stocke le choix
			if(!isset($_SESSION['choix_lieu'])||count($_SESSION['choix_lieu'])<=0)
				$_SESSION['choix_lieu']=$_GET['choix_lieu'];
			//et on amène à la page choix ingrédients si pas d'ingrédients/produit séléctionné
			if(!isset($_SESSION['choix_produits'])&&!isset($_SESSION['choix_ingredients'])&&count($_SESSION['choix_produits'])<=0 && count($_SESSION['choix_ingredients'])<=0)
				header("Location:index.php?controle=commande&action=choisir_ingredients");
			//sinon page mes commandes
			else
				header("Location:index.php?controle=commande&action=aff_commandes");
		}	
	}

	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}

}



/***********************************************************************   CARTE CP   *************************************************************************/

// NOUVEAU 10/03

function get_partenaire_code_postal(){
	$code_postal = isset($_POST['code_postal'])?$_POST['code_postal']:"";
	$tab_part = get_partenaire($code_postal);
	echo(json_encode($tab_part));
}

/***********************************************************************   PRIX TOTAL   *************************************************************************/

function calculerPrixTotal(){
	//résultat
	$total=0;

	//sous-total temporaire par type de commande
	$tmp;

	$tmp=0;
	//prix total des produits
	if(isset($_SESSION['choix_produits'])){
		foreach($_SESSION['choix_produits'] as $produit){
			$tmp+=($produit['prix']*$produit[1]);
		}
		$total+=$tmp;
		$tmp=0;
	}

	//prix total des par ingrédients
	if(isset($_SESSION['choix_ingredients'])){
		foreach($_SESSION['choix_ingredients'] as $produit){
			$tmp+=($produit['prix']*$produit[1]);
		}
		$total+=$tmp;

		$tmp=0;
	}

	//prix total des menus
	if(isset($_SESSION['choix_menus'])){	
		foreach($_SESSION['choix_menus'] as $menu){
			$tmp+=($menu['prix']*$menu[3]);
		}
		$total+=$tmp;
		}
	return $total;
}

/***********************************************************************   MODIFS QTE   *************************************************************************/

function produit_dans_panier($id){
	//position du produit choisi dans les produits déjà commandés, sinon -1
	$pos=-1;

	//indice de l'élément analysé
	$i=0;

	foreach($_SESSION['choix_produits'] as $produit){
		if($produit[0]==$id)
			$pos=$i;
		++$i;
	}
	return $pos;
}

function inc_qte_produit(){
	if(!estVerrouille()){
		//incrémente le produit choisi
		$ind=$_GET['ind'];
		++$_SESSION['choix_produits'][$ind][1];

		//à enlever si ajax
		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function inc_qte_menu(){
	if(!estVerrouille()){
		//incrémente le menu choisi
		$ind=$_GET['ind'];
		++$_SESSION['choix_menus'][$ind][3];

		//à enlever si ajax
		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function inc_qte_ingredient(){
	if(!estVerrouille()){
		//incrémente le groupe d'ingrédients choisi
		$ind=$_GET['ind'];
		++$_SESSION['choix_ingredients'][$ind][1];

		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function dec_qte_produit(){
	if(!estVerrouille()){
		//décrémente le produit choisi
		$ind=$_GET['ind'];
		--$_SESSION['choix_produits'][$ind][1];

		//si il n'y a plus d'ingrédients : on l'enlève de la liste
		if($_SESSION['choix_produits'][$ind][1]<=0){
			array_splice($_SESSION['choix_produits'],$ind,1);
			//désalloue la variable si plus rien dedans
			if(!count($_SESSION['choix_produits'])>0)
				$_SESSION['choix_produits']=null;
		}
		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function dec_qte_menu(){
	if(!estVerrouille()){
		//décrémente le produit choisi
		$ind=$_GET['ind'];
		--$_SESSION['choix_menus'][$ind][3];

		//si il n'y a plus d'ingrédients : on l'enlève de la liste
		if($_SESSION['choix_menus'][$ind][3]<=0){
			array_splice($_SESSION['choix_menus'],$ind,1);
			//désalloue la variable si plus rien dedans
			if(!count($_SESSION['choix_menus'])>0)
				$_SESSION['choix_menus']=null;
			if(!count($_SESSION['choix_ingredients'])>0)
				$_SESSION['choix_ingredients']=null;
			if(!count($_SESSION['choix_produits'])>0)
				$_SESSION['choix_produits']=null;
		}
		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}

function dec_qte_ingredient(){
	if(!estVerrouille()){
		//décrémente le produit choisi
		$ind=$_GET['ind'];
		--$_SESSION['choix_ingredients'][$ind][1];

		//si il n'y a plus d'ingrédients : on l'enlève de la liste
		if($_SESSION['choix_ingredients'][$ind][1]<=0){
			array_splice($_SESSION['choix_ingredients'],$ind,1);
			//désalloue la variable si plus rien dedans
			if(!count($_SESSION['choix_ingredients'])>0)
				$_SESSION['choix_ingredients']=null;
		}

		header("Location:index.php?controle=commande&action=aff_commandes");
	}
	else{
		$page="mes_commandes";
		require("vue/pagePrincipale.php");
	}
}


/*****************************   GESTION PANIER   **************************************************************************************************************/

function vider_panier(){
	$pseudo_client = $_SESSION['pseudo'];
	$id_client = $_SESSION['id'];
	session_unset();
	$_SESSION['id'] = $id_client;
	$_SESSION['pseudo'] = $pseudo_client;
	header('Location:index.php?controle=commande&action=aff_commandes');
}

function valider_commande(){
	//verrouille le panier
	$_SESSION['verrou'] = "ok";

	//stockera les ids des produits (prédéfinis et ingrédients) commandés
	$tab_ids_produits=array();
	//stockera les id des produits commandés
	$tab_ids_menus=array();


	//enregistre la commande dans la BD ****************************************************************
	//si produits prédéfini seuls
	if(isset($_SESSION['choix_produits'])&&count($_SESSION['choix_produits'])>0)
		$tab_ids_produits=get_id_predefinis_BD($_SESSION['choix_produits']);
	//si produit par ingrédients seul
	if(isset($_SESSION['choix_ingredients'])&&count($_SESSION['choix_ingredients'])>0)
		$tab_tmp=enregistrer_ingredients_BD($_SESSION['choix_ingredients']);

	//recopie $tab_tmp dans $tab_ids_produits
	if(isset($tab_tmp)&&count($tab_tmp)>0){
		foreach($tab_tmp as $poste)
			$tab_ids_produits[]=$poste;
		}

	//si menu
	if(isset($_SESSION['choix_menus']))
		$tab_ids_menus=enregistrer_menus_BD($_SESSION['choix_menus']);

	//raf : fonction pour récupréer id lieu par le nom
	enregistrer_commande_BD($_SESSION['choix_lieu'],$_SESSION['id'],$tab_ids_produits,$tab_ids_menus);
	//enregistrement fait  *****************************************************************************



	//redirrige vers les commandes
	header("Location:index.php?controle=commande&action=vider_panier");
}

function estVerrouille(){
	if(!isset($_SESSION['verrou']))
		return false;
	if($_SESSION['verrou'] == "ok")
		return true;
	else
		return false;
}

/*pour les commandes non retirées*/
function aff_cmd_non_retire_cli(){

}
/***********************************************************************************************************************************************************/
?>