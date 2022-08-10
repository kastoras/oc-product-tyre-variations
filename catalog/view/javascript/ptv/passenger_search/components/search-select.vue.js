export default Vue.component('search-select', {
    template: `
        <div class="select">
            <select :name="selectname" v-model="selected_option" @change="changeSelectedOption()">
                <option value="">{{firstoption}}</option>
                <option v-for="option in select_options" :value="option">{{option}}</option>
            </select>
        </div>
    `,
    props:{
        selectname:{
            type: String,
            required: true
        },
        firstoption:{
            type: String,
            required: true
        },
        productcategory:{
            type: String,
            required: true            
        }
    },
    computed: Vuex.mapState(['selected_values']),
    data() {
        return {
            basic_url_data: '',
            select_options: [],
            selected_option: ''
        }
    },
    created() {        
        this.basic_url_data = this.$store.getters.getBasicUrlData;
        this.unsubscribe = this.$store.subscribe(
            (mutation, state) => {
                if (mutation.type === 'setSelectedValues') {
                    this.populateSelectOptions();
                }
            }
        );
    },
    mounted() {
        this.populateSelectOptions();
    },
    methods: {
        populateSelectOptions() {
            var url = this.basic_url_data.site_url;
            axios.get(url + 'index.php',{
                params: {
                    route:'extension/module/product_tyre_variation/getAvailablePassengerTyresSelectOptionsAsync',
                    measurment_type: this.selectname,
                    selected_vales: this.selected_values,
                    product_category:this.productcategory
                }
            })
            .then((result) => {
                this.select_options = result.data.data;
            });

        },
        changeSelectedOption() {
            this.selected_values[this.selectname] = this.selected_option;
            this.$store.commit('setSelectedValues', this.selected_values);
        }
    },
    beforeDestroy() {
        this.unsubscribe();
    },
});