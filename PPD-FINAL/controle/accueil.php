<?php

//pour carte
require('controle/commande.php');

function aff_accueil(){
	$tab_partenaire=get_all_partenaire();
	$page="accueil";
	require("vue/pagePrincipale.php");
}

?>