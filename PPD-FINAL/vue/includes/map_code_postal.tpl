<section class='map_code_postal'>
	<div>
			<label for="code_postal">Code postal :</label>
			<select id='code_postal'>
			<option value="">-- SELECTIONNER UN CODE POSTAL --</option>'; 
			<?php foreach($tab_code_postal as $elem ){ 
				 echo '<option value="'.$elem[0].'">'.$elem[0].'</option>'; 
			 } ?>
			</select>
	</div>	
	<section class='carte_map_code_postal' id='map'>
	
	</section>
</section>