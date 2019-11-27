<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Automobiliai</a></li>
	<li><?php if(!empty($id)) echo "Automobilio redagavimas"; else echo "Naujas automobilis"; ?></li>
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
			<legend>Automobilio informacija</legend>
			<p>
				<label class="field" for="modelis">Modelis<?php echo in_array('modelis', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="modelis" name="modelis">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$brands = $brandsObj->getBrandList();
						foreach($brands as $key => $val) {
							echo "<optgroup label='{$val['pavadinimas']}'>";

							$models = $modelsObj->getModelListByBrand($val['id']);
							foreach($models as $key2 => $val2) {
								$selected = "";
								if(isset($data['modelis']) && $data['modelis'] == $val2['id']) {
									$selected = " selected='selected'";
								}
								echo "<option{$selected} value='{$val2['id']}'>{$val2['pavadinimas']}</option>";
							}
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="valstybinis_nr">Valstybinis numeris<?php echo in_array('valstybinis_nr', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="valstybinis_nr" name="valstybinis_nr" class="textbox textbox-70" value="<?php echo isset($data['valstybinis_nr']) ? $data['valstybinis_nr'] : ''; ?>">
				<?php if(key_exists('valstybinis_nr', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['valstybinis_nr']} simb.)</span>"; ?>
			</p>
			<p>
				<label class="field" for="pagaminimo_data">Pagaminimo data<?php echo in_array('pagaminimo_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="pagaminimo_data" name="pagaminimo_data" class="textbox textbox-70 date" value="<?php echo isset($data['pagaminimo_data']) ? $data['pagaminimo_data'] : ''; ?>"></p>
			<p>
				<label class="field" for="pavaru_deze">Pavarų dėžė<?php echo in_array('pavaru_deze', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="pavaru_deze" name="pavaru_deze">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$gearboxes = $carsObj->getGearboxList();
						foreach($gearboxes as $key => $val) {
							$selected = "";
							if(isset($data['pavaru_deze']) && $data['pavaru_deze'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="degalu_tipas">Degalų tipas<?php echo in_array('degalu_tipas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="degalu_tipas" name="degalu_tipas">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$fueltypes = $carsObj->getFuelTypeList();
						foreach($fueltypes as $key => $val) {
							$selected = "";
							if(isset($data['degalu_tipas']) && $data['degalu_tipas'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="kebulas">Kėbulo tipas<?php echo in_array('kebulas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="kebulas" name="kebulas">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$bodytypes = $carsObj->getBodyTypeList();
						foreach($bodytypes as $key => $val) {
							$selected = "";
							if(isset($data['kebulas']) && $data['kebulas'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="bagazo_dydis">Bagažo dydis<?php echo in_array('bagazo_dydis', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="bagazo_dydis" name="bagazo_dydis">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$lugage = $carsObj->getLugageTypeList();
						foreach($lugage as $key => $val) {
							$selected = "";
							if(isset($data['bagazo_dydis']) && $data['bagazo_dydis'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="busena">Būsena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="busena" name="busena">
					<option value="-1">---------------</option>
					<?php
						// išrenkame visas kategorijas sugeneruoti pasirinkimų lauką
						$car_states = $carsObj->getCarStateList();
						foreach($car_states as $key => $val) {
							$selected = "";
							if(isset($data['busena']) && $data['busena'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
			<p>
				<label class="field" for="rida">Rida<?php echo in_array('rida', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="rida" name="rida" class="textbox textbox-70" value="<?php echo isset($data['rida']) ? $data['rida'] : ''; ?>"><span class="units">km.</span>
			</p>
			<p>
				<label class="field" for="radijas">Radijas</label>
				<input type="checkbox" id="radijas" name="radijas"<?php echo (isset($data['radijas']) && ($data['radijas'] == 1 || $data['radijas'] == 'on'))  ? ' checked="checked"' : ''; ?>>
			</p>
			<p>
				<label class="field" for="grotuvas">Grotuvas</label>
				<input type="checkbox" id="grotuvas" name="grotuvas"<?php echo (isset($data['grotuvas']) && ($data['grotuvas'] == 1 || $data['grotuvas'] == 'on'))  ? ' checked="checked"' : ''; ?>>
			</p>
			<p>
				<label class="field" for="kondicionierius">Kondicionierius</label>
				<input type="checkbox" id="kondicionierius" name="kondicionierius"<?php echo (isset($data['kondicionierius']) && ($data['kondicionierius'] == 1 || $data['kondicionierius'] == 'on'))  ? ' checked="checked"' : ''; ?>>
			</p>
			<p>
				<label class="field" for="vietu_skaicius">Vietų skaičius<?php echo in_array('vietu_skaicius', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="vietu_skaicius" name="vietu_skaicius" class="textbox textbox-30" value="<?php echo isset($data['vietu_skaicius']) ? $data['vietu_skaicius'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="registravimo_data">Registravimo data<?php echo in_array('registravimo_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="registravimo_data" name="registravimo_data" class="textbox textbox-70 date" value="<?php echo isset($data['registravimo_data']) ? $data['registravimo_data'] : ''; ?>">
			</p>
			<p>
				<label class="field" for="verte">Vertė<?php echo in_array('verte', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="verte" name="verte" class="textbox textbox-70" value="<?php echo isset($data['verte']) ? $data['verte'] : ''; ?>"><span class="units">&euro;</span>
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