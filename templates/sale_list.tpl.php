<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Tiekejai</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas Pardavimas</a>
</div>
<div class="float-clear"></div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Tiekejas nebuvo pašalinta.
	</div>
<?php } ?>

<table class="listTable">
	<tr>
		<th>id</th>
		<th>pirkimas</th>
		<th>vaistine</th>
                <th>vaistininkas</th>
                <th>data</th>
                <th>vaistas</th>
                <th>kaina</th>
                <th>kiekis</th>
                <th>suma</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['parid']}</td>"
					. "<td>{$val['detid']}</td>"
					. "<td>{$val['vaistine']}</td>"
					. "<td>{$val['vaistininkas']}</td>"
                                        . "<td>{$val['data']}</td>" 
                                        . "<td>{$val['vaistas']}</td>" 
                                        . "<td>{$val['kaina']}</td>" 
                                        . "<td>{$val['kiekis']}</td>" 
                                       . "<td>{$val['suma']}</td>" 
                                        . "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['parid']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='index.php?module={$module}&action=edit&id={$val['parid']}' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/paging.tpl.php';
?>