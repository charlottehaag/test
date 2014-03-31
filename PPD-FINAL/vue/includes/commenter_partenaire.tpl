<section class="form">
<form action=<?php echo "index.php?controle=evaluation&action=commenter_partenaire&id_partenaire=".$id ?> method="POST">
	<label for="contenu">Votre commentaire : </label>
	<textarea name="contenu" rows="5" cols="50" required="required"></textarea>
	<input type="submit" value="Commenter">
</form>
</section>