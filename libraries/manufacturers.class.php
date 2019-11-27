<?php
/**
 * Darbuotojų redagavimo klasė
 *
 * @author ISK
 */

class manufacturers {
	
	private $gamintojai_lentele = '';
	private $vaistai_lentele = '';
	
	public function __construct() {
		$this->gamintojai_lentele = config::DB_PREFIX . 'vaistu_gamintojai';
		$this->vaistai_lentele = config::DB_PREFIX . 'vaistai';
	}
	
	/**
	 * Darbuotojo išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getManufacturer($id) {
		$query = "  SELECT *
					FROM `{$this->gamintojai_lentele}`
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Darbuotojų sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getManufacturersList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "  SELECT *
					FROM `{$this->gamintojai_lentele}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Darbuotojų kiekio radimas
	 * @return type
	 */
	public function getManufacturersListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM `{$this->gamintojai_lentele}`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Darbuotojo šalinimas
	 * @param type $id
	 */
	public function deleteManufacturer($id) {
		$query = "  DELETE FROM `{$this->gamintojai_lentele}`
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo atnaujinimas
	 * @param type $data
	 */
	public function updateManufacturer($data) {
		$query = "  UPDATE `{$this->gamintojai_lentele}`
					SET    `pavadinimas`='{$data['pavadinimas']}',
						   `adresas`='{$data['adresas']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo įrašymas
	 * @param type $data
	 */
	public function insertManufacturer($data) {
		$query = "  INSERT INTO `{$this->gamintojai_lentele}`
								(
									`id`,
									`pavadinimas`,
									`adresas`
								) 
								VALUES
								(
									'{$data['id']}',
									'{$data['pavadinimas']}',
									'{$data['adresas']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas darbuotojas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
        public function getDrugsCountOfManufacturers($id) {
                $query = "  SELECT COUNT(`{$this->vaistai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->gamintojai_lentele}`
                                                INNER JOIN `{$this->vaistai_lentele}`
                                                        ON `{$this->gamintojai_lentele}`.`id`=`{$this->vaistai_lentele}`.`fk_vaistu_gamintojas`
                                        WHERE `{$this->gamintojai_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        }
	
}