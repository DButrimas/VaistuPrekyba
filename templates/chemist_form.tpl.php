<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Vaistininkai</a></li>
	<li><?php if(!empty($id)) echo "Vaistininko redagavimas"; else echo "Naujas vaistininkas"; ?></li>
</ul>
<div class="float-clear"></div>
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
			<legend>Modelio informacija</legend>
				<p>
					<label class="field" for="id">id<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
					<?php if(!isset($data['id'])) { ?>
						<input type="text" id="id" name="id" class="textbox textbox-150" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
						<?php if(key_exists('id', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['id']} simb.)</span>"; ?>
					<?php } else { ?>
						<span class="input-value"><?php echo $data['id']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
					<?php } ?>
				</p>
                        <p>
				<label class="field" for="drugstore">vaistine<?php echo in_array('fk_vaistine', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="drugstore" name="fk_vaistine">
					<option value="-1">Pasirinkite vaistine</option>
					<?php
						// išrenkame visas markes
						$drugstores = $drugstoresObj->getDrugstoresList();
						foreach($drugstores as $key => $val) {
							$selected = "";
							if(isset($data['fk_vaistine']) && $data['fk_vaistine'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['pavadinimas']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="telefono_nr">Tel.nr<?php echo in_array('telefono_nr', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="telefono_nr" class="textbox textbox-150" value="<?php echo isset($data['telefono_nr']) ? $data['telefono_nr'] : ''; ?>">
				<?php if(key_exists('telefono_nr', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['telefono_nr']} simb.)</span>"; ?>
			</p>
                        <p>
				<label class="field" for="vardas">vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="vardas" class="textbox textbox-150" value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>">
				<?php if(key_exists('vardas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['vardas']} simb.)</span>"; ?>
			</p>
		</fieldset>
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>
		<?php if(isset($data['id'])) { ?>
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<?php } ?>
	</form>
</div>