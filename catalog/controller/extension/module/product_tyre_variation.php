<?php 
class ControllerExtensionModuleProductTyreVariation extends Controller {

    public function __construct($params){
        parent::__construct($params);
        $this->load->model('extension/module/product_tyre_variation');
    }

    public function index($setting) {

        $this->document->addStyle('catalog/view/javascript/ptv/search-engine.css');

        $this->document->addScript('../system/javascript_libs/vue.js');
        $this->document->addScript('../system/javascript_libs/vuex.js'); 
        $this->document->addScript('../system/javascript_libs/axios.js'); 

        $layout = $setting['m_type'];

        $data['title'] = $setting['name'];
        $data['status'] = $setting['status'];

        $data['productcategory'] = 'none';
        if(isset($setting['pc_selected']) && $setting['pc_selected'] != ''){
            $data['productcategory'] = $setting['pc_selected'];
        }
        
		return $this->load->view('extension/module/ptv/'.$layout, $data);
    }

    public function showTyreVariations($request){
        
        $userLoged = $this->customer->isLogged();
        if( isset($userLoged) && $userLoged != NULL ){
            $data['user'] = $userLoged;
        }

        $variationCodes = null;
        if($request['search'] && $request['product_id']){
            $searchedVariations = $this->tyreVariationQuickSearch($request);

            $variationCodes = '';
            foreach($searchedVariations["products_variations"][$request['product_id']] as $variation){
                $variationCodes .= $variation.',';
            }
            $variationCodes = substr($variationCodes, 0, -1);
        }
        
		$this->document->addStyle('catalog/view/javascript/ptv/styles.min.css');
		$this->document->addScript('catalog/view/javascript/ptv/scripts.js');        

        $data['variations'] = $this->model_extension_module_product_tyre_variation->getTyreVariationGroupedByDiameter($request['product_id'],$variationCodes);

        $data['tax_label']='';
        if($this->session->data['user_id'] == 1 || $this->session->data['user_id'] == 2 || $this->customer->isLogged()){
            $data['tax_label'] ='* Στις τιμές περιλαμβάνεται ΦΠΑ 24% & εισφορά.';
        }
        
        if(isset($_GET['search'])){
            $data['tpv_all'] = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        }
        
        return $this->load->view('extension/module/ptv/product_tyre_variation', $data);
    }

    public function tyreVariationQuickSearch($data){

        $searchDimension = $data['search'];
        $searchProductIdVariation = null;
        if(isset($data['product_id'])){
            $searchProductIdVariation = $data['product_id'];
        }

        if(preg_match('/[0-9][0-9][0-9]\/[0-9][0-9]\/(?:.+)/',$searchDimension)){
            $search_arr  = explode('/', $searchDimension);
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($search_arr[0], $search_arr[1],$search_arr[2], $searchProductIdVariation);
        }
        elseif(preg_match('/[0-9][0-9][0-9]\/[0-9][0-9]R(?:.+)/',$searchDimension)){
            $search_arr  = explode('/', $searchDimension);
            $search_arr_sec  = explode('R', $search_arr[1]);
            if(sizeof($search_arr_sec) != 2){
                $search_arr_sec  = explode('r', $search_arr[1]);
            }
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($search_arr[0], $search_arr_sec[0],$search_arr_sec[1], $searchProductIdVariation); 
        }
        elseif(preg_match('/[0-9][0-9][0-9]-[0-9][0-9]-(?:.+)/',$searchDimension)){
            $search_arr  = explode('-', $searchDimension);
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($search_arr[0], $search_arr[1],$search_arr[2], $searchProductIdVariation);  
        }
        elseif(preg_match('/[0-9][0-9][0-9]-[0-9][0-9]$/',$searchDimension)){
            $search_arr  = explode('-', $searchDimension);
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($search_arr[0], $search_arr[1],null, $searchProductIdVariation);              
        }
        elseif(preg_match('/[0-9][0-9][0-9]\/[0-9][0-9]$/',$searchDimension)){
            $search_arr  = explode('/', $searchDimension);
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($search_arr[0], $search_arr[1],null, $searchProductIdVariation);            
        }
        elseif(preg_match('/[0-9][0-9][0-9]/',$searchDimension)){
            $product_total = $this->model_extension_module_product_tyre_variation->searchInTyreVariations($searchDimension,null,null,$searchProductIdVariation); 
        }
        else{
            return false;
        }                                

        if(!empty($product_total)){
            $product_ids_string = '';
            $product_variations = [];
            foreach ($product_total as $key => $product) {
                $product_ids_string .= $product['product_id'].',';
                $product_variations[$product['product_id']][] = $product['code'];
            }

            return [
                'products_ids' => substr($product_ids_string, 0, -1),
                'products_variations' => $product_variations
            ];
        }

        return false;
    }

    public function tyreVariationCompleteSearch(){
        $datatyre = array(
            'manufacturer_id'     => '', 
            'type'                => '', 
            'width'               => $width,
            'height'              => $height,
            'diameter'            => $diameter,
            'speed'               => '',
            'eco'                 => '',
            'db'                  => '',
            'cudisfr'             => '',
            'reforz'              => '',
            'antiflat'            => '',
            'loadindex'           => '',
            'rd'                  => '',
            'sort'                => '',
            'order'               => '',
            'start'               => '',
            'limit'               => ''
        );     
    }

    public function getAvailablePassengerTyresSelectOptionsAsync(){ 

        $selectedValues = [];
        if(isset($_GET["selected_vales"])){
            $selectedValues = json_decode($_GET["selected_vales"]);
        }

        $this->load->model('extension/module/product_tyre_variation');

        $productCategory = false;
        if(isset($this->request->get['product_category']) && $this->request->get['product_category'] !='none'){
            $productCategory = $this->request->get['product_category'];
        }
        $data = $this->model_extension_module_product_tyre_variation->availableOptions($this->request->get['measurment_type'], $selectedValues, $productCategory);

        $availableOptions = [];
        foreach ($data as $key => $option) {
            $availableOptions[] = $option[$this->request->get['measurment_type']];
        }

        header('Content-Type: application/json');
        echo json_encode(['data'=>$availableOptions], JSON_HEX_QUOT | JSON_HEX_TAG);
        exit();                
    }    
}