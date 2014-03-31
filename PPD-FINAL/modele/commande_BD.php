<?php

function get_liste_produits($type){
	//importe les variables de connexion
	require("modele/config_BD.php");

	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//requête
	$req="SELECT p.id_produit,p.libelle_prod,p.note_produit FROM Produit p, Type t WHERE t.nom_type='".$type."' AND p.id_type=t.id_type AND p.est_predefini=1;";

	//execution
	$res=mysqli_query($link,$req);

	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);

	return $tab;
}

function get_liste_ingredients(){
	//importe les variables de connexion
	require("modele/config_BD.php");

	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//requête
	$req="SELECT id_ingredient, libelle_ingr FROM Ingredient;";

	//execution
	$res=mysqli_query($link,$req);

	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);

	return $tab;
}

function get_liste_produits_by_ids($tab_ids){
	//importe les variables de connexion
	require("modele/config_BD.php");

	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//requête de base
	$req="SELECT libelle_prod, id_produit,note_produit FROM produit WHERE ";
	
	//compteur pour savoir si dernier élément ou pas
	$i=0;

	//requête complète
	foreach($tab_ids as $id){//pour chaque id
		//on ajoute id[0] (id[1] étant la quantité)
		$req.="id_produit=".$id[0];
		//si pas le dernier on ajoute OR, sinon ;
		if(++$i<count($tab_ids))
			$req.=" OR ";
		else
			$req.=";";
	}

	//execution
	$res=mysqli_query($link,$req);

	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);

	return $tab;
}



function get_liste_ingredients_by_ids($choix_ingr){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//compteur de groupe d'ingrédients
	$i=0;

	//tableau des résultats de form finale [0](ingr1,ingr2,ingr3)[1](ingr1,ingr2,ingr3)
	$tab=array();

	//tampon avant de mettre dans le tableau de résultat final exploitable en php
	$tmp;
	//pour chaque groupe d'ingrédient(=produit composé)
	foreach($choix_ingr as $cmd){
		//pour chaque ingrédient
		foreach($cmd[0] as $id){
			if($id!=""){
				$req="SELECT libelle_ingr FROM ingredient WHERE id_ingredient=".$id.";";
				//execution
				$res=mysqli_query($link,$req);
				//on ajoute le résultat exploitable dans le prochain poste du tableau
				$tmp=mysqli_fetch_row($res);
				$tab[$i][]=$tmp[0];
			}
		}
		++$i;
	}
	
	return $tab;
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


function get_liste_ingredients_by_lieu($nom_lieu){
	//importe les variables de connexion
	require("modele/config_BD.php");
	
	$nom_lieu =str_replace('"','',$nom_lieu);
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//requête
	$req="SELECT i.id_ingredient, i.libelle_ingr FROM Ingredient i, Stocke s, Partenaire part 
		  WHERE s.id_ingredient=i.id_ingredient 
		  AND s.id_partenaire=part.id_partenaire 
		  AND part.est_dispo=1
		  AND part.nom_part='$nom_lieu';";

	//execution
	$res=mysqli_query($link,$req);

	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
	return $tab;
}

function get_liste_partenaire_by_ingredients($tab_ids){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "SELECT DISTINCT(p.code_part) 
		FROM Partenaire p
		INNER JOIN Stocke s
		     ON p.id_partenaire = s.id_partenaire
		INNER JOIN Ingredient i
		     ON i.id_ingredient = s.id_ingredient
		WHERE i.id_ingredient IN ($tab_ids[0], $tab_ids[1], $tab_ids[2])
		AND p.est_dispo=1
		GROUP BY p.code_part
		HAVING COUNT(DISTINCT i.id_ingredient) = 3
		";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));
	$tab = null;
	$tab = mysqli_fetch_all($res, MYSQLI_NUM);
	mysqli_close($link);
	if($tab != null)
		return $tab;
	else
		return false;
}

//RAF remplacer contrainte ingrédient
function get_partenaire($code_postal){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req;


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

	if($ingredients_choisis || $ingredients_menu_choisis){
		//si ingrédients dans produit
		if($ingredients_choisis&&!$ingredients_menu_choisis){
			//tableau des ids des ingrédients
			$tab_ids=$_SESSION['choix_ingredients'][0][0];
		}
		//sinon dans menu
		else{
			$tab_ids=$_SESSION['choix_menus'][0][2];
		}	

		$req = "SELECT p.*
			FROM Partenaire p
			INNER JOIN Stocke s
				 ON p.id_partenaire = s.id_partenaire
			INNER JOIN Ingredient i
				 ON i.id_ingredient = s.id_ingredient
			WHERE i.id_ingredient IN ($tab_ids[0], $tab_ids[1], $tab_ids[2]) AND p.code_part = $code_postal
			GROUP BY p.code_part
			HAVING COUNT(DISTINCT i.id_ingredient) = 3
			";
	}else{
			$req = "SELECT p.*
			FROM Partenaire p
			WHERE code_part = '$code_postal'
			";
	}
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
	$tab = false;		
}
	
function get_code_part(){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "SELECT DISTINCT(code_part) FROM Partenaire GROUP BY Partenaire.id_partenaire";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));
	$tab = mysqli_fetch_all($res, MYSQLI_NUM);
	return $tab;
}

