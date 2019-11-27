<?php
/**
 * Darbuotojų redagavimo klasė
 *
 * @author ISK
 */

class drugs {
	
	private $vaistai_lentele = '';
        private $gamintojai_lentele = '';

	
	public function __construct() {
		$this->vaistai_lentele = config::DB_PREFIX . 'vaistai';
		$this->gamintojai_lentele = config::DB_PREFIX . 'vaistu_gamintojai';
               // $this->uzsakymai_lentele = config::DB_PREFIX . 'uzsakymai';

	}
	
	/**
	 * Darbuotojo išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getDrugs($id) {
		$query = "  SELECT *
					FROM `{$this->vaistai_lentele}`
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
	public function getDrugsList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "  SELECT *
					FROM `{$this->vaistai_lentele}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Darbuotojų kiekio radimas
	 * @return type
	 */
	public function getSuppliersListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM `{$this->tiekejai_lentele}`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Darbuotojo šalinimas
	 * @param type $id
	 */
	public function deleteSupplier($id) {
		$query = "  DELETE FROM `{$this->tiekejai_lentele}`
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo atnaujinimas
	 * @param type $data
	 */
	public function updateSupplier($data) {
		$query = "  UPDATE `{$this->tiekejai_lentele}`
					SET    `pavadinimas`='{$data['pavadinimas']}',
						   `adresas`='{$data['adresas']}',
                                                       `telefono_nr`='{$data['telefono_nr']}',
                                                               `el_pasto_adresas`='{$data['el_pasto_adresas']}'                  
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo įrašymas
	 * @param type $data
	 */
	public function insertSupplier($data) {
		$query = "  INSERT INTO `{$this->tiekejai_lentele}`
								(	
                                                                        `id`,
									`pavadinimas`,
									`adresas`,
                                                                        `telefono_nr`,
									`el_pasto_adresas`  
								) 
								VALUES
								(
									'{$data['id']}',
									'{$data['pavadinimas']}',
									'{$data['adresas']}',
                                                                        '{$data['telefono_nr']}',
									'{$data['el_pasto_adresas']}'  
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas darbuotojas, kiekio radimas
	 * @param type $id
	 * @return type
	 */    
         public function getSuppliersCountOfShipments($id) {
                $query = "  SELECT COUNT(`{$this->kroviniai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->tiekejai_lentele}`
                                                INNER JOIN `{$this->kroviniai_lentele}`
                                                        ON `{$this->tiekejai_lentele}`.`id`=`{$this->kroviniai_lentele}`.`fk_tiekejas`
                                        WHERE `{$this->tiekejai_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        } 
         public function getSuppliersCountOfOrders($id) {
                $query = "  SELECT COUNT(`{$this->uzsakymai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->tiekejai_lentele}`
                                                INNER JOIN `{$this->uzsakymai_lentele}`
                                                        ON `{$this->tiekejai_lentele}`.`id`=`{$this->uzsakymai_lentele}`.`fk_tiekejas`
                                        WHERE `{$this->tiekejai_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        } 
        
          
	
}