<?php
class ModelExtensionModuleProductTyreVariation extends Model {

    public function install() {
        $this->db->query("
            CREATE TABLE `" . DB_PREFIX . "product_tyre_variation`
            (
                `product_id` INT(11) NOT NULL,
                `code` VARCHAR(50) NOT NULL,
                `width` INT(11) NULL DEFAULT NULL,
                `height` INT(11) NULL DEFAULT NULL,
                `diameter` VARCHAR(5) NULL DEFAULT NULL,
                `price` DECIMAL(10,2) NULL DEFAULT NULL,
                `price_discount` DECIMAL(10,2) DEFAULT NULL,
                `amount` INT(11) NULL DEFAULT NULL,
                `tyre_class` VARCHAR(50) NULL DEFAULT NULL,
                `load_index` VARCHAR(5) DEFAULT NULL
                `speed` VARCHAR(3) NULL DEFAULT NULL,
                `wet_grib` CHAR(1) NULL DEFAULT NULL,
                `fuel_efficiency` CHAR(1) NULL DEFAULT NULL,
                `external_rollin` INT(11) NULL DEFAULT NULL,
                `season` VARCHAR(10) NULL DEFAULT NULL,
                `weight` DECIMAL(10,3) NULL DEFAULT NULL,
                `size_overal` VARCHAR(30) NULL DEFAULT NULL,

                PRIMARY KEY(`product_id`, `code`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;"
        );
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_tyre_variation`;");
    }
    
    public function insertUpdateVariation($data){

        try{           
            ((float)$data['price_discount'] == 0.00) ? $discountPrice = '' : $discountPrice = (float)$data['price_discount'];
             
            $inserted = $this->db->query(
                "REPLACE INTO " . DB_PREFIX . "product_tyre_variation SET 
                    product_id = '" . (int)$data['product_id'] . "',
                    code = '" . $data['code'] . "',
                    width = '" . (int)$data['width'] . "',
                    height = '" . (int)$data['height'] . "',
                    diameter = '" . $data['diameter'] . "',
                    size_overal = '" . $data['size_overal'] . "',                    
                    price = '" . (float)$data['price'] . "',
                    price_discount = '" . $discountPrice . "',
                    amount = '" . (int)$data['amount'] . "',
                    tyre_class = '" . $data['tyre_class'] . "',
                    speed = '" . $data['speed'] . "',
                    load_index = '" . $data['load_index'] . "',
                    wet_grib = '" . $data['wet_grib'] . "',
                    fuel_efficiency = '" . $data['fuel_efficiency'] . "',
                    external_rollin = '" . (int)$data['external_rollin'] . "',
                    season = '" . $data['season'] . "',
                    weight = '" . (float)$data['weight'] . "'"
            );        

            return $inserted;
        }
        catch(Exception $e){
            return false;
            //dd($ex->getMessage()); 
        }
        
    }

    public function deleteVariation($code,$product_id){
        return $this->db->query("DELETE FROM " . DB_PREFIX . "product_tyre_variation WHERE product_id = '" . (int)$product_id . "' AND code = '" . $code . "'");
    }    

    public function getProductVariations($ocProductId){
        return $this->db->query('SELECT * FROM '.DB_PREFIX .'product_tyre_variation WHERE product_id='. $ocProductId .' ORDER BY product_id');
    }

}
