export default Vue.component( 'v-tyre-variation-table',{
    template: `
        <div>
            <h1>Πίνακας Διαστάσεων</h1>
            <div class="col-md-3">
                <input type="text" class="form-control" v-model="filter" placeholder="Αναζήτηση" @keydown="$event.stopImmediatePropagation()">
            </div>
            <div class="col-md-12">
                <bootstrap-3-datatable :data="rows" :columns="columns" :per-page="10" :filter="filter" class="table table-striped table-bordered dataTable">
                    <template v-slot="{ row, columns }">
                        <tr>
                            <td>{{ row.code }}</td>
                            <td>{{ row.width }}</td>
                            <td>{{ row.height }}</td>
                            <td>{{ row.diameter }}</td>
                            <td>{{ row.price }}</td>
                            <td>{{ row.price_discount }}</td>
                            <td>{{ row.amount }}</td>
                            <td>{{ row.speed }}</td>
                            <td>{{ row.load_index }}</td>
                            <td>{{ row.wet_grib }}</td>
                            <td>{{ row.fuel_efficiency }}</td>
                            <td>{{ row.external_rollin }}</td>
                            <td>{{ row.season }}</td>
                            <td>{{ row.weight }}</td>
                            <td>{{ row.size_overal }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" @click="editVariation(row.code)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger" @click="deleteVariation(row.code)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    </template>
                </bootstrap-3-datatable>
                <bootstrap-3-datatable-pager v-model="page" type="abbreviated"></bootstrap-3-datatable-pager>
            </div>
        </div>
    `,
    data(){
        return{
            basic_url_data : '',
            columns: [
                { label: 'Κωδικός', field: 'code'},
                { label: 'Πλάτος', field: 'width'},
                { label: 'Ύψος', field: 'height'},
                { label: 'Διάμετρος', field: 'diameter'},
                { label: 'Τιμή', field: 'price'},
                { label: 'Εκπτωτική Τιμή', field: 'price_discount'},
                { label: 'Ποσότητα', field: 'amount'},
                { label: 'Δείκτης Ταχύτητας', field: 'speed'},
                { label: 'Δείκτης Φορτίου', field: 'load_index'},
                { label: 'Υγρό Οδόστρωμα', field: 'wet_grib'},
                { label: 'Καύσιμα', field: 'fuel_efficiency'},
                { label: 'Ήχος', field: 'external_rollin'},
                { label: 'Σεζόν', field: 'season'},
                { label: 'Βάρος', field: 'weight'},
                { label: 'Διάσταση Ολικό', field: 'size_overal'},
                { label: 'Ενέργειες' }
            ],
            rows: [],
            page: 1,
            filter: '',
            selected_variation: ''
        }
    },
    created(){
        this.basic_url_data =  this.$store.getters.getBasicUrlData;
        this.loadTableData();
    },
    methods:{
        loadTableData(){
            fetch(this.basic_url_data.site_url + "index.php?route=extension/module/product_tyre_variation/getVariationsAsync&user_token=" + this.basic_url_data.token + '&product_id=' + this.basic_url_data.product_id)
                .then(res => res.json())
                .then(res => {
                    if(res.data instanceof Array){
                        this.rows = res.data;
                    }
            });
        },
        editVariation($code){            
            this.selected_variation = this.rows.find(x => x.code === $code);
            this.$store.commit('setSelectedVariation', this.selected_variation);
            this.$router.push('edit-variation');
        },
        deleteVariation($code) {

            if(confirm("Θέλετε να προχωρήσετε σε οριστική διαγραφή διάστασης;")){

                var url = new URL(this.basic_url_data.site_url+ 'index.php')

                var params = {
                    route: 'extension/module/product_tyre_variation/deleteVariationAsync',
                    user_token: this.basic_url_data.token,
                    product_id: this.basic_url_data.product_id,
                    code: $code
                }
                
                url.search = new URLSearchParams(params).toString();
                    
                fetch(url)
                .then(res => res.json())
                .then(data => {                
                    alert(data.message);
                    this.loadTableData();
                })
                .catch((error) => {                
                    alert('Εμφανίστηκε κάποιο πρόβλημα με την αποθήκευση.');
                }); 
            }

        }
    }
});