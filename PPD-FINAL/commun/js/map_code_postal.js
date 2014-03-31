var map, geocoder;

$(document).ready(function() {
	var tabMarker = new Array();
	$('#code_postal').get(0).selectedIndex = 0;
	var a = $('#code_postal option:selected').val();
	
	// initialisation de la carte Google Map.
	geocoder = new google.maps.Geocoder();
	// Histoire d'avoir une carte initiale...
	var latlng = new google.maps.LatLng(48.856614,2.352222);
	var mapOptions = {
		zoom      : 12,
		center    : latlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	map.setCenter(latlng);
    $('#code_postal').live('change', function() {
			var code = $('#code_postal option:selected').val()
			
            $.ajax({
                url: "index.php?controle=commande&action=get_partenaire_code_postal", // le nom du fichier indiqué dans le formulaire
                type: 'POST', // la méthode indiquée dans le formulaire (get ou post)
                data: {'code_postal': code}, // je sérialise les données (voir plus loin), ici les $_POST
                success: function(data) {
				  for(var j = 0; j < tabMarker.length; ++j){
					tabMarker[j].setMap(null);
				  }
				  var tab = JSON.parse(data);
                  var i =0;
				  if(data != null){
					for(i = 0; i < tab.length; ++i){
					  var adresse = JSON.stringify(tab[i]['adresse_part']) + ' ' +code + ' FRANCE';
					  creerMarker(adresse, map, i, tab, tabMarker);
					}
				  }
				}
            });
			return false;
        });
	
		
 });
 
 
 function creerMarker(adresse, map, i, tab, tabMarker){
  geocoder.geocode( { 'address': adresse}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
      var id=JSON.stringify(tab[i]['id_partenaire']);
	  tabMarker.push(marker);
	      var contenu =	"Nom : " + JSON.stringify(tab[i]['nom_part']) + "</br>" +
	      				"Adresse : "+ JSON.stringify(tab[i]['adresse_part']) + "</br>" +
	      				"T&eacute;l&eacute;phone : " + JSON.stringify(tab[i]['num_tel_part']) + "</br>" +
		            	"Note : "+ JSON.stringify(tab[i]['note_partenaire']) + "</br>" +
		            	"<a href='index.php?controle=evaluation&action=aff_commentaires_partenaire&id_partenaire="+id+"'> Voir commentaires... </a>"+
	      				"<a href='index.php?controle=commande&action=choisir_lieu&choix_lieu="+JSON.stringify(tab[i]['nom_part'])+"'> Commander </a>"
	      				;
      var infoWindow = new google.maps.InfoWindow({
        content  : contenu,
        position : marker.position
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.open(this.getMap(), this);
      });
    } else {
      alert('Adresse introuvable: ' + status);
    }
  });
}