<?php
class ModelExtensionModuleProductTyreVariation extends Model {

    public function getProductVariationsByID($productID){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tyre_variation ptv WHERE product_id = " . $productID . " ORDER BY ptv.diameter ASC");
        
        return $query->rows;
    }

    public function getVariationData($productID,$variationID){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tyre_variation ptv WHERE product_id = " . $productID . 
            " AND code = " . $variationID);
        
        return $query->row;
    }

    public function getTyreVariationGroupedByDiameter($productID,$variationsSelected=false){
        $sql = "SELECT * FROM " . DB_PREFIX . "product_tyre_variation ptv WHERE product_id = " . $productID;
        if($variationsSelected){
            $sql .= " AND code in (".$variationsSelected.")";
        }
        $sql .= " ORDER BY ptv.diameter ASC";

        $query = $this->db->query($sql);
        $diameter = 0;
        $variations = [];
        foreach($query->rows as $key => $tyre){
            if(isset($tyre['diameter']) && $tyre['diameter'] != 0){
                if($diameter != $tyre['diameter']){
                    $diameter = $tyre['diameter'];    
                }
            }
            else{
                $tyreSizeOveral = explode('R',$tyre['size_overal']);
                if(isset($tyreSizeOveral[1])){
                    $diameter=$tyreSizeOveral[1];
                }            
            }
            $variations[$diameter][$key] = [
                'size_overal'       => $tyre['size_overal'],
                'load_index'        => $tyre['load_index'],
                'speed'             => $tyre['speed'],
                'wet_grib'          => $tyre['wet_grib'],
                'fuel_efficiency'   => $tyre['fuel_efficiency'],
                'external_rollin'   => $tyre['external_rollin'],
                'season'            => $tyre['season'],
            ];

            if($this->session->data['user_id'] == 1 || $this->session->data['user_id'] == 2 || $this->customer->isLogged()){
                $availability = '<span class="availability-orange">Aπό 12 και κάτω</span>';
                if((int)$tyre['amount'] >= 12){
                    $availability = '<span class="availability-green">ΔΙΑΘΕΣΙΜΑ</span>';
                }
                elseif((int)$tyre['amount'] == 0){
                    $availability = '<span class="availability-red">Κατόπιν Παραγγελίας</span>';
                }

                $price = 'Ρωτήστε μας για την τιμή';
                if((int)$tyre['price']>0){
                    $price = $tyre['price'].'€';
                }
                if( (int)$tyre['price_discount'] != null && (int)$tyre['price_discount'] !=0 && (int)$tyre['price_discount']<(int)$tyre['price']){
                    $price = '<span class="ordinary-price" style="color: red;text-decoration: line-through;margin-right: 10px;">'.$tyre['price'].'€'.'</span> <span class="discount-price" style="font-size: 15px;font-weight: 600;color: #1cb800;">'.$tyre['price_discount'].'€'.'</span>';
                    $discount = (((float)$tyre['price'] - (float)$tyre['price_discount'])*100/(float)$tyre['price']);
                    $price .= ' Έκπτωση '. number_format($discount, 2).'%';
                }
                $variations[$diameter][$key] = array_merge($variations[$diameter][$key],[
                    'availability' => $availability,
                    'price'        => $price,
                ]);
            }

        }
        return $variations;
    }

    public function searchInTyreVariations($width,$height=null,$diameter=null,$productID=null){
        
        $sql =  'SELECT distinct product_id,code FROM oc_product_tyre_variation';
        $sql .= ' WHERE width='.$width;
        if($height){
            $sql .= ' AND height='.$height;
        }
        if($diameter){
            $sql .= ' AND diameter='.$diameter;
        }
        if($productID){
            $sql .= ' AND product_id='.$productID;
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function availableOptions($type,$selectedValues,$productCategory){
        $sql = 'SELECT DISTINCT '.$type.' FROM oc_product_tyre_variation AS vt ';
        
        $whereInserted = false;
        if($productCategory){
            $sql .= 'INNER JOIN oc_product_to_category AS pc ON vt.product_id = pc.product_id ';
            $sql .= 'WHERE pc.category_id = '.$productCategory.' ';
            $whereInserted = true;
        }
        
        foreach ($selectedValues as $name => $value) {
            if($value != ''){

                $queryVal = $value;
                if($name == 'diameter'){
                    $queryVal = '\''.$value.'\'';
                }

                if(!$whereInserted){
                    $whereInserted = true;
                    $sql .= 'WHERE '.$name.'='.$queryVal;
                }
                else{
                    $sql .= ' AND vt.'.$name.'='.$queryVal;
                }
            }
        }

        $sql .= ' ORDER BY vt.'.$type;
        $query = $this->db->query($sql);
    
        return $query->rows;  
    }
}