<?php

if(file_exists("vue/includes/".$page.".tpl"))
	include("vue/includes/".$page.".tpl");
else
	include("vue/includes/accueil.tpl");
?>