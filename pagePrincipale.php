<!DOCTYPE html>
<html>
    <head>

        <title>D&eacute;limiamMiam</title>

		<!--<link rel="stylesheet" type="text/css" href="commun/style/stylePage.css" />-->

		<link rel="stylesheet" type="text/css" href="commun/style/style_form.css" />
		<link rel="stylesheet" type="text/css" href="commun/style/styleMap.css" />
		
		<link href="commun/style/base.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="commun/style/styleMenu.css" rel="stylesheet" type="text/css" media="screen" />
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="commun/js/verif_form_cli.js"></script>
		<script type="text/javascript" src="commun/js/verif_form_part.js"></script>
		<script type="text/javascript" src="commun/js/choix_ingredient.js"></script>

		

		<script type="text/javascript" src="commun/js/jquery.pikachoose.js"></script>
		<script type="text/javascript">
				$(document).ready(function() {
				$("#pikame").PikaChoose();	});
		</script>


		<!-- Elément Google Maps indiquant que la carte doit être affiché en plein écran et
		qu'elle ne peut pas être redimensionnée par l'utilisateur -->
		<meta charset="utf-8" name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<!-- Inclusion de l'API Google MAPS -->
		<!-- Le paramètre "sensor" indique si cette application utilise détecteur pour déterminer la position de l'utilisateur -->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>		

		<?php if($page == 'map_code_postal') { ?>
			<script type="text/javascript" src="commun/js/map_code_postal.js"></script>
		<?php } ?>
		
		<?php if($page == 'accueil') { ?>
		
			<script type="text/javascript" src="commun/js/map.js"></script>
			<script type="text/javascript">
				var tableau = <?php echo json_encode($tab_partenaire); ?>;
			</script>
		
		
		<?php } ?>

		<link href="commun/style/styleAccueil.css" rel="stylesheet" type="text/css" media="screen" />

    </head>
	<body>
		<section id="blocSlide">
			<div class="pikachoose">
				<ul id="pikame">
					<li><a href=""><img src="commun/images/home/1.jpg" alt=""/></a></li>
					<li><a href=""><img src="commun/images/home/2.jpg" alt="" /></a></li>
					<li><a href=""><img src="commun/images/home/3.jpg" alt="" /></a></li>
					<li><a href=""><img src="commun/images/home/4.jpg" alt="" /></a></li>
					</div>
				</ul>
			</div>
		</section>
		<div class="test"></div>
		<div id="cadre">
			<a href="index.php?controle=accueil&action=aff_accueil"><div id="logo"></div></a>
			<div id="menu">
				<div id="couverts"></div>
				<div id="menuContact">
					<li><a href="index.php?controle=contact&action=aff_contact#menu">CONTACT</a></li>
				</div>
				<div id="menuPart">
					<?php if(!isset($_SESSION['id'])) { ?>
					<li><a>PARTENAIRE</a>
						<?php
						if(!isset($_SESSION['id_part'])){
						?>
							<ul>
								<li class="form trait">
									<a href="index.php?controle=partenaire&action=connexionPart#menu">Connexion</a>
								</li>
								<li class="form trait">
									<a href="index.php?controle=admin&action=connexionAdmin#menu">Inscription</a>
								</li>
							</ul>
						<?php
						}
						?>
					</li>
					<?php } else { ?>
					<li><a href="index.php?controle=commande&action=aff_commandes#menu">MON PANIER</a></li>
					<?php } ?>
				</div>
				<div id="menuCommande">
					<li><a href="index.php?controle=commande&action=aff_choix_menu#menu">COMMANDER</a></li>
				</div>
				
				<?php
				if(isset($_SESSION['pseudo'])||isset($_SESSION['nompart'])){
				?>
                <?php
                if(isset($_SESSION['pseudo'])){
					?>
					<div id="menuCompte">
						<li><a href="index.php?controle=utilisateur&action=gerer_compte#menu">MON<br>COMPTE</a></li>	
					</div>
				<?php }	?>
					<div id="menuConnect">
						<li><a href="index.php?controle=identification&action=deconnexion">DECONNEXION</a></li>
					</div>
				<?php
				}
				else{
				?>
				<div id="menuInscr">
					<li><a href="index.php?controle=inscription&action=inscrire#menu">INSCRIPTION</a></li>
				</div>
				<div id="menuConnect">
				<form action="index.php?controle=identification&action=connexion" method="POST">
					<li><a>CONNEXION</a>
						<ul>
							<li class="form trait">
								<a>Identifiant : </a>
								<input size="30" type="text" name="pseudo" id="pseudo"  required="required"/>
							</li>
							<li class="form trait">
								<a>Mot de passe : </a>
								<input size="30" type="password" name="mdp" id="mdp"   required="required"/>
							</li>
							<li class="button">
								<input id="envoyer" type="submit" name="Envoyer" />
							</li>
						</ul>
					</li>
				</form>
				</div>
				<?php
				}
				?>
			</div>
		<div class="pointe"></div>
		</div>
		<section id="blocMiddle">
				<?php
					include("contenu.tpl");
				?>
		<section>
	</body>
	<?php if($page != 'accueil') { ?>
	
	<footer></footer>
	
	<?php } ?>
</html>