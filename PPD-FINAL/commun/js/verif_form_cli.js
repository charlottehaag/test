var val;


$(document).ready(function(){
	$('#pseudo_cli').focus();
    $('#pseudo_cli').keyup(verifPseudoClient);
    $('#mdp_cli').keyup(verifMdpClient);
    $('#nom_cli').keyup(verifNomClient);
    $('#prenom_cli').keyup(verifPrenomClient);
    $('#email_cli').keyup(verifEmailClient);
    $('#telephone_cli').keyup(verifTelephoneClient);
	$('#form_cli').submit(validerFormulaireClient);
	$('#form_modif_pseudo').submit(verifPseudoClient);
	$('#form_modif_tel').submit(verifTelephoneClient);
	$('#form_modif_mdp').submit(verifMdpClient);
	$('#form_modif_email').submit(verifEmailClient);

});

function validerFormulaireClient(){
	return (verifTelephoneClient() && verifEmailClient() &&
	verifPrenomClient() &&
	verifNomClient() && 
	verifMdpClient() && verifPseudoClient() &&verifMdpConnexion());
	
}

function verifChampTailleSaisieClient(id, name, longueur){
	var valide = false;
	var valeur = id.attr("value");
	var span = name;
	if(valeur.length >= longueur){
		id.removeClass('incorrect');
		id.addClass('correct');
      	span.css({display: 'none'});
       	valide = true;
	}else {
       	id.removeClass('correct');
		id.addClass('incorrect');
      	span.css({display: 'inline-block'});
        id.focus();
 	}
 	return valide;
}

function verifRegexClient(regex, id, name){
	var val = id.attr("value");
	var correct = regex.test(val);
	if(!correct){
			name.css({display: 'inline-block'});
			id.removeClass('correct');
			id.addClass('incorrect');
			id.focus();		
	}
	else{
		id.removeClass('incorrect');
		id.addClass('correct');
      	name.css({display: 'none'});
     }
	return correct;
}

function verifMdpClient(){
	return(verifRegexClient(/^[a-zA-Z0-9éèëïêö]{4,20}$/, $("#mdp_cli"), $("[name='mdpMauvaisFormat']")));
}


function verifNomClient(){
	return(verifRegexClient(/^[a-zA-Zéèëïêö]{3,20}$/ , $('#nom_cli'), $("[name='nomMauvaisFormat']")));
}

function verifPrenomClient(){
	return(verifRegexClient(/^[a-zA-Zéèëïêö]{3,20}$/, $('#prenom_cli'), $("[name='prenomMauvaisFormat']")));
}

function verifEmailClient(){
	return(verifRegexClient(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, $('#email_cli'), $("[name='emailMauvaisFormat']")));
}

function verifTelephoneClient(){
	return(verifRegexClient(/[0-9]{10}/, $('#telephone_cli'), $("[name='telephoneMauvaisFormat']")));
}

function verifPseudoClient(){
	if(verifPseudoClientSaisie()){
		verifPseudoClientUnique();
		return val;
	}
	return false;
}

function verifPseudoClientSaisie(){
	// Nécessaire lorsque l'utilisateur supprime des caractères dans l'input
 	// car la taille du pseudo peut être inférieur à 3
 	var span = $("[name='pseudoUtilise']");
 	span.css({display: 'none'});
 	return verifChampTailleSaisieClient($('#pseudo_cli'), $("[name='pseudoMauvaisFormat']"), 3);
}


function verifPseudoClientUnique(){
	var valeur_pseudo = $('#pseudo_cli').attr("value");
	var span = $("[name='pseudoUtilise']");
	$.ajax({
		url : "index.php?controle=inscription&action=verifPseudoClientUnique",
		type : 'POST',
		data: {'pseudo': valeur_pseudo},
		dataType : 'html',
		async : 'true',
		success : function(data){
				//alert(data);
				if(data.indexOf('false', 0) == -1) {
					val = true;
					span.css({display: 'none'});
					$("#pseudo_cli").removeClass('incorrect');
					$("#pseudo_cli").addClass('correct');
				}
				else{
					val = false;
					span.css({display: 'inline-block'});
					$("#pseudo_cli").removeClass('correct');
					$("#pseudo_cli").addClass('incorrect');
				}
		}
	});
	return false;
}