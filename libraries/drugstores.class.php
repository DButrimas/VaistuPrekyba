<?php
/**
 * Darbuotojų redagavimo klasė
 *
 * @author ISK
 */

class drugstores {
	
	private $vaistines_lentele = '';
	private $vaistininkai_lentele = '';
        private $uzsakymai_lentele = '';
        private $pardavimai_lentele = '';
        private $mokejimai_lentele = '';
        private $kroviniai_lentele = '';
	
	public function __construct() {
		$this->vaistines_lentele = config::DB_PREFIX . 'vaistines';
		$this->vaistininkai_lentele = config::DB_PREFIX . 'vaistininkai';
                $this->uzsakymai_lentele = config::DB_PREFIX . 'uzsakymai';
		$this->pardavimai_lentele = config::DB_PREFIX . 'pardavimai';
                $this->mokejimai_lentele = config::DB_PREFIX . 'mokejimai';
		$this->kroviniai_lentele = config::DB_PREFIX . 'kroviniai';
	}
	
	/**
	 * Darbuotojo išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getDrugstores($id) {
		$query = "  SELECT *
					FROM `{$this->vaistines_lentele}`
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
	public function getDrugstoresList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "  SELECT *
					FROM `{$this->vaistines_lentele}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Darbuotojų kiekio radimas
	 * @return type
	 */
	public function getDrugstoresListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM `{$this->vaistines_lentele}`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Darbuotojo šalinimas
	 * @param type $id
	 */
	public function deleteDrugstore($id) {
		$query = "  DELETE FROM `{$this->vaistines_lentele}`
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
        public function deleteChemists($id) {
		$query = "  DELETE FROM `{$this->vaistininkai_lentele}`
					WHERE `fk_vaistine`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo atnaujinimas
	 * @param type $data
	 */
	public function updateDrugstore($data) {
		$query = "  UPDATE `{$this->vaistines_lentele}`
					SET    `pavadinimas`='{$data['pavadinimas']}',
						   `adresas`='{$data['adresas']}',
                                                       `telefono_nr`='{$data['telefono_nr']}',
                                                           `tinklapis`='{$data['tinklapis']}',
                                                               `el_pasto_adresas`='{$data['el_pasto_adresas']}',
                                                                   `darbo_laikas`='{$data['darbo_laikas']}'
                                                           
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Darbuotojo įrašymas
	 * @param type $data
	 */
	public function insertDrugstore($data) {
		$query = "  INSERT INTO `{$this->vaistines_lentele}`
								(	
                                                                        `id`,
									`pavadinimas`,
									`adresas`,
                                                                        `telefono_nr`,
									`tinklapis`,
									`el_pasto_adresas`,
                                                                        `darbo_laikas`
								) 
								VALUES
								(
									'{$data['id']}',
									'{$data['pavadinimas']}',
									'{$data['adresas']}',
                                                                        '{$data['telefono_nr']}',
									'{$data['tinklapis']}',
									'{$data['el_pasto_adresas']}',
                                                                        '{$data['darbo_laikas']}'       
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas darbuotojas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
        public function getDrugstoresCountOforders($id) {
                $query = "  SELECT COUNT(`{$this->uzsakymai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->vaistines_lentele}`
                                                INNER JOIN `{$this->uzsakymai_lentele}`
                                                        ON `{$this->vaistines_lentele}`.`id`=`{$this->uzsakymai_lentele}`.`fk_vaistine`
                                        WHERE `{$this->vaistines_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        }
         public function getDrugstoresCountOfSales($id) {
                $query = "  SELECT COUNT(`{$this->pardavimai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->vaistines_lentele}`
                                                INNER JOIN `{$this->pardavimai_lentele}`
                                                        ON `{$this->vaistines_lentele}`.`id`=`{$this->pardavimai_lentele}`.`fk_vaistine`
                                        WHERE `{$this->vaistines_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        }
         public function getDrugstoresCountOfPayments($id) {
                $query = "  SELECT COUNT(`{$this->mokejimai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->vaistines_lentele}`
                                                INNER JOIN `{$this->mokejimai_lentele}`
                                                        ON `{$this->vaistines_lentele}`.`id`=`{$this->mokejimai_lentele}`.`fk_vaistine`
                                        WHERE `{$this->vaistines_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        } 
               
         public function getDrugstoresCountOfShipments($id) {
                $query = "  SELECT COUNT(`{$this->kroviniai_lentele}`.`id`) AS `kiekis`
                                        FROM `{$this->vaistines_lentele}`
                                                INNER JOIN `{$this->kroviniai_lentele}`
                                                        ON `{$this->vaistines_lentele}`.`id`=`{$this->kroviniai_lentele}`.`fk_vaistine`
                                        WHERE `{$this->vaistines_lentele}`.`id`='{$id}'";
                $data = mysql::select($query);

                return $data[0]['kiekis'];
        }
         public function getDrugstoreReport($data1) {
		$whereClauseString = "";
		if(!empty($data1)) {
			$whereClauseString .= " WHERE `{$this->vaistines_lentele}`.`id`='{$data1}' AND `{$this->vaistininkai_lentele}`.`fk_vaistine`='{$data1}'";

		}
		
		$query = "  SELECT `{$this->vaistininkai_lentele}`.`id`,
						   `{$this->vaistininkai_lentele}`.`vardas`,
                                                       `{$this->vaistininkai_lentele}`.`telefono_nr`,
                                                           `{$this->vaistines_lentele}`.`darbo_laikas`
					FROM `{$this->vaistininkai_lentele}`
						LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->vaistininkai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`
					{$whereClauseString}";
		$data = mysql::select($query);

		return $data;
	}                                                        
          
	
}