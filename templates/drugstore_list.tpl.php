<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Vaistines</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Nauja Vaistine</a>
</div>
<div class="float-clear"></div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Vaistine nebuvo pašalinta.
	</div>
<?php } ?>

<table class="listTable">
	<tr>
		<th>id</th>
		<th>pavadinimas</th>
		<th>adresas</th>
                <th>tel.nr</th>
                <th>tinklapis</th>
                <th>el.pastas</th>
                <th>darbo_laikas</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id']}</td>"
					. "<td>{$val['pavadinimas']}</td>"
					. "<td>{$val['adresas']}</td>"
					. "<td>{$val['telefono_nr']}</td>"
                                        . "<td>{$val['tinklapis']}</td>"
                                        . "<td>{$val['el_pasto_adresas']}</td>" 
                                        . "<td>{$val['darbo_laikas']}</td>"
                                       . "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id']}' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/paging.tpl.php';
?>