/******************************************************   REQUETES SIMPLES POUR MENU      *************************************************************/

function get_boisson_by_id($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "SELECT libelle_prod FROM Produit WHERE id_produit=$id;";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));
	$tab = mysqli_fetch_row($res);
	return $tab[0];
}

function get_dessert_by_id($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);

	$req = "SELECT libelle_prod FROM Produit WHERE id_produit=$id;";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));

	$tab = mysqli_fetch_row($res);
	return $tab[0];
}

function get_ingredient_by_id($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);

	$req = "SELECT libelle_ingr FROM Ingredient WHERE id_ingredient=$id;";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));

	$tab = mysqli_fetch_row($res);
	return $tab[0];
}

function get_produit_by_id($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);

	$req = "SELECT libelle_prod FROM Produit WHERE id_produit=$id;";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));

	$tab = mysqli_fetch_row($res);
	return $tab[0];
}

/*************************************************************************** UTILE POUR PRIX *******************************************************************/

function get_ingredients_produit($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);

	$tab = array();

	$req = "SELECT i.id_ingredient FROM Ingredient i, Produit p, Composition c WHERE c.id_ingredient=i.id_ingredient AND p.id_produit=c.id_produit AND p.id_produit=".$id.";";
	$res = mysqli_query($link, $req)
	or die (mysqli_error($link));

	$res_assoc=mysqli_fetch_all($res,MYSQLI_ASSOC);

	foreach($res_assoc as $row){
		$tab[]=$row['id_ingredient'];
	}
	return $tab;
}	

function get_lib_ingredients_produit($id){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);
	$req = "SELECT i.libelle_ingr FROM Ingredient i, Produit p, Composition c WHERE c.id_ingredient=i.id_ingredient AND p.id_produit=c.id_produit AND p.id_produit=".$id.";";
	$res = mysqli_query($link, $req)
		or die (mysqli_error($link));

	//initialise la chaine de retour
	$chaine="";

	//compteur pour virgule
	$cpt=0;
	while($row=mysqli_fetch_row($res)){
		$chaine.=$row[0];
		if($cpt<mysqli_num_rows($res)-1)
			$chaine.=", ";
		$cpt++;
	}
	return $chaine;
}	

function getPrixProduit($ids){
	require("modele/config_BD.php");
	$link = mysqli_connect($hote, $login, $pass, $bd);

	$prix=0;

	foreach($ids as $id){
		$req = "SELECT prix_ingr FROM Ingredient i WHERE i.id_ingredient=".$id.";";
		$res = mysqli_query($link, $req)
		or die (mysqli_error($link));

		$ass=mysqli_fetch_row($res);
		$prix+=$ass[0];
	}

	return $prix;
}

/***************************************************************      ENREGISTREMENT COMMANDE     **************************************************************/

function get_id_predefinis_BD($liste_produits_session){
	//tableau de résultat
	$tab=array();

	//ne récupère que les ids des produits
	foreach($liste_produits_session as $elem){
		$tab[]=array($elem[0],$elem[1]);
	}

	return $tab;
}

function enregistrer_ingredients_BD($liste_ingres_session){
	//tableau de ids des produits crées
	$tab=array();

	foreach($liste_ingres_session as $poste){
		//enregistre le produit dans bd et dans tab de retour ***************
		//importe les variables de connexion
		require("modele/config_BD.php");
		//connecte à la base de données
		$link=mysqli_connect($hote,$login,$pass,$bd);
		if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
		//insertion du produit
		$req="
		INSERT INTO Produit(libelle_prod,id_type,est_predefini)
		VALUES('creation',1,0)
		;
		";
		mysqli_query($link,$req);

		//récupère l'id du dernier insert (le produit)
		$id_prod=mysqli_insert_id($link);
		if($id_prod!=0){
			$tab[]=array($id_prod,$poste[1]);
		}
		//*******************************************************************

		//insertion des table composition (une pour chaque produit)**********
		foreach($poste[0] as $id_ingr){
			$req="
			INSERT INTO Composition(id_ingredient,id_produit)
			VALUES($id_ingr,$id_prod)
			;
			";
			mysqli_query($link,$req);
		}

		//********************************************************************
	}
	return $tab;
}

