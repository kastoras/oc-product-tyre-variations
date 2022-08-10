export default Vue.component('v-tyre-variation-add-form', {  
    template: `
        <div>
            <div class="header">            
                <h4 class="title">Προσθήκη Διάστασης</h4>
            </div>

            <div>
                <form class="container-fluid" id="add-variation-form">          
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Κωδικός</span>
                                <input type="text" class="form-control" name="code" v-model="variation_to_add.code">
                            </div>   
                        </div>                
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Πλάτος</span>
                                <input type="text" class="form-control" name="width" v-model="variation_to_add.width">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Ύψος</span>
                                <input type="text" class="form-control" name="height" v-model="variation_to_add.height">
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Διάμετρος</span>
                                <input type="text" class="form-control" v-model="variation_to_add.diameter">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Διάσταση Ολικό</span>
                                <input type="text" class="form-control" name="size_overal" v-model="variation_to_add.size_overal">
                            </div>
                        </div>                                              
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Τιμή</span>
                                <input type="text" class="form-control" name="price" v-model="variation_to_add.price">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Εκπτωτική Τιμή</span>
                                <input type="text" class="form-control" name="price_discount" v-model="variation_to_add.price_discount">
                            </div>
                        </div>       
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Ποσότητα</span>
                                <input type="text" class="form-control" name="amount" v-model="variation_to_add.amount">
                            </div>
                        </div>                                       
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Σεζόν</span>
                                <select class="form-control" name="season" v-model="variation_to_add.season">
                                    <option value="Summer">Summer</option>
                                    <option value="Winter">Winter</option>
                                    <option value="All">All Season</option>
                                </select>                                
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Υγρό Οδόστρωμα</span>                                
                                <select class="form-control" name="wet_grib" v-model="variation_to_add.wet_grib">
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
                                <select class="form-control" name="fuel_efficiency" v-model="variation_to_add.fuel_efficiency">
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
                                <input type="text" class="form-control" v-model="variation_to_add.external_rollin">
                            </div>
                        </div> 
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Δείκτης Ταχύτητας</span>
                                <input type="text" class="form-control" name="speed" v-model="variation_to_add.speed">
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Δείκτης Φορτίου</span>
                                <input type="text" class="form-control" name="load_index" v-model="variation_to_add.load_index">
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Class</span>
                                <input type="text" class="form-control" name="tyre_class" v-model="variation_to_add.tyre_class">
                            </div>
                        </div>    
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Βάρος</span>
                                <input type="text" class="form-control" name="weight" v-model="variation_to_add.weight">
                            </div>
                        </div>                                                                    
                    </div>
                </form>                
            </div>            
            
            <div>
                <div class="form-group col-md-12">
                    <button @click="saveTyreVariation" type="button" class="btn btn-primary submit-add-btn">Αποθήκευση</button>
                    <button @click="cancelAdd" type="button" class="btn btn-warning">Επιστροφή</button>
                </div>
            </div>
        </div>
    `, 
    data() {
        return {
            basic_url_data : '',
            variation_to_add: {
                code:'',
                width:'',
                height:'',
                diameter:'',
                size_overal:'',
                price:'',
                price_discount:'',
                amount:'',
                season:'',
                wet_grib:'',
                fuel_efficiency:'',
                external_rollin:'',
                load_index:'',
                tyre_class:'',
                weight:'',
            }
        }
    },
    created() {
        this.basic_url_data =  this.$store.getters.getBasicUrlData;
    },
    methods: {
        saveTyreVariation() {

            var url = new URL(this.basic_url_data.site_url+ 'index.php')

            var params = {
                route: 'extension/module/product_tyre_variation/saveChangeAsync',
                user_token: this.basic_url_data.token,
                product_id: this.basic_url_data.product_id,
                formdata: JSON.stringify(this.variation_to_add)
            }
            
            url.search = new URLSearchParams(params).toString();
            
            fetch(url)
            .then(res => res.json())
            .then(data => {
                alert('Η εισαγωγή διάστασης ολοκληρώθηκε με επιτυχία.');
                this.$router.push('/');
            })
            .catch((error) => {
                alert('Εμφανίστηκε κάποιο πρόβλημα με την αποθήκευση.');
            });
        },
        cancelAdd(){
            if(confirm("Θα χαθούν τα δεδομένα σε περίπτωση που αφήσετε τη σελίδα, θέλετε να συνεχίσετε;")){
                this.$router.push('/');
            }
        }    
    }
});
