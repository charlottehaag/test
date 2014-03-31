<?php
	
function aff_cmd_retire_cli(){
	$idcli = $_SESSION['id'];
	require("modele/client_cmd_BD.php");
	$tab_comm_client = get_commande_retire_client($idcli);
	$page="aff_cmd_retire_client";
	require("vue/pagePrincipale.php");
}

?>