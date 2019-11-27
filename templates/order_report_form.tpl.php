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
			<p><label class="field" for="dataNuo">Uzsakymai pateikti nuo</label><input type="text" id="dataNuo" name="dataNuo" class="textbox textbox-100 date" value="<?php echo isset($fields['dataNuo']) ? $fields['dataNuo'] : ''; ?>" /></p>
			<p><label class="field" for="dataIki">Uzsakymai pateikti iki</label><input type="text" id="dataIki" name="dataIki" class="textbox textbox-100 date" value="<?php echo isset($fields['dataIki']) ? $fields['dataIki'] : ''; ?>" /></p>
                       
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