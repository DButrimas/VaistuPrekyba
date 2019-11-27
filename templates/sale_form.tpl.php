<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Pardavimai</a></li>
	<li><?php if(!empty($id)) echo "Pardavimo redagavimas"; else echo "Naujas pardavimas"; ?></li>
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
			<legend>pardavimo informacija</legend>
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
				<label class="field" for="chemist">vaistininkas<?php echo in_array('fk_vaistininkas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="chemist" name="fk_vaistininkas">
					<option value="-1">Pasirinkite vaistininka</option>
					<?php
						// išrenkame visas markes
						$chemists = $chemistsObj->getChemistList();
						foreach($chemists as $key => $val) {
							$selected = "";
							if(isset($data['fk_vaistininkas']) && $data['fk_vaistininkas'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['vardas']}</option>";
						}
					?>
				</select>
			</p>
                        <p>
				<label class="field" for="bendra_suma">bendra_suma<?php echo in_array('bendra_suma', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="bendra_suma" name="bendra_suma" class="textbox textbox-20" value="<?php echo isset($data['bendra_suma']) ? $data['bendra_suma'] : ''; ?>">
				<?php if(key_exists('bendra_suma', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['bendra_suma']} simb.)</span>"; ?>
			</p>
                     	<p>
				<label class="field" for="id">id<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="id" class="textbox textbox-20" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
				<?php if(key_exists('id', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['id']} simb.)</span>"; ?>
			</p>
                        <p>
				<label class="field" for="data">Data<?php echo in_array('data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="data" name="data" class="textbox date textbox-50" value="<?php echo isset($data['data']) ? $data['data'] : ''; ?>">
			</p>
		</fieldset>
            <fieldset>
			<legend>pardavimo detales</legend>
			<div class="childRowContainer">
				<div class="labelLeft<?php if(empty($data['pardavimu_detales']) || sizeof($data['pardavimu_detales']) == 0) echo ' hidden'; ?>">vaistas *</div>
				<div class="labelRight<?php if(empty($data['pardavimu_detales']) || sizeof($data['pardavimu_detales']) == 0) echo ' hidden'; ?>">id *</div>
                                <div class="labelRight<?php if(empty($data['pardavimu_detales']) || sizeof($data['pardavimu_detales']) == 0) echo ' hidden'; ?>">kiekis *</div>
                                <div class="labelRight<?php if(empty($data['pardavimu_detales']) || sizeof($data['pardavimu_detales']) == 0) echo ' hidden'; ?>">kaina *</div>
				<div class="float-clear"></div>
				<?php
					if(empty($data['pardavimu_detales']) || sizeof($data['pardavimu_detales']) == 0) {
				?>
					
					<div class="childRow hidden">
						<select class="elementSelector" name="vaistai[]" disabled="disabled">
                                                    <option value="-1">Pasirinkite vaista</option>
							<?php
								$drugs = $drugsObj->getDrugsList();
								foreach($drugs as $key => $val) {
										$selected = "";
										if(isset($data['vaistas']) && $data['vaistas'] == $val['id']) {
											$selected = " selected='selected'";
										}
										echo "<option{$selected} value='{$val['id']}'>{$val['vaisto_pavadinimas']}</option>";
									}
								
							?>
						</select>
						<input type="text" name="detales_id[]" value="" class="textbox textbox-70" disabled="disabled" />
						<input type="text" name="kiekis[]" value="" class="textbox textbox-70" disabled="disabled" />
                                                <input type="text" name="vieneto_kaina[]" value="" class="textbox textbox-70" disabled="disabled" />
						
						<a href="#" title="" class="removeChild">šalinti</a>
					</div>
					<div class="float-clear"></div>
					
				<?php
					} else {
						foreach($data['pardavimu_detales'] as $key => $val) {
				?>
							<div class="childRow">
						    <select class="elementSelector" name="vaistai[]">
                                                    <option value="-1">Pasirinkite vaista</option>
							<?php
						       $drugs = $drugsObj->getDrugsList();
						       foreach($drugs as $key1 => $val1) {
							$selected = "";
							if($val['vaistas'] == $val1['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val1['id']}'>{$val1['vaisto_pavadinimas']}</option>";
									}
								
							?>
						</select>
						<input type="text" name="detales_id[]" class="textbox textbox-30" value="<?php echo isset($val['detales_id']) ? $val['detales_id'] : ''; ?>" />
						<input type="text" name="kiekis[]" class="textbox textbox-30" value="<?php echo isset($val['kiekis']) ? $val['kiekis'] : ''; ?>" />
                                                <input type="text" name="vieneto_kaina[]" value="<?php echo $val['vieneto_kaina']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
						
						<a href="#" title="" class="removeChild">šalinti</a>
					</div>
					<div class="float-clear"></div>
				<?php 
						}
                                                
					}
				?>
			</div>
			<p id="newItemButtonContainer">
				<a href="#" title="" class="addChild">Pridėti</a>
			</p>
		</fieldset>
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>
		<?php if(isset($data['id'])) { ?>
			<input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
		<?php } ?>
	</form>
</div>