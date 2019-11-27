<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class chemists {
	
	private $vaistininkai_lentele = '';
	private $vaistines_lentele = '';
	//private $automobiliai_lentele = '';
	
	public function __construct() {
		$this->vaistininkai_lentele = config::DB_PREFIX . 'vaistininkai';
		$this->vaistines_lentele = config::DB_PREFIX . 'vaistines';
		//$this->automobiliai_lentele = config::DB_PREFIX . 'automobiliai';
	}
	
	/**
	 * Modelio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getChemist($id) {
		$query = "  SELECT *
					FROM `{$this->vaistininkai_lentele}`
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Modelių sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getChemistList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT `{$this->vaistininkai_lentele}`.`id`,
						   `{$this->vaistininkai_lentele}`.`telefono_nr`,
                                                       `{$this->vaistininkai_lentele}`.`vardas`,
						    `{$this->vaistines_lentele}`.`pavadinimas` AS `vaistine`,
                                                        `{$this->vaistines_lentele}`.`adresas` AS `adresas`
					FROM `{$this->vaistininkai_lentele}`
						LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->vaistininkai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Modelių kiekio radimas
	 * @return type
	 */
	public function getChemistListCount() {
		$query = "  SELECT COUNT(`{$this->vaistininkai_lentele}`.`id`) as `kiekis`
					FROM `{$this->vaistininkai_lentele}`
						LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->vaistininkai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Modelių išrinkimas pagal markę
	 * @param type $brandId
	 * @return type
	 */
	public function getChemistListByDrugstore($drugstoreId) {
		$query = "  SELECT *
					FROM `{$this->vaistininkai_lentele}`
					WHERE `fk_vaistine`='{$drugstoreId}'";
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Modelio atnaujinimas
	 * @param type $data
	 */
	public function updateChemist($data) {
		$query = "  UPDATE `{$this->vaistininkai_lentele}`
					SET    `telefono_nr`='{$data['telefono_nr']}',
                                            `vardas`='{$data['vardas']}',
						   `fk_vaistine`='{$data['fk_vaistine']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Modelio įrašymas
	 * @param type $data
	 */
	public function insertChemist($data) {
		$query = "  INSERT INTO `{$this->vaistininkai_lentele}`
								(
                                                                        `id`,
									`telefono_nr`,
                                                                        `vardas`,
									`fk_vaistine`
								)
								VALUES
								(
                                                                     '{$data['id']}',
									'{$data['telefono_nr']}',
                                                                            '{$data['vardas']}',
									'{$data['fk_vaistine']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Modelio šalinimas
	 * @param type $id
	 */
	public function deleteChemist($id) {
		$query = "  DELETE FROM `{$this->vaistininkai_lentele}`
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Nurodyto modelio automobilių kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getChemistCountOfDrugstores($id) {
		$query = "  SELECT COUNT(`{$this->vaistines_lentele}`.`id`) AS `kiekis`
					FROM `{$this->vaistininkai_lentele}`
						INNER JOIN `{$this->vaistines_lentele}`
							ON `{$this->vaistininkai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`
					WHERE `{$this->vaistines_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	
}