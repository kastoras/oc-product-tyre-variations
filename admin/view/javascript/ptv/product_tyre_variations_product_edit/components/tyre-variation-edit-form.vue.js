export default Vue.component('v-tyre-variation-edit-form', {  
    template: `
        <div>
            <div class="header">            
                <h4 class="title">Επεξεργασία Διάστασης {{selected_variation.width}}/{{selected_variation.height}}R{{selected_variation.diameter}}</h4>
            </div>

            <div>
                <form class="container-fluid" id="add-variation-form">          
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Κωδικός</span>
                                <input type="text" class="form-control" name="code" value="" v-model="selected_variation.code">
                            </div>   
                        </div>                
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Πλάτος</span>
                                <input type="text" class="form-control" name="width" value="" v-model="selected_variation.width">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Ύψος</span>
                                <input type="text" class="form-control" name="height" value="" v-model="selected_variation.height">
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Διάμετρος</span>
                                <input type="text" class="form-control" value="" v-model="selected_variation.diameter">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Διάσταση Ολικό</span>
                                <input type="text" class="form-control" name="size_overal" value="" v-model="selected_variation.size_overal">
                            </div>
                        </div>                                              
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Τιμή</span>
                                <input type="text" class="form-control" name="price" value="" v-model="selected_variation.price">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Εκπτωτική Τιμή</span>
                                <input type="text" class="form-control" name="price_discount" value="" v-model="selected_variation.price_discount">
                            </div>
                        </div>       
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Ποσότητα</span>
                                <input type="text" class="form-control" name="amount" value="" v-model="selected_variation.amount">
                            </div>
                        </div>                                       
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Σεζόν</span>
                                <select class="form-control" name="season" v-model="selected_variation.season">
                                    <option value="Summer">Summer</option>
                                    <option value="Winter">Winter</option>
                                    <option value="All">All Season</option>
                                </select>                                
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Υγρό Οδόστρωμα</span>                                
                                <select class="form-control" name="wet_grib" v-model="selected_variation.wet_grib">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Καύσιμα</span>
                                <select class="form-control" name="fuel_efficiency" v-model="selected_variation.fuel_efficiency">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>                                    
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Ήχος</span>
                                <input type="text" class="form-control" value="" v-model="selected_variation.external_rollin">
                            </div>
                        </div> 
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Δείκτης Ταχύτητας</span>
                                <input type="text" class="form-control" name="speed" value="" v-model="selected_variation.speed">
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Δείκτης Φορτίου</span>
                                <input type="text" class="form-control" name="load_index" value="" v-model="selected_variation.load_index">
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Class</span>
                                <input type="text" class="form-control" name="tyre_class" value="" v-model="selected_variation.tyre_class">
                            </div>
                        </div>    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Βάρος</span>
                                <input type="text" class="form-control" name="weight" value="" v-model="selected_variation.weight">
                            </div>
                        </div>                                                                    
                    </div>
                </form>                
            </div>            
            
            <div>
                <div class="form-group col-md-12">
                    <button @click="saveTyreVariation" type="button" class="btn btn-primary submit-add-btn">Αποθήκευση</button>
                    <router-link to="/" tag="button" class="btn btn-warning">Επιστροφή</router-link>
                    <button @click="cancelChanges" type="button" class="btn btn-danger">Άκυρο</button>
                </div>
            </div>
        </div>
    `, 
    data() {
        return {
            basic_url_data : '',
            selected_variation: ''
        }
    },
    created() {
        this.basic_url_data =  this.$store.getters.getBasicUrlData;
        this.selected_variation =  this.$store.getters.getSelectedVariation;
    },
    methods: {
        saveTyreVariation() {

            var url = new URL(this.basic_url_data.site_url+ 'index.php')

            var params = {
                route: 'extension/module/product_tyre_variation/saveChangeAsync',
                user_token: this.basic_url_data.token,
                product_id: this.basic_url_data.product_id,
                formdata: JSON.stringify(this.selected_variation)
            }
            
            url.search = new URLSearchParams(params).toString();
                
            fetch(url)
            .then(res => res.json())
            .then(data => {
                alert('Η αλλαγή ολοκληρώθηκε με επιτυχία.');
                this.$router.push('/');
            })
            .catch((error) => {
                alert('Εμφανίστηκε κάποιο πρόβλημα με την αποθήκευση.');
            });           
        },
        cancelChanges() {
            this.selected_variation =  this.$store.getters.getSelectedVariation;
        },        
    }
});