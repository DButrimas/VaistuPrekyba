<ul id="reportInfo">
	<li class="title">pardavimi ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>pasirinkta vaistine:
		<span>
		<?php
			if(!empty($data['pasirininkimas'])) {
				
					echo "pasirinkta vaistine: {$data['pasirinkimas']}";
                        }
				 else {
					echo $data['pasirinkimas'];
				}
                        
		?>
		</span>
	</li>
</ul>
<?php		
	if(sizeof($drugstoresData) > 0) { ?>
		<table class="reportTable">
			<tr class="gray">
				<th>ID</th>
				<th>Vardas</th>
                                <th>telefono.nr</th>
                                <th>darbo laikas</th>
			
			</tr>
			
			<?php
				// suformuojame lentelę
				foreach($drugstoresData as $key => $val) {
					echo
						"<tr>"
						. "<td>{$val['id']}</td>"
						. "<td>{$val['vardas']}</td>"
						. "<td>{$val['telefono_nr']}</td>"
						. "<td>{$val['darbo_laikas']}</td>"     
                                                . "</tr>";
				}
			?>
			
			<tr class="aggregate">
				<td></td>
				<td class="label"></td>
                                <td class="label"></td>
                                <td class="label"></td>
				 <td class="label"></td>
			</tr>
		</table>
		<a href="index.php?module=drugstore&action=report" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php   
	} else {
?>
		<div class="warningBox">
			Nepasirinkote vaistines.
		</div>
<?php
	}
?>

               