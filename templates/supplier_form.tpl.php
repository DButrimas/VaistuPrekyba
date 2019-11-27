<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Tiekejai</a></li>
	<li><?php if(!empty($id)) echo "Tiekejo redagavimas"; else echo "Naujas Tiekejas"; ?></li>
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
			<legend>Tiekejo informacija</legend>
				<p>
					<label class="field" for="id">id<?php echo in_array('id', $required) ? '<span> *</span>' : ''; ?></label>
					<?php if(!isset($data['editing'])) { ?>
						<input type="text" id="id" name="id" class="textbox textbox-150" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
						<?php if(key_exists('id', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['id']} simb.)</span>"; ?>
					<?php } else { ?>
						<span class="input-value"><?php echo $data['id']; ?></span>
						<input type="hidden" name="editing" value="1" />
						<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
					<?php } ?>
				</p>
			<p>
				<label class="field" for="pavadinimas">pavadinimas<?php echo in_array('pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="pavadinimas" name="pavadinimas" class="textbox textbox-150" value="<?php echo isset($data['pavadinimas']) ? $data['pavadinimas'] : ''; ?>" />
				<?php if(key_exists('pavadinimas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['pavadinimas']} simb.)</span>"; ?>
			</p>
			<p>
				<label class="field" for="adresas">adresas<?php echo in_array('adresas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="adresas" name="adresas" class="textbox textbox-150" value="<?php echo isset($data['adresas']) ? $data['adresas'] : ''; ?>" />
				<?php if(key_exists('adresas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['adresas']} simb.)</span>"; ?>
			</p>
                        <p>
				<label class="field" for="telefono_nr">telefono_nr<?php echo in_array('telefono_nr', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="telefono_nr" name="telefono_nr" class="textbox textbox-150" value="<?php echo isset($data['telefono_nr']) ? $data['telefono_nr'] : ''; ?>" />
				<?php if(key_exists('telefono_nr', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['telefono_nr']} simb.)</span>"; ?>
			</p>
                         <p>
				<label class="field" for="el_pasto_adresas">el_pasto_adresas<?php echo in_array('el_pasto_adresas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="el_pasto_adresas" name="el_pasto_adresas" class="textbox textbox-150" value="<?php echo isset($data['el_pasto_adresas']) ? $data['el_pasto_adresas'] : ''; ?>" />
				<?php if(key_exists('el_pasto_adresas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['el_pasto_adresas']} simb.)</span>"; ?>
			</p>
		</fieldset>
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>
	</form>
</div>