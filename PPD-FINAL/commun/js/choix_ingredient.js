var nb_checked = 3;

$(function(){
	$("input.ingredient").change(function(){
		
		if($("input.ingredient:checked").length > nb_checked){
			alert('Vous devez choisir 3 ingrédients !');
			$(this).attr("checked", false);
		}
	});
	$("#form_choix_ingr").submit(function(){
		if($("input.ingredient:checked").length < nb_checked){
			alert('Vous devez choisir 3 ingrédients !');
			return false;
		}
		return true;
	});
});