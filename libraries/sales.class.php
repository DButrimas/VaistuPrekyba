<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class sales {
	
	private $pardavimai_lentele = '';
	private $vaistininkai_lentele = '';
	private $vaistines_lentele = '';
        private $pardavimai_detales_lentele = '';
        private $vaistai_lentele = '';
	public function __construct() {
		$this->pardavimai_lentele = config::DB_PREFIX . 'pardavimai';
		$this->vaistininkai_lentele = config::DB_PREFIX . 'vaistininkai';
                $this->vaistines_lentele = config::DB_PREFIX . 'vaistines';
                $this->pardavimai_detales_lentele = config::DB_PREFIX . 'pardavimu_detales';
                $this->vaistai_lentele = config::DB_PREFIX . 'vaistai';
	}
	
	/**
	 * Modelio išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getSale($id) {
		$query = "  SELECT *
					FROM `{$this->pardavimai_lentele}`
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
	public function getSalestList($limit = null, $offset = null) {
				$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT `{$this->vaistines_lentele}`.`pavadinimas`AS `vaistine`,
                    `{$this->pardavimai_lentele}`.`id` AS `parid`,
						   `{$this->vaistininkai_lentele}`.`vardas`AS`vaistininkas`,
                                                       `{$this->pardavimai_lentele}`.`data`,
                                                       `{$this->vaistai_lentele}`.`vaisto_pavadinimas`AS`vaistas`,
                                                            `{$this->pardavimai_detales_lentele}`.`vieneto_kaina`AS`kaina`,
                                                                `{$this->pardavimai_detales_lentele}`.`kiekis`AS`kiekis`,
                                                                    `{$this->pardavimai_detales_lentele}`.`detales_id`AS`detid`,
                                                                           `{$this->pardavimai_lentele}`.`bendra_suma`AS`suma`                                                        
					FROM `{$this->pardavimai_lentele}`
                                                LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->pardavimai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`           
                                                LEFT JOIN `{$this->pardavimai_detales_lentele}`
							ON `{$this->pardavimai_lentele}`.`id`=`{$this->pardavimai_detales_lentele}`.`pardavimas`   
                                                LEFT JOIN `{$this->vaistai_lentele}`
							ON `{$this->pardavimai_detales_lentele}`.`vaistas`=`{$this->vaistai_lentele}`.`id` 
						LEFT JOIN `{$this->vaistininkai_lentele}`
							ON `{$this->pardavimai_lentele}`.`fk_vaistininkas`=`{$this->vaistininkai_lentele}`.`id`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}
         public function getSaleDetails($saleId) {
		$query = "  SELECT *
					FROM `{$this->pardavimai_detales_lentele}`
					WHERE `pardavimas`='{$saleId}'";
		$data = mysql::select($query);
		
		return $data;
	}
        
        
        
	/**
	 * Modelių kiekio radimas
	 * @return type
	 */
	public function getSalesListCount() {
		$query = "  SELECT COUNT(`{$this->pardavimai_lentele}`.`id`) as `kiekis`
					FROM `{$this->pardavimai_lentele}`
                                            LEFT JOIN `{$this->pardavimai_detales_lentele}`
							ON `{$this->pardavimai_lentele}`.`id`=`{$this->pardavimai_detales_lentele}`.`pardavimas`";
                                        
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
        public function deleteSaleDatails($saleId) {
		$query = "  DELETE FROM `{$this->pardavimai_detales_lentele}`
					WHERE `pardavimas`='{$saleId}'";
		mysql::query($query);
	}
         public function deleteSale($saleId) {
		$query = "  DELETE FROM `{$this->pardavimai_lentele}`
					WHERE `id`='{$saleId}'";
		mysql::query($query);
	}
	
	/**
	 * Modelio atnaujinimas
	 * @param type $data
	 */
	public function updateSale($data) {
		$query = "  UPDATE `{$this->pardavimai_lentele}`
					SET    `fk_vaistine`='{$data['fk_vaistine']}',
                                            `fk_vaistininkas`='{$data['fk_vaistininkas']}',
						   `bendra_suma`='{$data['bendra_suma']}',
                                                       `data`='{$data['data']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}
        public function updateSaleDetails($data) {
            $this->deleteSaleDatails($data['id']);
            
            foreach($data['vaistai'] as $key=>$val) {
                $query = "  INSERT INTO `{$this->pardavimai_detales_lentele}`
										(
											`vaistas`,
											`detales_id`,
											`pardavimas`,
											`kiekis`,
											`vieneto_kaina`
										)
										VALUES
										(
											'{$val}',
											'{$data['detales_id'][$key]}',
											'{$data['id']}',
											'{$data['kiekis'][$key]}',
											'{$data['vieneto_kaina'][$key]}'
										)";
		mysql::query($query);
	}
        }
	
	/**
	 * Modelio įrašymas
	 * @param type $data
	 */
	public function insertSale($data) {
		$query = "  INSERT INTO `{$this->pardavimai_lentele}`
								(
                                                                        `fk_vaistine`,
									`fk_vaistininkas`,
                                                                        `bendra_suma`,
									`id`,
                                                                        `data`
								)
								VALUES
								(
                                                                        '{$data['fk_vaistine']}',
									'{$data['fk_vaistininkas']}',
                                                                        '{$data['bendra_suma']}',
									'{$data['id']}',
                                                                        '{$data['data']}'
								)";
		mysql::query($query);
	}
        public function insertSaleDetails($data,$isiminti) {
		//if(isset($data['vaistas']) && isset($data['detales_id']) && isset($data['kiekis']) && isset($data['vieneto_kaina']) &&  isset($isiminti['id']) && sizeof($data['detales_id']) > 0) {
			foreach($data['vaistai'] as $key=>$val) {
				//if($data['neaktyvus'] == array() || $data['neaktyvus'][$key] == 0) {
					$query = "  INSERT INTO `{$this->pardavimai_detales_lentele}`
											(
												`vaistas`,
												`detales_id`,
												`pardavimas`,
                                                                                                `kiekis`,
                                                                                                `vieneto_kaina`
											)
											VALUES
											(
                                                                                                '{$val}',
												'{$data['detales_id'][$key]}',
                                                                                                '{$isiminti}',
                                                                                                '{$data['kiekis'][$key]}',
                                                                                                '{$data['vieneto_kaina'][$key]}'
												
											)";
					mysql::query($query);
				}
			
                        }
                        
               // }
        
                                                                                                
                                                                                                
                                                                                                
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
						INNER JOIN `{$this->vaistininkai_lentele}`
							ON `{$this->vaistininkai_lentele}`.`id`=`{$this->vaistines_lentele}`.`id`
					WHERE `{$this->vaistininkai_lentele}`.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
         public function getDrugStoreSales($dateFrom, $dateTo) {
		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->pardavimai_lentele}`.`data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->pardavimai_lentele}`.`data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->pardavimai_lentele}`.`data`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT `{$this->pardavimai_lentele}`.`id`,
						   `{$this->pardavimai_lentele}`.`data`,
                                                       `{$this->vaistines_lentele}`.`pavadinimas`,
                                                           `{$this->vaistai_lentele}`.`vaisto_pavadinimas`,
						   `{$this->pardavimai_detales_lentele}`.`kiekis`,
						   sum(`{$this->pardavimai_detales_lentele}`.`kiekis`*`{$this->pardavimai_detales_lentele}`.`vieneto_kaina`) AS `bendra_suma`
					FROM `{$this->pardavimai_detales_lentele}`
						LEFT JOIN `{$this->pardavimai_lentele}`
							ON `{$this->pardavimai_detales_lentele}`.`pardavimas`=`{$this->pardavimai_lentele}`.`id`
						LEFT JOIN `{$this->vaistai_lentele}`
							ON `{$this->pardavimai_detales_lentele}`.`vaistas`=`{$this->vaistai_lentele}`.`id`
                                                            LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->pardavimai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`
					{$whereClauseString}
					GROUP BY `{$this->pardavimai_detales_lentele}`.`detales_id` ORDER BY `bendra_suma` DESC";
		$data = mysql::select($query);

		return $data;
	}                 
         public function getDrugStoreSales2($dateFrom, $dateTo) {
		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->pardavimai_lentele}`.`data`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->pardavimai_lentele}`.`data`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->pardavimai_lentele}`.`data`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT `{$this->pardavimai_lentele}`.`id`,
						   `{$this->pardavimai_lentele}`.`data`,
                                                       `{$this->vaistines_lentele}`.`pavadinimas`,
                                                           `{$this->vaistai_lentele}`.`vaisto_pavadinimas`,
						   sum(`{$this->pardavimai_detales_lentele}`.`kiekis`) AS `kiekis`,
						   sum(`{$this->pardavimai_detales_lentele}`.`kiekis`*`{$this->pardavimai_detales_lentele}`.`vieneto_kaina`) AS `bendra_suma`
					FROM `{$this->pardavimai_detales_lentele}`
						LEFT JOIN `{$this->pardavimai_lentele}`
							ON `{$this->pardavimai_detales_lentele}`.`pardavimas`=`{$this->pardavimai_lentele}`.`id`
						LEFT JOIN `{$this->vaistai_lentele}`
							ON `{$this->pardavimai_detales_lentele}`.`vaistas`=`{$this->vaistai_lentele}`.`id`
                                                            LEFT JOIN `{$this->vaistines_lentele}`
							ON `{$this->pardavimai_lentele}`.`fk_vaistine`=`{$this->vaistines_lentele}`.`id`
					{$whereClauseString}";
		$data = mysql::select($query);

		return $data;
	}                      
	
	
}