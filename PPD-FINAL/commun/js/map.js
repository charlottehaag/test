var geocoder;

window.onload = function(){
  var map;
  // initialisation de la carte Google Map.
  geocoder = new google.maps.Geocoder();
  // Histoire d'avoir une carte initiale...
  var latlng = new google.maps.LatLng(48.856614,2.352222);
  var mapOptions = {
    zoom      : 12,
    center    : latlng,
    mapTypeId : google.maps.MapTypeId.ROADMAP
  }
  
  map = new google.maps.Map(document.getElementById('carte'), mapOptions);
  var i =0;
  if(tableau != null){
    for(i = 0; i < tableau.length; ++i){
      var adresse = JSON.stringify(tableau[i]['adresse_part']) +  JSON.stringify(tableau[i]['code_part']) + ' FRANCE';
      creerMarker(adresse, map, i);
    }
  }
   map.setCenter(latlng);
}



function creerMarker(adresse, map, i){
  geocoder.geocode( { 'address': adresse}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {

      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
      var id=JSON.stringify(tableau[i]['id_partenaire'])
      var contenu ="Nom : " + JSON.stringify(tableau[i]['nom_part']) + "</br>" +
      				"Adresse : "+ JSON.stringify(tableau[i]['adresse_part']) + "</br>" +
      				"Téléphone : " + JSON.stringify(tableau[i]['num_tel_part']) + "</br>" +
              "Note : "+ JSON.stringify(tableau[i]['note_partenaire']) + "</br>" +
              "<a href='index.php?controle=evaluation&action=voter_partenaire&id_partenaire="+id+"'> +1 </a></br>"+
              "<a href='index.php?controle=evaluation&action=aff_commentaires_partenaire&id_partenaire="+id+"'> Voir commentaires... </a></br>"+
              "<a href='index.php?controle=evaluation&action=commenter_partenaire&id_partenaire="+id+"'> Commenter </a></br>"+
			  "<a href='index.php?controle=commande&action=choisir_lieu&choix_lieu="+JSON.stringify(tableau[i]['nom_part'])+"'> Commander </a>"
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