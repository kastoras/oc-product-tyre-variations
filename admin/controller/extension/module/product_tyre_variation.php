<?php
class ControllerExtensionModuleProductTyreVariation extends Controller
{

    private $error = array();

    public function index()
    {
        $this->load->language('extension/module/product_tyre_variation'); // load the language

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/module'); // loads the model

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('product_tyre_variation', $this->request->post); // adds a new module
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post); // edits a pre-existing module
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_type'] = $this->language->get('entry_type');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['module_types'] = [
            '' => $this->language->get('default'),
            'search_passenger' => $this->language->get('passenger')
        ];

        $this->load->model('catalog/category');
        $poductCategories = $this->model_catalog_category->getCategories();
        $data['product_categories'] = [];
        foreach ($poductCategories as $category) {
            $data['product_categories'][$category['category_id']] = $category['name'];
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['message'])) {
            $data['error_message'] = $this->error['message'];
        } else {
            $data['error_message'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], 'SSL')
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/product_tyre_variation', 'user_token=' . $this->session->data['user_token'], 'SSL')
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/product_tyre_variation', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/product_tyre_variation', 'user_token=' . $this->session->data['user_token'], 'SSL');
        } else {
            $data['action'] = $this->url->link('extension/module/product_tyre_variation', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
        }

        $data['cancel'] = $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], 'SSL');

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->request->post['m_type'])) {
            $data['m_type'] = $this->request->post['m_type'];
        } elseif (!empty($module_info)) {
            $data['m_type'] = $module_info['m_type'];
        } else {
            $data['m_type'] = '';
        }

        if (isset($this->request->post['pc_selected'])) {
            $data['pc_selected'] = $this->request->post['pc_selected'];
        } elseif (!empty($module_info)) {
            $data['pc_selected'] = $module_info['pc_selected'];
        } else {
            $data['pc_selected'] = '';
        }


        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/ptv/product_tyre_variation', $data));
    }

    public function loadTyreVariations($productId)
    {
        $this->load->model('extension/module/product_tyre_variation');
        $this->load->language('extension/module/product_tyre_variation'); // load the language

        $this->document->addStyle('view/javascript/ptv/product_tyre_variations_product_edit/css/dataTables.bootstrap4.min.css');
        $this->document->addStyle('view/javascript/ptv/product_tyre_variations_product_edit/css/tyre-variations-edit-styles.css');

        $this->document->addScript('../system/javascript_libs/vue.min.js');
        $this->document->addScript('../system/javascript_libs/vue-router.min.js');
        $this->document->addScript('../system/javascript_libs/vuex.min.js');
        $this->document->addScript('../system/javascript_libs/vuejs-datatable.js');
        $this->document->addScript('../system/javascript_libs/bootstrap-3.js');

        $data['variations'] = $this->model_extension_module_product_tyre_variation->getProductVariations($productId[0]);

        return $this->load->view('extension/module/ptv/product_tyre_variations_product_edit', $data);
    }

    public function saveChangeAsync()
    {
        $this->load->model('extension/module/product_tyre_variation');
        $formData = $resultData = [];

        if (isset($_GET['product_id'])) {
            $formData['product_id'] = $_GET['product_id'];
        }

        foreach (json_decode($_GET['formdata']) as $key => $value) {
            $formData[$key] = $value;
        }

        if ($this->model_extension_module_product_tyre_variation->insertUpdateVariation($formData)) {
            $resultData = [
                'message' => 'Value inserted/edited corectly'
            ];
        } else {
            $resultData = [
                'message' => 'Error'
            ];
        }

        echo json_encode($resultData, JSON_HEX_QUOT | JSON_HEX_TAG);
        exit();
    }

    public function deleteVariationAsync()
    {
        $this->load->model('extension/module/product_tyre_variation');

        if (isset($_GET['code']) && isset($_GET['product_id'])) {
            $deleteValue = $this->model_extension_module_product_tyre_variation->deleteVariation($_GET['code'], $_GET['product_id']);
            if ($deleteValue) {
                echo json_encode(['message' => 'Ολοκληρώθηκε η Διαγραφή Διάστασης'], JSON_HEX_QUOT | JSON_HEX_TAG);
            }
            exit();
        }
    }

    public function getVariationsAsync()
    {

        $this->load->model('extension/module/product_tyre_variation');

        $variations = $this->model_extension_module_product_tyre_variation->getProductVariations($_GET['product_id']);

        $data = [];
        foreach ($variations->rows as $key => $variation) {
            $data[] = [
                'code' => $variation['code'],
                'width' => $variation['width'],
                'height' => $variation['height'],
                'diameter' => $variation['diameter'],
                'price' => $variation['price'],
                'price_discount' => $variation['price_discount'],
                'amount' => $variation['amount'],
                'tyre_class' => $variation['tyre_class'],
                'speed' => $variation['speed'],
                'load_index' => $variation['load_index'],
                'wet_grib' => $variation['wet_grib'],
                'fuel_efficiency' => $variation['fuel_efficiency'],
                'external_rollin' => $variation['external_rollin'],
                'season' => $variation['season'],
                'weight' => $variation['weight'],
                'size_overal' => $variation['size_overal'],
            ];
        }

        echo json_encode(['data' => $data], JSON_HEX_QUOT | JSON_HEX_TAG);
        exit();
    }

    public function parseCsv()
    {

        $this->load->model('catalog/product');
        $this->load->model('catalog/manufacturer');

        $filename = '../basictyres.csv';
        $delimiter = ';';

        if (!file_exists($filename) || !is_readable($filename)) {
            echo 'file problem';
            return false;
        }

        $header = NULL;
        $tyres = $inserted = 0;
        if (($handle = fopen($filename, 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                $tyres++;
                if (!$header) {
                    $header = $row;
                } else {

                    if (isset($row[3]) && $row[3] != '') {
                        $model = strtolower($row[3]);
                        $model = str_replace('-', '', $model);
                        $model = str_replace('/', '', $model);
                        $model = str_replace('+', '', $model);
                        $model = str_replace(' ', '', $model);
                        $model = str_replace(',', '', $model);
                    } else {
                        continue;
                    }

                    $manufacturer = $this->model_catalog_manufacturer->getManufacturerByName($row[2]);
                    if (!empty($manufacturer) && isset($manufacturer['manufacturer_id'])) {
                        $manufacturer_id = (int)$manufacturer['manufacturer_id'];
                    } else {
                        continue;
                    }

                    if (isset($row[3]) && $row[3] != '') {
                        $productSeoUrl = strtolower($row[3]);
                        $productSeoUrl = str_replace('/', '-', $model);
                        $productSeoUrl = str_replace('+', '-', $model);
                        $productSeoUrl = str_replace(' ', '-', $model);
                        $productSeoUrl = str_replace(',', '-', $model);
                    } else {
                        continue;
                    }

                    //$image = 'catalog/tyres/'.$model.'1.png';

                    //@TODO
                    if ($row[1] == 'ΕΠΙΒΑΤΙΚΑ') {
                        $category = [63];
                        if ($row[2] == 'KAMA') {
                            $manufacturer = 11;
                        }
                    } elseif ($row[1] == 'ΗΜΙΦΟΡΤΗΓΑ') {
                        $category = [64];
                    } elseif ($row[1] == 'ΧΩΜΑΤΟΥΡΓΙΚΑ') {
                        $category = [66];
                        if ($row[2] == 'KAMA') {
                            $manufacturer = 14;
                        }
                    } elseif ($row[1] == 'ΦΟΡΤΗΓΑ-ΛΕΩΦΟΡΕΙΑ') {
                        $category = [65];
                        if ($row[2] == 'KAMA') {
                            $manufacturer = 14;
                        }
                    } else {
                        continue;
                    }

                    $image1 = $image2 = $image3 = 'default.jpg';

                    if (isset($row[6])) {
                        $image1 = 'catalog/tyres/' . $row[6];
                    }
                    if (isset($row[7])) {
                        $image2 = $row[7];
                    }
                    if (isset($row[8])) {
                        $image3 = $row[8];
                    }

                    $productDescription[1] = [
                        'name' => $row[3],
                        'description' => '',
                        'meta_title' => 'Ελαστικά Petrana | Ελαστικό για ' . strtolower($row[1]) . ' ' . $row[3],
                        'meta_description' => '',
                        'meta_keyword' => '',
                        'tag' => ''
                    ];

                    $productData = [
                        'model'             => $model,
                        'sku'               => '',
                        'upc'               => '',
                        'ean'               => '',
                        'jan'               => '',
                        'isbn'              => '',
                        'mpn'               => '',
                        'location'          => '',
                        'quantity'          => 1,
                        'minimum'           => 1,
                        'subtract'          => 0,
                        'stock_status_id'   => 5,
                        'date_available'    => '2020-01-01',
                        'manufacturer_id'   => $manufacturer_id,
                        'shipping'          => 1,
                        'price'             => 0.0,
                        'points'            => 0,
                        'weight'            => 0.0,
                        'weight_class_id'   => 1,
                        'length'            => 0.0,
                        'width'             => 0.0,
                        'height'            => 0.0,
                        'length_class_id'   => 1,
                        'status'            => 1,
                        'tax_class_id'      => 1,
                        'sort_order'        => 0,
                        'image'             => $image1,
                        'product_store'     => [0 => 0],
                        'product_image'     => [
                            ['image' => 'catalog/tyres/' . $image2, 'sort_order' => 0],
                            ['image' => 'catalog/tyres/' . $image3, 'sort_order' => 0]
                        ],
                        'product_category'  => $category,
                        'product_seo_url'   => [
                            0 => [
                                1 => $productSeoUrl
                            ]
                        ],
                        'product_description' => $productDescription
                    ];

                    $inserted++;
                    //var_dump($productData);
                    $this->model_catalog_product->addProduct($productData);
                    //$data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        echo 'Tyres' . $tyres . '<br>';
        echo 'Inserted:' . $inserted;
    }

    public function parseTyreVariations()
    {

        $this->load->model('catalog/product');
        $this->load->model('extension/module/product_tyre_variation');


        $this->parseSoftOneFile();
    }

    private function parseKamaFile()
    {

        $filename = '../tyre-variations.csv';
        $delimiter = ';';



        if (!file_exists($filename) || !is_readable($filename)) {
            echo 'file problem';
            return false;
        }

        $header = NULL;
        $data = array();
        $line = 0;
        if (($handle = fopen($filename, 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                $line++;

                if (!$header) {
                    $header = $row;
                } else {

                    if (isset($row[3]) && $row[3] != '') {
                        echo '<br>------' . $line . '-----<br>';
                        echo '<br>Name:' . $row[3] . '<br>';
                        if ($productID = $this->model_catalog_product->getProductIdByName($row[3])) {




                            $variation = [
                                'product_id'        => $productID,
                                'code'              => '',
                                'width'             => '',
                                'height'            => '',
                                'diameter'          => '',
                                'price'             => '',
                                'amount'            => '',
                                'tyre_class'        => '',
                                'speed'             => '',
                                'wet_grib'          => '',
                                'fuel_efficiency'   => '',
                                'external_rollin'   => '',
                                'season'            => '',
                                'weight'            => '',

                            ];
                        }
                    }
                }
            }
        }
    }

    private function parseSoftOneFile()
    {

        $filename = '../tyre-variations-softone-edit.csv';
        $delimiter = ';';


        if (!file_exists($filename) || !is_readable($filename)) {
            echo 'file problem';
            return false;
        }

        $header = NULL;

        $line = 0;
        $inserted = 0;
        $abortedOnInsert = 0;
        $abortedData = 0;
        $parsed = 0;
        if (($handle = fopen($filename, 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                $line++;

                if (!$header) {
                    $header = $row;
                } else {

                    $separateInfo = explode('|', $row[2]);
                    if (count($separateInfo) != 2) {
                        $abortedData++;
                        continue;
                    }

                    $sizeOveral = $separateInfo[0];
                    $name = $separateInfo[1];

                    $width = $height = $diameter = null;

                    if (strpos($sizeOveral, 'R') !== false) {
                        if ($tyreBasic = $this->seperateWidthHeightDiameter($sizeOveral)) {
                            $width = $tyreBasic['width'];
                            $height = $tyreBasic['height'];
                            $diameter = $tyreBasic['diameter'];
                        }
                    }

                    echo '<br>------' . $line . '-----<br>';
                    echo '<br>Info All:' . $row[2] . '<br>';
                    echo '<br>Name:' . $name . '<br>';
                    echo '<br>width:' . $width . '<br>';
                    echo '<br>height:' . $height . '<br>';
                    echo '<br>diameter:' . $diameter . '<br>';
                    echo '<br>sizeOveral:' . $sizeOveral . '<br>';

                    $price = null;
                    if (isset($row[3]) && $row[3] != '') {
                        $price = (float)$row[3];
                    }

                    $amount = 0;
                    if (isset($row[5]) && $row[5] != '') {
                        $amount = (int)$row[5];
                    }

                    $speed = '';
                    if (isset($row[7]) && $row[7] != '') {
                        $speed = $row[7];
                    }

                    $wetGrid = '';
                    if (isset($row[9]) && $row[9] != '') {
                        $wetGrid = $row[9];
                    }

                    $fuelEfficiency = '';
                    if (isset($row[10]) && $row[10] != '') {
                        $fuelEfficiency = $row[10];
                    }

                    $externalRollin = null;
                    if (isset($row[11]) && $row[11] != '') {
                        $externalRollin = $row[11];
                    }

                    $season = '';
                    if (isset($row[12]) && $row[12] != '') {
                        $season = $row[12];
                    }

                    $weight = '';
                    if (isset($row[13]) && $row[13] != '') {
                        $weight = (float)$row[13];
                    }

                    if ($productID = $this->model_catalog_product->getProductIdByName($name)) {

                        $variation = [
                            'product_id'        => $productID,
                            'code'              => $row[1],
                            'width'             => $width,
                            'height'            => $height,
                            'diameter'          => $diameter,
                            'size_overal'       => $sizeOveral,
                            'price'             => $price,
                            'amount'            => $amount,
                            'tyre_class'        => '',
                            'speed'             => $speed,
                            'wet_grib'          => $wetGrid,
                            'fuel_efficiency'   => $fuelEfficiency,
                            'external_rollin'   => $externalRollin,
                            'season'            => $season,
                            'weight'            => $weight,

                        ];

                        if ($this->model_extension_module_product_tyre_variation->insertNewVariation($variation)) {
                            $inserted++;
                        } else {
                            $abortedOnInsert++;
                        }
                    } else {
                        continue;
                    }
                }
            }
        }
        echo '<br>-------------<br>inserted:' . $inserted;
        echo '<br>-------------<br>abortedOnInsert:' . $abortedOnInsert;
        echo '<br>-------------<br>abortedOnInsert:' . $parsed;
    }

    private function seperateWidthHeightDiameter($widthHeightDiameter)
    {

        $widthHeightDiameterArray = explode('/', $widthHeightDiameter);
        $width = $widthHeightDiameterArray[0];

        if (!isset($widthHeightDiameterArray[1])) {
            return false;
        }
        if (strpos($widthHeightDiameterArray[1], 'R') === false) {
            return false;
        }
        $heightDiameter = explode('R', $widthHeightDiameterArray[1]);
        $height = $heightDiameter[0];
        $diameter = $heightDiameter[1];

        return [
            'width'     => $width,
            'height'    => $height,
            'diameter'  => $diameter,
        ];
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/product_tyre_variation')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }
}
