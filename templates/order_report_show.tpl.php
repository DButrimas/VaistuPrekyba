<ul id="reportInfo">
	<li class="title">uzsakymu ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li>užsakymo laikotarpis:
		<span>
		<?php
                $ordersStats[0]['su_nuolaida']=$ordersStats[0]['bendra_suma']-$ordersStats[0]['su_nuolaida'];
			if(!empty($data['dataNuo'])) {
				if(!empty($data['dataIki'])) {
					echo "nuo {$data['dataNuo']} iki {$data['dataIki']}";
				} else {
					echo "nuo {$data['dataNuo']}";
				}
			} else {
				if(!empty($data['dataIki'])) {
					echo "iki {$data['dataIki']}";
				} else {
					echo "nenurodyta";
				}
			}
		?>
		</span>
	</li>
</ul>
<?php		
	if(sizeof($ordersData) > 0) { ?>
		<table class="reportTable">
			<tr class="gray">
				<th>ID</th>
				<th>Data</th>
                                <th>vaistine</th>
                                <th>kiekis</th>
				<th>kaina be nuolaidos</th>
				<th>kaina su nuolaida</th>
			</tr>
			
			<?php
				// suformuojame lentelę
				foreach($ordersData as $key => $val) {
					echo
						"<tr>"
						. "<td>{$val['id']}</td>"
						. "<td>{$val['data']}</td>"
						. "<td>{$val['pavadinimas']}</td>"
						. "<td>{$val['kiekis']}</td>"
                                                . "<td>{$val['bendra_suma']} &euro;</td>"     
                                                . "<td>{$val['su_nuolaida']} &euro;</td>"   
                                                . "</tr>";
				}
			?>
			
		  	<tr>
				<td class='groupSeparator' colspan='6'>Suma</td>
			</tr>
			
			<tr class="aggregate">
				<td></td>
				<td class="label"></td>
                                <td class="label"></td>
                                <td class="label"></td>
				<td class="border"><?php echo "{$ordersStats[0]['kiekis']}"; ?>;</td>
				<td class="border"><?php echo "{$ordersStats[0]['bendra_suma']}"; ?> &euro;</td>
			<td class="border"><?php echo "{$ordersStats[0]['su_nuolaida']}"; ?> &euro;</td>
                        </tr>
		</table>
		<a href="index.php?module=order&action=report" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php   
	} else {
?>
		<div class="warningBox">
			Nurodytu laikotartpiu paslaugų užsakyta nebuvo.
		</div>
<?php
	}
?>