function enregistrer_menus_BD($liste_menus_session){
	//tableau de ids des menus crées
	$tab=array();

	foreach($liste_menus_session as $poste){
		//enregistre le menu dans bd et dans tab de retour ******************
		//importe les variables de connexion
		require("modele/config_BD.php");
		//connecte à la base de données
		$link=mysqli_connect($hote,$login,$pass,$bd);
		if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
		//récupère le prix
		$prix=$poste["prix"];
		//insertion du menu
		$req="
		INSERT INTO Menu(prix_menu)
		VALUES($prix)
		;
		";
		mysqli_query($link,$req);
		//récupère l'id du dernier insert (le menu)
		$id_menu=mysqli_insert_id($link);
		if($id_menu!=0){
			//gère la quantité ($poste[3] = qté)		
			$tab[]=array($id_menu,$poste[3]);
		}
		//*******************************************************************

		//insertion des table composition (une pour chaque produit)**********
		//boisson
		$req="
		INSERT INTO Comporter(id_menu,id_produit)
		VALUES($id_menu,$poste[0])
		;";
		mysqli_query($link,$req);
		//dessert
		$req="
		INSERT INTO Comporter(id_menu,id_produit)
		VALUES($id_menu,$poste[1])
		;";
		mysqli_query($link,$req);

		//si par ingrédients
		if(count($poste[2])>1){
			$req="
			INSERT INTO Produit(libelle_prod,id_type,est_predefini)
			VALUES('creation',1,0)
			;
			"
			;
			mysqli_query($link,$req);
			$id_prod=mysqli_insert_id($link);
			foreach($poste[2] as $id_ingr){
				$req="
				INSERT INTO Composition(id_ingredient,id_produit)
				VALUES($id_ingr,$id_prod)
				;
				";
				mysqli_query($link,$req);
			}

			//insère le produit dans le menu
			$req="
			INSERT INTO Comporter(id_menu,id_produit)
			VALUES($id_menu,$id_prod)
			;";
			mysqli_query($link,$req);
			echo "req : ".$req;
			echo "res : ".mysqli_insert_id($link);
		}

		//si par produit prédéfini
		else{
			//récupère l'id produit
			$id_prod=$poste[2];
			$req="
			INSERT INTO Comporter(id_menu,id_produit)
			VALUES($id_menu,$id_prod)
			;";
			mysqli_query($link,$req);
		}
		//********************************************************************
	}
	return $tab;
}

function enregistrer_commande_BD($nom_partenaire,$id_client,$tab_ids_produits,$tab_ids_menus){
	//connexion base de données
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	//créaton de la commande
	$date_commande=time();
	$date_retrait=0;
	$est_prete=0;
	$est_retire=0;
	$nom_partenaire=mise_en_forme($nom_partenaire);

	$id_partenaire=get_id_part_by_nom($nom_partenaire);
	//requête
	$req="INSERT INTO Commande(date_commande,date_retrait,est_prete,est_retire,id_client,id_partenaire) 
		  VALUES($date_commande,$date_retrait,$est_prete,$est_retire,$id_client,$id_partenaire)
		 ;";

	mysqli_query($link,$req);

	//on récupère l'id de la commande insérée
	$id_commande=mysqli_insert_id($link);
	//test

	if(isset($tab_ids_produits)&&count($tab_ids_produits)>0){
		//pour chaque produit on l'associe à la commande
		foreach($tab_ids_produits as $id_produit){
			$req="INSERT INTO Contenir(id_commande,id_produit,quantite_produit) 
				  VALUES($id_commande,$id_produit[0],$id_produit[1])
				;"
				;
			mysqli_query($link,$req);
		}
	}
	if(isset($tab_ids_menus)&&count($tab_ids_menus)>0){
		//pour chaque menu on l'associeaussi à la commande
		foreach($tab_ids_menus as $id_menu){
			//requête
			$req="INSERT INTO Composer(id_commande,id_menu,quantite_menu) 
				  VALUES($id_commande,$id_menu[0],$id_menu[1])
				;";
			mysqli_query($link,$req);
		}
	}
}

function get_id_part_by_nom($nom_lieu){
	//connexion base de données
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());

	$req="SELECT id_partenaire FROM Partenaire WHERE nom_part='$nom_lieu';";
	$res=mysqli_query($link,$req);
	$tab=mysqli_fetch_row($res);
	$id=$tab[0];
	return $id;
}

function mise_en_forme($nom_partenaire){
	return substr($nom_partenaire,1,-1);
}

/*pour les commandes non retirées*/
function get_commande_non_retire_client($idcli){
	//importe les variables de connexion
	require("modele/config_BD.php");
	//connecte à la base de données
	$link=mysqli_connect($hote,$login,$pass,$bd);
	if(!$link) die ("erreur de connexion : ".mysqli_connect_errno());
	//requête
	$req="SELECT DISTINCT(c.id_commande), c.est_prete, c.date_commande, p.nom_part, p.adresse_part, p.code_part
		  FROM Commande c, Partenaire p 
		  WHERE c.id_client = $idcli AND c.est_retire = 0 AND p.id_partenaire = c.id_partenaire
		  ORDER BY c.id_commande DESC
		  ";
	//execution
	$res=mysqli_query($link,$req);
	//mise dans un tableau exploitable php
	$tab=mysqli_fetch_all($res,MYSQLI_ASSOC);
	return $tab;	
}


?>