<div id="formContainer">
	<?php if($formErrors != null) { ?>
		<div class="errorBox">
			Neįvesti arba neteisingai įvesti šie laukai:
			<?php 
				echo $formErrors;
			?>
		</div>
	<?php } ?>
	<form action="" method="post">
		<fieldset>
			<legend>Įveskite ataskaitos kriterijus</legend>
                       
				<select id="drugstore" name="pasirinkimas">
					<option value="-1">Pasirinkite vaistine</option>
					<?php
						// išrenkame visas markes
						$drugstores = $drugstoresObj->getDrugstoresList();
						foreach($drugstores as $key => $val) {
							$selected = "";
							if(isset($drugstores['id']) == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
						}
					?>
				</select>
		</fieldset>
		<p><input type="submit" class="submit button float-right" name="submit" value="Sudaryti ataskaitą"></p>
	</form>
</div>