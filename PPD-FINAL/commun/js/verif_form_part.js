// Ne pas oublier de mettre ça :
// <script type="text/javascript" src="commun/js/testFormPart.js"></script>
// dans pagePrincipale.php

var val;

$(document).ready(function(){
	$('#nom_part').focus();
    $('#nom_part').keyup(verifNom);
    $('#mdp_part').keyup(verifMdp);
    $('#adresse_part').keyup(verifAdresse);
    $('#code_part').keyup(verifCode);
    $('#email_part').keyup(verifEmail);
    $('#numero_part').keyup(verifTelephone);
    $('#form_part').submit(validerFormulaire);
});

function validerFormulaire(){
	if(verifEmail() && verifTelephone() && verifCode() && verifAdresse() && verifMdp() && verifNom()){
		
	}
	
}

function verifChampTailleSaisie(id, name, longueur){
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

function verifRegex(regex, id, name){
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

function verifCode(){
	return(verifRegex(/[0-9]{5}/, $("#code_part"), $("[name='codeMauvaisFormat']")));
}

function verifMdp(){
	return(verifRegex(/^[a-zA-Z0-9éèëïêö]{4,20}$/, $("#mdp_part"), $("[name='mdpMauvaisFormat']")));
}

function verifNomFormat(){
	return(verifRegex(/^[a-zA-Zéèëïêö]{3,20}$/ , $('#nom_part'), $("[name='nomMauvaisFormat']")));
}

function verifAdresse(){
	return(verifRegex(/^[(\d+\s?)+a-zA-Z0-9éèëïêö]{5,30}$/, $('#adresse_part'), $("[name='adresseMauvaisFormat']")));
}

function verifEmail(){
	return(verifRegex(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, $('#email_part'), $("[name='emailMauvaisFormat']")));
}

function verifTelephone(){
	return(verifRegex(/[0-9]{10}/, $('#numero_part'), $("[name='telephoneMauvaisFormat']")));
}

function verifNom(){
	if(verifNomFormat()){
		verifNomUnique();
		return val;
	}
	return false;
}


function verifNomUnique(){
	var valeur_nom = $('#nom_part').attr("value");
	var span = $("[name='nomUtilise']");
	$.ajax({
		url : "index.php?controle=partenaire&action=verifNomUnique",
		type : 'POST',
		data: {'nom_part': valeur_nom},
		dataType : 'html',
		async : 'true',
		success : function(data){
				//alert(data);
				if(data.indexOf('false', 0) == -1) {
					val = true;
					span.css({display: 'none'});
					$("#nom_part").removeClass('incorrect');
					$("#nom_part").addClass('correct');
				}
				else{
					val = false;
					span.css({display: 'inline-block'});
					$("#nom_part").removeClass('correct');
					$("#nom_part").addClass('incorrect');
				}
		}
	});
	return false;
}